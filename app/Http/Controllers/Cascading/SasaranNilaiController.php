<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Sasaran_Indikator;
use App\Models\Cascading\Model_Sasaran_Nilai;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SasaranNilaiController extends Controller
{
    public function api(Request $request)
    {
        $sasaran = Model_Sasaran_Nilai::all();
        return DataTables::of($sasaran)
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' onclick='edit(". $p->id. ")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(". $p->id. ")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->toJson();
    }

    public function index(Request $request)
    {
        $id_indikator = $request->id_indikator;
        if (!$id_indikator || !Model_Sasaran_Indikator::whereid($id_indikator)->first()) {
            return redirect()->route('setup.sasaran_indikator.index');
        }


        $indikator = Model_Sasaran_Indikator::whereid($id_indikator)->get();
        // $sasaran = Model_Sasaran::whereid($id_sasaran)->get();
        // $id_sasaran = Model_Sasaran_Indikator::all();

        return view('cascading.sasaran_nilai.index', compact('indikator'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            "id_indikator_sasaran" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_Sasaran_Nilai::create([
            "id_indikator_sasaran" => $request->id_indikator_sasaran,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
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
        return Model_Sasaran_Nilai::find($id);
    }

    public function update(Request $request, $id)
    {
        $sasaran_nilai  = Model_Sasaran_Nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $sasaran_nilai->update([
            "id_indikator_sasaran" => $request->id_indikator_sasaran,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "target" => $request->target,
            "capaian" => $request->capaian,
            "creator" => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    public function destroy(Request $request, $id)
    {
        $misi = Model_Sasaran_Nilai::find($id);

        if ($misi && $misi->tujuan && $misi->tujuan->count() > 0) {
            return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        }

        $misi->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}