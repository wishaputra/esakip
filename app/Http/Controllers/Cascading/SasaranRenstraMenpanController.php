<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Tujuan_Renstra;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SasaranRenstraMenpanController extends Controller
{
    public function api_sasaran_renstra_menpan(Request $request)
    {
        $sasaran_renstra   = Model_Sasaran_Renstra::all();
        return DataTables::of($sasaran_renstra)
            ->addColumn('sasaran_renstra_indikator_count', function ($p) {
                $count = $p->sasaran_renstra_indikator->count();
                return "<a  href='".route('setup.sasaran_renstra_menpan_indikator.index')."?id_sasaran_renstra=".$p->id."'  title='Indikator Sasaran Renstra'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['sasaran_renstra_indikator_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getTujuanRenstraByTahun($id)
     {
         $tujuan_renstras = Model_Tujuan_Renstra::where('id_visi', $id)->pluck('tujuan_renstra', 'id')->toArray();
         return response()->json($tujuan_renstras);
     }
     



    public function index(Request $request)
    {
        // $id_visi = $request->id_visi;
        // if (!$id_visi || !Model_Sasaran_Renstra::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_Sasaran_Renstra::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $tujuan_renstra   = Model_Tujuan_Renstra::all();
        $sasaran_renstra   = Model_Sasaran_Renstra::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.sasaran_renstra_menpan.index', compact('tahun','tujuan_renstra', 'sasaran_renstra'));
    }

    
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
        // dd($request->file('file_kmz')->getMimeType());
        $request->validate([
            "id_tujuan_renstra" => 'required',
            "sasaran_renstra" => 'required',
        ]);

        Model_Sasaran_Renstra::create([
            "id_visi" => $request->tahun,
            "id_tujuan_renstra"    => $request->id_tujuan_renstra,
            "sasaran_renstra"=> $request->sasaran_renstra,
            "creator"       => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        return Model_Sasaran_Renstra::find($id);
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
        $misi  = Model_Sasaran_Renstra::find($id);
        $rule = [
            "sasaran_renstra" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_tujuan_renstra"    => $request->id_tujuan_renstra,
            "sasaran_renstra"=> $request->sasaran_renstra,
            "creator"       => Auth::user()->id,
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
    $misi  = Model_Sasaran_Renstra::find($id);

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
