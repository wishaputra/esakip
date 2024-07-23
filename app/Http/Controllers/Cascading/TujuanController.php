<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanController extends Controller
{
    public function api()
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $tujuan   = Model_Tujuan::all();
        // if(Auth::user()->role == "Menpan"){
        //     return DataTables::of($tujuan)
        //     ->addColumn('tujuan_indikator_count', function ($p) {
        //         $count = $p->tujuan_indikator->count();
        //         return "<a  href='".route('setup.tujuan_menpan_indikator.index')."?id_tujuan=".$p->id."'  title='Indikator Tujuan'>".$count."</a>";
        //     })
        //     ->addColumn('action', function ($p) {
        //         return "
        //             <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
        //             <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
        //     })
        //     ->rawColumns(['tujuan_indikator_count', 'action'])
        //     ->toJson();
        // }
        // else{
            return DataTables::of($tujuan)
            ->addColumn('tujuan_indikator_count', function ($p) {
                $count = $p->tujuan_indikator->count();
                return "<a  href='".route('setup.tujuan_indikator.index')."?id_tujuan=".$p->id."'  title='Indikator Tujuan'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['tujuan_indikator_count', 'action'])
            ->toJson();
        // }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getMisiByTahun($id)
{
    $misi = Model_Misi::where('id_visi', $id)->get(['id', 'misi']);
    return response()->json($misi);
}

    public function index(Request $request)
    {
        // $id_visi = $request->id_visi;
        // if (!$id_visi || !Model_Tujuan::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_Tujuan::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $misi   = Model_Misi::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.tujuan.index', compact('tahun','misi'));
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
        // dd($request->file('file_kmz')->getMimeType());
        $request->validate([
            "id_misi" => 'required',
            "tujuan" => 'required',
        ]);

        Model_Tujuan::create([
            "id_visi" => $request->tahun,
            "id_misi" => $request->id_misi,
            "tujuan" => $request->tujuan,
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
        return Model_Tujuan::find($id);
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
        $misi  = Model_Tujuan::find($id);
        $rule = [
            "id_misi"   => 'required',
            "tujuan"    => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_visi" => $request->tahun,
            "id_misi" => $request->id_misi,
            "tujuan" => $request->tujuan,
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
    $misi  = Model_Tujuan::find($id);

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
