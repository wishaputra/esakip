<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_SubKegiatan;
use App\Models\Cascading\Model_SubKegiatan_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SubKegiatanMenpanIndikatorController extends Controller
{
    public function api_subkegiatan_menpan_indikator(Request $request)
{
    $sub_kegiatan_indikator = Model_SubKegiatan_Indikator::whereid_sub_kegiatan($request->id_sub_kegiatan)->get();

    return DataTables::of($sub_kegiatan_indikator)
        ->addColumn('subkegiatan_nilai_count', function ($p) {
            $count = $p->subkegiatan_nilai->count();
            return "<a  href='".route('setup.sub_kegiatan_menpan_nilai.index')."?id_indikator_sub_kegiatan=".$p->id."'  title='Nilai Sub Kegiatan'>".$count."</a>";
        })
        ->addColumn('action', function ($p) {
            return "
                <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
        })
        ->rawColumns(['subkegiatan_nilai_count', 'action'])
        ->toJson();
}
    
    public function index(Request $request)
    {
        $id_sub_kegiatan = $request->id_sub_kegiatan;
        if (!$id_sub_kegiatan || !Model_SubKegiatan::whereid($id_sub_kegiatan)->first()) {
            return redirect()->route('setup.subkegiatan.index');
        }

      
        $sub_kegiatan = Model_subkegiatan::whereid($id_sub_kegiatan)->get();

        // return view('cascading.subkegiatan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.subkegiatan_menpan_indikator.index', compact('sub_kegiatan','id_sub_kegiatan'));
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
            "id_sub_kegiatan" => 'required',
            "indikator" => 'required',
        ]);

        Model_SubKegiatan_Indikator::create([
            "id_sub_kegiatan" => $request->id_sub_kegiatan,
            "indikator" => $request->indikator,
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
        $misi  = Model_SubKegiatan_indikator::find($id);
        $rule = [
            "indikator" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
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
    $misi  = Model_SubKegiatan_Indikator ::find($id);

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
