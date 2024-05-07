<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Kegiatan;
use App\Models\Cascading\Model_Kegiatan_Indikator;
use App\Models\Cascading\Model_program;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class KegiatanIndikatorController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $kegiatan_indikator   = Model_Kegiatan_Indikator::all();
        return DataTables::of($kegiatan_indikator)
            ->addColumn('kegiatan_nilai_count', function ($p) {
                $count = $p->kegiatan_nilai->count();
                return "<a  href='".route('setup.kegiatan_nilai.index')."?id_kegiatan_indikator=".$p->id."'  title='Nilai Kegiatan'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['kegiatan_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_kegiatan = $request->id_kegiatan;
        if (!$id_kegiatan || !Model_kegiatan::whereid($id_kegiatan)->first()) {
            return redirect()->route('setup.kegiatan.index');
        }

      
        $kegiatan = Model_kegiatan::whereid($id_kegiatan)->get();
        
        return view('cascading.kegiatan_indikator.index', compact('kegiatan'));
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
            "id_kegiatan" => 'required',
            "indikator" => 'required',
        ]);

        Model_Kegiatan_indikator::create([
            "id_kegiatan" => $request->id_kegiatan,
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
        return Model_Kegiatan::find($id);
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
        $misi  = Model_Kegiatan_indikator::find($id);
        $rule = [
            "kegiatan" => 'required',
            "indikator" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "kegiatan" => $request->tujuan,
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
    $misi  = Model_Kegiatan::find($id);

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
