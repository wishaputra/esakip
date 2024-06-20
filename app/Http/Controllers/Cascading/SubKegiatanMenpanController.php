<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Kegiatan;
use App\Models\Cascading\Model_SubKegiatan;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SubKegiatanMenpanController extends Controller
{
    public function api_subkegiatan_menpan(Request $request)
    {
        $subkegiatan   = Model_SubKegiatan::all();
        return DataTables::of($subkegiatan)
            ->addColumn('subkegiatan_indikator_count', function ($p) {
                $count = $p->subkegiatan_indikator->count();
                return "<a  href='".route('setup.sub_kegiatan_menpan_indikator.index')."?id_sub_kegiatan=".$p->id."'  title='Indikator Sub Kegiatan'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['subkegiatan_indikator_count', 'action'])
            ->toJson();
    }
    
    public function index(Request $request)
    {
        // $id_visi = $request->id_visi;
        // if (!$id_visi || !Model_kegiatan::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_kegiatan::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $kegiatan   = Model_Kegiatan::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.subkegiatan_menpan.index', compact('tahun','kegiatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getKegiatanByTahun($id)
     {
         $kegiatan = Model_Kegiatan::where('id_visi', $id)->pluck('kegiatan', 'id')->toArray();
         return response()->json($kegiatan);
     }
     
     //  public function getSasaranRenstraByTahun($id)
    //  {
    //      $sasaranRenstra = Model_Sasaran_Renstra::where('id_visi', $id)->pluck('sasaran_renstra', 'id')->toArray();
    //      return response()->json($sasaranRenstra);
    //  }

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
            "id_kegiatan" => 'required',
            "kode_sub_kegiatan" => 'required',
            "sub_kegiatan" => 'required',
        ]);

        Model_SubKegiatan::create([
            "id_visi" => $request->tahun,
            "id_kegiatan"    => $request->id_kegiatan,
            "kode_sub_kegiatan"=> $request->kode_sub_kegiatan,
            "sub_kegiatan"=> $request->sub_kegiatan,
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
        return Model_SubKegiatan::find($id);
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
        $misi  = Model_SubKegiatan::find($id);
        $rule = [
            "id_kegiatan" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_kegiatan"    => $request->id_kegiatan,
            "kode_sub_kegiatan"=> $request->kode_sub_kegiatan,
            "sub_kegiatan"=> $request->sub_kegiatan,
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
    $misi  = Model_SubKegiatan::find($id);

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
