<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Tujuan_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanIndikatorController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $tujuan_indikator   = Model_Tujuan_Indikator::all();
        return DataTables::of($tujuan_indikator)
            ->addColumn('tujuan_nilai_count', function ($p) {
                $count = $p->tujuan_nilai->count();
                return "<a  href='".route('setup.tujuan_nilai.index')."?tujuan_nilai_id=".$p->id."'  title='Nilai Tujuan'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['tujuan_nilai_count', 'action'])
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
        // if (!$id_visi || !Model_Tujuan::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan_indikator.index');
        // }

        // $visi = Model_Tujuan::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $misi   = Model_Misi::all();
        $tujuan = Model_Tujuan::all();    // return view('cascading.tujuan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.tujuan_indikator.index', compact('tujuan','misi'));
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
            "id_tujuan" => 'required',
            "tujuan" => 'required',
        ]);

        Model_Tujuan_Indikator::create([
            "id_tujuan" => $request->id_tujuan,
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
            "tujuan" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
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