<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Sasaran_Renstra;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{
    public function api(Request $request)
    {
        $program   = Model_Program::all();
        return DataTables::of($program)
            ->addColumn('program_indikator_count', function ($p) {
                $count = $p->program_indikator->count();
                return "<a  href='".route('setup.program_indikator.index')."?program_id=".$p->id."'  title='Indikator Program'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['program_indikator_count', 'action'])
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
        // if (!$id_visi || !Model_Program::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_Program::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $sasaran_renstra   = Model_Sasaran_Renstra::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.program.index', compact('tahun','sasaran_renstra'));
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
            "id_sasaran_renstra" => 'required',
            "kode_program" => 'required',
            "program" => 'required',
        ]);

        Model_Program::create([
            "id_sasaran_renstra"    => $request->id_sasaran_renstra,
            "kode_program"=> $request->kode_program,
            "program"=> $request->program,
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
        return Model_Program::find($id);
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
        $misi  = Model_Program::find($id);
        $rule = [
            "id_sasaran_renstra" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_sasaran_renstra"    => $request->id_sasaran_renstra,
            "kode_program"=> $request->kode_program,
            "program"=> $request->program,
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
    $misi  = Model_Program::find($id);

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
