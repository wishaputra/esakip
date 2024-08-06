<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Sasaran_Renstra_Indikator;
use App\Models\Cascading\Model_Sasaran_Renstra_Nilai;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SasaranRenstraNilaiController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $sasaran_renstra_nilai   = Model_Sasaran_Renstra_nilai::whereid_indikator_sasaran_renstra($request->id_indikator_sasaran_renstra)->get();
        return DataTables::of($sasaran_renstra_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['sasaran_renstra_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_sasaran_renstra_indikator = $request->id_sasaran_renstra_indikator;
        if (!$id_sasaran_renstra_indikator || !Model_Sasaran_Renstra_Indikator::whereid($id_sasaran_renstra_indikator)->first()) {
            return redirect()->route('setup.sasaran_renstra_indikator.index');
        }

        
        $indikator = Model_Sasaran_Renstra_Indikator::whereid($id_sasaran_renstra_indikator)->get();
        $tahun  = Model_Visi::all();

        return view('cascading.sasaran_renstra_nilai.index', compact('indikator','id_sasaran_renstra_indikator','tahun'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "id_indikator_sasaran_renstra" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_Sasaran_Renstra_Nilai::create([
            "id_indikator_sasaran_renstra" => $request->id_indikator_sasaran_renstra,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Model_Sasaran_Renstra_Nilai::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $misi  = Model_Sasaran_Renstra_Nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
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
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
{
    $misi  = Model_Sasaran_Renstra_Nilai::find($id);

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
