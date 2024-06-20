<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Kegiatan_Nilai;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_SubKegiatan;
use App\Models\Cascading\Model_SubKegiatan_Indikator;
use App\Models\Cascading\Model_SubKegiatan_Nilai;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SubKegiatanMenpanNilaiController extends Controller
{
    public function api_subkegiatan_menpan_nilai(Request $request)
    {
        $subkegiatan_nilai = Model_subKegiatan_Nilai::whereid_indikator_sub_kegiatan($request->id_indikator_sub_kegiatan)->get();
    
        return DataTables::of($subkegiatan_nilai)
            ->addColumn('action', function ($p) {
                return "
                   <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['kegiatan_nilai_count', 'action'])
            ->toJson();
    }
    

    public function index(Request $request)
    {
        $id_indikator_sub_kegiatan = $request->id_indikator_sub_kegiatan;
        if (!$id_indikator_sub_kegiatan || !Model_SubKegiatan_Indikator::whereid($id_indikator_sub_kegiatan)->first()) {
            return redirect()->route('setup.subkegiatan_indikator.index');
        }

      
        $indikator = Model_SubKegiatan_Indikator::whereid($id_indikator_sub_kegiatan)->get();
        $tahun  = Model_Visi::all();

        // return view('cascading.kegiatan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.subkegiatan_menpan_nilai.index', compact('indikator', 'id_indikator_sub_kegiatan','tahun'));
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
            "id_indikator_sub_kegiatan" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_subKegiatan_Nilai::create([
            "id_indikator_sub_kegiatan" => $request->id_indikator_sub_kegiatan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "triwulan" => $request->triwulan,
            "target" => $request->target,
            "capaian" => $request->target,
            "creator" => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id, Model_subKegiatan_Nilai $model_subKegiatan_Nilai)
    {
        return Model_subKegiatan_nilai::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cascading\Model_Kegiatan_Nilai $model_kegiatan_nilai
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $model_subKegiatan_Nilai  = Model_subKegiatan_nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $model_subKegiatan_Nilai->update([
            "id_indikator_sub_kegiatan" => $request->id_indikator_sub_kegiatan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "triwulan" => $request->triwulan,
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
    $misi  = Model_subKegiatan_nilai::find($id);

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
