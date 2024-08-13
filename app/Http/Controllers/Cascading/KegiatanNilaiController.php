<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_visi;
use App\Models\Cascading\Model_Kegiatan;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Kegiatan_Indikator;
use App\Models\Cascading\Model_Kegiatan_Nilai;
use App\Models\Cascading\Model_Program_Nilai;
use App\Models\Cascading\Model_Sasaran_Renstra_Indikator;
use App\Models\Cascading\Model_Sasaran_Renstra_Nilai;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Tujuan_Renstra_Indikator;
use App\Models\Cascading\Model_Tujuan_Renstra_Nilai;
use App\Models\Cascading\Model_Tujuan_Renstra;
use App\Models\Cascading\Model_Urusan_Indikator;
use App\Models\Cascading\Model_Urusan_Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use yajra\DataTables\DataTables;

class KegiatanNilaiController extends Controller
{
    public function api(Request $request)
    {
        $kegiatan_nilai = Model_Kegiatan_Nilai::where('id_indikator_kegiatan', $request->id_indikator_kegiatan)->get();

        return DataTables::of($kegiatan_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function index(Request $request)
    {
        $id_indikator_kegiatan = $request->id_indikator_kegiatan;
        if (!$id_indikator_kegiatan || !Model_Kegiatan_Indikator::where('id', $id_indikator_kegiatan)->first()) {
            return redirect()->route('setup.kegiatan_indikator.index');
        }

        $indikator = Model_Kegiatan_Indikator::where('id', $id_indikator_kegiatan)->get();
        $tahun  = Model_Visi::all();

        return view('cascading.kegiatan_nilai.index', compact('indikator', 'id_indikator_kegiatan', 'tahun'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
{
    $request->validate([
        "id_indikator_kegiatan" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Create the new entry in cascading_kegiatan_nilai
    $kegiatanNilai = Model_Kegiatan_Nilai::create([
        "id_indikator_kegiatan" => $request->id_indikator_kegiatan,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    return response()->json(["message" => "Berhasil menambahkan data!"], 200);
}



    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return Model_Kegiatan_Nilai::find($id);
    }

    public function update(Request $request, $id)
    {
        $model_kegiatan_nilai = Model_Kegiatan_Nilai::find($id);
        if (!$model_kegiatan_nilai) {
            return response()->json(["message" => "Data tidak ditemukan!"], 404);
        }
    
        $request->validate([
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);
    
        // Update the kegiatan nilai data
        $model_kegiatan_nilai->update([
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "triwulan" => $request->triwulan,
            "pagu" => $request->pagu,
            "target" => $request->target,
            "capaian" => $request->capaian,
            "creator" => Auth::user()->id,
        ]);
    
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }
    



    public function destroy(Request $request, $id)
    {
        $misi  = Model_Kegiatan_nilai::find($id);
    
        if ($misi && $misi->tujuan && is_iterable($misi->tujuan)) {
            $count = $misi->tujuan->count();
        } else {
            $count = 0;
        }
    
        if ($count > 0) {
            return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        }
    
        $misi->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }


}
