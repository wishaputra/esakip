<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Kegiatan_Nilai;
use App\Models\Cascading\Model_Kegiatan_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class KegiatanNilaiController extends Controller
{
    public function api(Request $request)
    {
        $kegiatanNilai = Model_Kegiatan_Nilai::with('subKegiatanNilai')->get();

        return DataTables::of($kegiatanNilai)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                return '<a href="javascript:void(0)" onclick="edit('.$row->id.')" class="btn btn-primary btn-sm">Edit</a>';
            })
            ->make(true);
    }

    public function index(Request $request)
    {
        $id_indikator_kegiatan = $request->id_indikator_kegiatan;
        if (!$id_indikator_kegiatan || !Model_Kegiatan_Indikator::whereid($id_indikator_kegiatan)->first()) {
            return redirect()->route('setup.kegiatan_indikator.index');
        }

        $indikator = Model_Kegiatan_Indikator::whereid($id_indikator_kegiatan)->get();
        $tahun  = Model_Visi::all();

        return view('cascading.kegiatan_nilai.index', compact('indikator','id_indikator_kegiatan','tahun'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "id_indikator_kegiatan" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_Kegiatan_Nilai::create([
            "id_indikator_kegiatan" => $request->id_indikator_kegiatan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "triwulan" => $request->triwulan,
            "pagu" => $request->pagu,
            "target" => $request->target,
            "capaian" => $request->target,
            "creator" => Auth::user()->id,
        ]);

        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    public function edit($id)
    {
        return Model_Kegiatan_Nilai::find($id);
    }

    public function update(Request $request, $id)
    {
        $kegiatanNilai  = Model_Kegiatan_Nilai::find($id);
        $request->validate([
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        $kegiatanNilai->update([
            "id_indikator_kegiatan" => $request->id_indikator_kegiatan,
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
        $kegiatanNilai = Model_Kegiatan_Nilai::find($id);

        if ($kegiatanNilai && $kegiatanNilai->subKegiatanNilai && is_iterable($kegiatanNilai->subKegiatanNilai)) {
            $count = $kegiatanNilai->subKegiatanNilai->count();
        } else {
            $count = 0;
        }

        if ($count > 0) {
            return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        }

        $kegiatanNilai->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }

    public function updatePagu()
    {
        // Get all kegiatan_nilai records
        $kegiatanNilais = Model_Kegiatan_Nilai::all();

        foreach ($kegiatanNilais as $kegiatanNilai) {
            // Sum the pagu values of the related subkegiatan_nilais
            $totalPagu = $kegiatanNilai->subKegiatanNilai->sum('pagu');

            // Update the pagu column in kegiatan_nilai
            $kegiatanNilai->update(['pagu' => $totalPagu]);
        }

        return response()->json(['message' => 'Pagu values updated successfully.']);
    }
}
