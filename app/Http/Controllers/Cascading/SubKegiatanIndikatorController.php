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

class SubKegiatanIndikatorController extends Controller
{
    public function api(Request $request)
{
    $sub_kegiatan_indikator = Model_SubKegiatan_Indikator::all();

    return DataTables::of($sub_kegiatan_indikator)
        ->addColumn('subkegiatan_nilai_count', function ($p) {
            $count = $p->sub_kegiatan_nilai ? $p->sub_kegiatan_nilai->count() : 0;
            return "<a  href='".route('setup.sub_kegiatan_nilai.index')."?subkegiatan_nilai_id=".$p->id."'  title='Nilai Sub Kegiatan'>".$count."</a>";
        })
        ->addColumn('action', function ($p) {
            return "
                <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
        })
        ->rawColumns(['subkegiatan_nilai_count', 'action'])
        ->toJson();
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $id_visi = $request->id_visi;
        // if (!$id_visi || !Model_SubKegiatan::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.subkegiatan_indikator.index');
        // }

        // $visi = Model_SubKegiatan::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $sub_kegiatan   = Model_SubKegiatan::all();

        // return view('cascading.subkegiatan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.subkegiatan_indikator.index', compact('tahun','sub_kegiatan'));
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
