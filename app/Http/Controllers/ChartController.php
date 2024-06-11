<?php

namespace App\Http\Controllers;

use App\Models\Cascading\Model_Urusan;
use Illuminate\Http\Request;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Tujuan_Renstra;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Kegiatan;
use App\Models\Cascading\Model_SubKegiatan;

class ChartController extends Controller
{
    public function getPeriods()
    {
        $visi = Model_Visi::distinct()->orderBy('tahun_awal')->get(['tahun_awal', 'tahun_akhir']);
        $title = "Cascading Struktur"; // Assuming you have a title variable
        return view('front.custom_page.struktur', compact('visi', 'title'));
    }

    public function loadChart(Request $request)
    {
        $periode = $request->input('periode');
        if ($periode) {
            list($tahun_awal, $tahun_akhir) = explode('-', $periode);
        } else {
            $tahun_awal = null;
            $tahun_akhir = null;
        }

        $visiQuery = Model_Visi::query();
        if ($tahun_awal && $tahun_akhir) {
            $visiQuery->where('tahun_awal', $tahun_awal)
                      ->where('tahun_akhir', $tahun_akhir);
        }
        $visiNodes = $visiQuery->with('misi')->get()->map(function($visi) {
            return [
                'key' => 'visi' . $visi->id,
                'visi' => $visi->visi,
                'tahun_awal' => $visi->tahun_awal,
                'tahun_akhir' => $visi->tahun_akhir,
            ];
        });

        $misiNodes = Model_Misi::whereIn('id_visi', $visiNodes->pluck('key')->map(function($key) {
            return substr($key, 4);
        }))->get()->map(function($misi) {
            return [
                'key' => 'misi' . $misi->id,
                'misi' => $misi->misi,
                'parent' => 'visi' . $misi->id_visi,
            ];
        });

        $tujuanNodes = Model_Tujuan::whereIn('id_misi', $misiNodes->pluck('key')->map(function($key) {
            return substr($key, 4);
        }))->get()->map(function($tujuan) {
            return [
                'key' => 'tujuan' . $tujuan->id,
                'tujuan' => $tujuan->tujuan,
                'parent' => 'misi' . $tujuan->id_misi,
            ];
        });

        $sasaranNodes = Model_Sasaran::whereIn('id_tujuan', $tujuanNodes->pluck('key')->map(function($key) {
            return intval(substr($key, 6)); // Adjust the substring position to match 'sasaran' + id
        }))->get()->map(function($sasaran) {
            return [
                'key' => 'sasaran' . $sasaran->id,
                'sasaran' => $sasaran->sasaran,
                'parent' => 'tujuan' . $sasaran->id_tujuan,
            ];
        });

        $urusanNodes = Model_Urusan::whereIn('id_sasaran', $sasaranNodes->pluck('key')->map(function($key) {
            return intval(substr($key, 7)); // Adjust the substring position to match 'urusan' + id
        }))->get()->map(function($urusan) {
            return [
                'key' => 'urusan' . $urusan->id,
                'urusan' => $urusan->urusan,
                'parent' => 'sasaran' . $urusan->id_sasaran,
                // Add other necessary fields here
            ];
        });
        
        $tujuanRenstraNodes = Model_Tujuan_Renstra::whereIn('id_urusan', $urusanNodes->pluck('key')->map(function($key) {
            return intval(substr($key, 6)); // Adjust the substring position to match 'tujuanRenstra' + id
        }))->get()->map(function($tujuanRenstra) {
            return [
                'key' => 'tujuanRenstra' . $tujuanRenstra->id,
                'tujuanRenstra' => $tujuanRenstra->tujuan_renstra,
                'parent' => 'urusan' . $tujuanRenstra->id_urusan,
                // Add other necessary fields here
            ];
        });

        $sasaranRenstraNodes = Model_Sasaran_Renstra::whereIn('id_tujuan_renstra', $tujuanRenstraNodes->pluck('key')->map(function($key) {
            return substr($key, 13);
        }))->get()->map(function($sasaranRenstra) {
            return [
                'key' => 'sasaranRenstra' . $sasaranRenstra->id,
                'sasaranRenstra' => $sasaranRenstra->sasaran_renstra,
                'parent' => 'tujuanRenstra' . $sasaranRenstra->id_tujuan_renstra,
            ];
        });

        $programNodes = Model_Program::whereIn('id_sasaran_renstra', $sasaranRenstraNodes->pluck('key')->map(function($key) {
            return substr($key, 14);
        }))->get()->map(function($program) {
            return [
                'key' => 'program' . $program->id,
                'program' => $program->program,
                'parent' => 'sasaranRenstra' . $program->id_sasaran_renstra,
            ];
        });

        $kegiatanNodes = Model_Kegiatan::whereIn('id_program', $programNodes->pluck('key')->map(function($key) {
            return substr($key, 7);
        }))->get()->map(function($kegiatan) {
            return [
                'key' => 'kegiatan' . $kegiatan->id,
                'kegiatan' => $kegiatan->kegiatan,
                'parent' => 'program' . $kegiatan->id_program,
            ];
        });

        $subkegiatanNodes = Model_SubKegiatan::whereIn('id_kegiatan', $kegiatanNodes->pluck('key')->map(function($key) {
            return intval(substr($key, 8)); // Adjust the substring position to match 'subkegiatan' + id
        }))->get()->map(function($sub_kegiatan) {
            return [
                'key' => 'subkegiatan' . $sub_kegiatan->id,
                'sub_kegiatan' => $sub_kegiatan->sub_kegiatan,
                'parent' => 'kegiatan' . $sub_kegiatan->id_kegiatan,
                // Add other necessary fields here
            ];
        });

        $nodes = $visiNodes->concat($misiNodes)->concat($tujuanNodes)->concat($sasaranNodes)->concat($urusanNodes)->concat($tujuanRenstraNodes)->concat($sasaranRenstraNodes)->concat($programNodes)->concat($kegiatanNodes)->concat($subkegiatanNodes);

$links = $misiNodes->map(function($misi) {
    return ['from' => $misi['parent'], 'to' => $misi['key']];
})->concat($tujuanNodes->map(function($tujuan) {
    return ['from' => $tujuan['parent'], 'to' => $tujuan['key']];
}))->concat($sasaranNodes->map(function($sasaran) {
    return ['from' => $sasaran['parent'], 'to' => $sasaran['key']];
}))->concat($urusanNodes->map(function($urusan) {
    return ['from' => $urusan['parent'], 'to' => $urusan['key']];
}))->concat($tujuanRenstraNodes->map(function($tujuanRenstra) {
    return ['from' => $tujuanRenstra['parent'], 'to' => $tujuanRenstra['key']];
}))->concat($sasaranRenstraNodes->map(function($sasaranRenstra) {
    return ['from' => $sasaranRenstra['parent'], 'to' => $sasaranRenstra['key']];
}))->concat($programNodes->map(function($program) {
    return ['from' => $program['parent'], 'to' => $program['key']];
}))->concat($kegiatanNodes->map(function($kegiatan) {
    return ['from' => $kegiatan['parent'], 'to' => $kegiatan['key']];
}))->concat($subkegiatanNodes->map(function($sub_kegiatan) {
    return ['from' => $sub_kegiatan['parent'], 'to' => $sub_kegiatan['key']];
}));

        $response = [
            'nodeDataArray' => $nodes->toArray(),
            'linkDataArray' => $links->toArray(),
        ];

        return response()->json($response);
    }
}