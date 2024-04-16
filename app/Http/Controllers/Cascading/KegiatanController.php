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
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class KegiatanController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $kegiatan   = Model_Kegiatan::all();
        return DataTables::of($kegiatan)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
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
        // if (!$id_visi || !Model_kegiatan::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_kegiatan::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $program   = Model_Program::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.kegiatan.index', compact('tahun','program'));
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
            "id_program" => 'required',
            "kode_kegiatan" => 'required',
            "kegiatan" => 'required',
        ]);

        Model_Kegiatan::create([
            "id_program"    => $request->id_program,
            "kode_kegiatan"=> $request->kode_kegiatan,
            "kegiatan"=> $request->kegiatan,
            "creator"       => Auth::user()->id,
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
        $misi  = Model_Kegiatan::find($id);
        $rule = [
            "id_program" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_program"    => $request->id_program,
            "kode_kegiatan"=> $request->kode_kegiatan,
            "kegiatan"=> $request->kegiatan,
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
