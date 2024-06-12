<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Urusan_Indikator;
use App\Models\Cascading\Model_Urusan_Nilai;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Urusan;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UrusanOpdNilaiController extends Controller
{
    public function api_opd_nilai(Request $request)
    {
        $urusan = Model_Urusan_Nilai::whereid_indikator_urusan($request->id_indikator_urusan)->get();
        return DataTables::of($urusan)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(". $p->id. ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->toJson();
    }

    public function index(Request $request)
    {
        $id_indikator = $request->id_indikator;
        if (!$id_indikator || !Model_Urusan_Indikator::whereid($id_indikator)->first()) {
            return redirect()->route('setup.urusan_indikator.index');
        }


        $indikator = Model_Urusan_Indikator::whereid($id_indikator)->get();
        // $sasaran = Model_Sasaran::whereid($id_sasaran)->get();
        // $id_sasaran = Model_Sasaran_Indikator::all();

        return view('cascading.urusan_opd_nilai.index', compact('indikator','id_indikator'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "id_indikator_urusan" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_Urusan_Nilai::create([
            "id_indikator_urusan" => $request->id_indikator_urusan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "triwulan" => $request->triwulan,
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
        return Model_Urusan_Nilai::find($id);
    }

    public function update(Request $request, $id)
    {
        $urusan_nilai  = Model_Urusan_Nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $urusan_nilai->update([
            "id_indikator_urusan" => $request->id_indikator_urusan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "triwulan" => $request->triwulan,
            "target" => $request->target,
            "capaian" => $request->capaian,
            "creator" => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    public function destroy(Request $request, $id)
    {
        $misi = Model_Urusan_Nilai::find($id);

        if ($misi && $misi->tujuan && $misi->tujuan->count() > 0) {
            return response()->json(["message" => "<center>Hapus Indikator terlebih dahulu</center>"], 500);
        }

        $misi->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}