<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Sasaran_Renstra;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Sasaran_Renstra_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SasaranRenstraIndikatorController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $sasaran_renstra_indikator   = Model_Sasaran_Renstra_Indikator::all();
        return DataTables::of($sasaran_renstra_indikator)
            ->addColumn('sasaran_renstra_nilai_count', function ($p) {
                $count = $p->sasaran_renstra_nilai->count();
                return "<a  href='".route('setup.sasaran_renstra_nilai.index')."?id_sasaran_renstra_indikator=".$p->id."'  title='Nilai Sasaran Renstra'>".$count."</a>";
            })
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
        $id_sasaran_renstra = $request->id_sasaran_renstra;
        if (!$id_sasaran_renstra || !Model_Sasaran_Renstra::whereid($id_sasaran_renstra)->first()) {
            return redirect()->route('setup.sasaran_renstra.index');
        }

        
        $sasaran_renstra = Model_Sasaran_Renstra::whereid($id_sasaran_renstra)->get();

        return view('cascading.sasaran_renstra_indikator.index', compact('sasaran_renstra'));
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
        "id_sasaran_renstra" => 'required',
        "indikator" => 'required',
    ]);

    $sasaran_renstra = Model_Sasaran_Renstra::find($request->id_sasaran_renstra);

    Model_Sasaran_Renstra_Indikator::create([
        "id_sasaran_renstra" => $sasaran_renstra->id,
        "indikator" => $request->indikator,
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
        return Model_Sasaran_Renstra_Indikator::find($id);
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
        $misi  = Model_Sasaran_Renstra_Indikator::find($id);
        $rule = [
            "indikator" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_sasaran_renstra_indikator" => $request->id_sasaran_rensta_indikator,
            "indikator" => $request->indikator,
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
    $sasaran_renstra  = Model_Sasaran_Renstra_Indikator::find($id);

    if ($sasaran_renstra && $sasaran_renstra->indikator && is_iterable($sasaran_renstra->indikator)) {
        $count = $sasaran_renstra->indikator->count();
    } else {
        $count = 0;
    }

    if ($count > 0) {
        return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
    }

    $sasaran_renstra->delete();
    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}
}
