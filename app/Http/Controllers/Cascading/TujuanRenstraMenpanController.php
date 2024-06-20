<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Urusan;
use App\Models\Cascading\Model_Tujuan_Renstra;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanRenstraMenpanController extends Controller
{
    public function api_tujuan_renstra_menpan(Request $request)
    {
        $tujuan_renstra   = Model_Tujuan_Renstra::all();
        return DataTables::of($tujuan_renstra)
            ->addColumn('tujuan_renstra_indikator_count', function ($p) {
                $count = $p->tujuan_renstra_indikator->count();
                return "<a  href='".route('setup.tujuan_renstra_menpan_indikator.index')."?id_tujuan_renstra=".$p->id."'  title='Indikator Tujuan Renstra'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                   <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['tujuan_renstra_indikator_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getSasaranByTahun($id)
{
    $urusan = Model_Urusan::where('id_visi', $id)->get();
    return response()->json($urusan->pluck('urusan', 'id'));
}

     

    public function index(Request $request)
    {
        // $id_visi = $request->id_visi;
        // if (!$id_visi || !Model_Tujuan_Renstra::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_Tujuan_Renstra::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $urusan   = Model_Urusan::all();
        $opd    = Model_Perangkat_Daerah::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.tujuan_renstra_menpan.index', compact('tahun','urusan','opd'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        // dd($request->file('file_kmz')->getMimeType());
        $request->validate([
            "id_urusan" => 'required',
            "id_perangkat_daerah" => 'required',
            "tujuan_renstra" => 'required',
        ]);

        Model_Tujuan_Renstra::create([
            "id_visi" => $request->tahun,
            "id_urusan"    => $request->id_urusan,
            "id_perangkat_daerah"        => $request->id_perangkat_daerah,
            "tujuan_renstra"=> $request->tujuan_renstra,
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
        return Model_Tujuan_Renstra::find($id);
    }

    
    public function update(Request $request, $id)
    {
        $misi  = Model_Tujuan_Renstra::find($id);
        $rule = [
            "tujuan_renstra" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_urusan"    => $request->id_urusan,
            "id_perangkat_daerah"        => $request->id_perangkat_daerah,
            "tujuan_renstra"=> $request->tujuan_renstra,
            "creator"       => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    
    public function destroy(Request $request, $id)
{
    $misi  = Model_Tujuan_Renstra::find($id);

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
