<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Tujuan_Indikator;
use App\Models\Cascading\Model_Tujuan_Nilai;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanNilaiController extends Controller
{
    public function api(Request $request)
    {
        $tujuan = Model_Tujuan_Nilai::whereid_indikator_tujuan($request->id_indikator_tujuan)->get();
        return DataTables::of($tujuan)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(". $p->id. ")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(". $p->id. ")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->toJson();
    }

    public function index(Request $request)
    {
        $id_indikator_tujuan = $request->id_indikator_tujuan;
        if (!$id_indikator_tujuan || !Model_Tujuan_Indikator::whereid($id_indikator_tujuan)->first()) {
            return redirect()->route('setup.tujuan_indikator.index');
        }


        $indikator = Model_Tujuan_Indikator::whereid($id_indikator_tujuan)->get();
        

        return view('cascading.tujuan_nilai.index', compact('indikator','id_indikator_tujuan'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "id_indikator_tujuan" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            // "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_Tujuan_Nilai::create([
            "id_indikator_tujuan" => $request->id_indikator_tujuan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            // "pagu" => $request->pagu,
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
        return Model_tujuan_Nilai::find($id);
    }

    public function update(Request $request, $id)
    {
        $tujuan_nilai  = Model_Tujuan_Nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            // "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $tujuan_nilai->update([
            "id_tujuan_tujuan" => $request->id_tujuan_tujuan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            // "pagu" => $request->pagu,
            "target" => $request->target,
            "capaian" => $request->capaian,
            "creator" => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    public function destroy(Request $request, $id)
    {
        $misi = Model_Tujuan_Nilai::find($id);

        if ($misi && $misi->tujuan && $misi->tujuan->count() > 0) {
            return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        }

        $misi->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}