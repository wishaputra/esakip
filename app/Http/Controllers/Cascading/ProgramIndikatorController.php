<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Program_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProgramIndikatorController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $program_indikator   = Model_Program_Indikator::all();
        return DataTables::of($program_indikator)
            ->addColumn('program_nilai_count', function ($p) {
                $count = $p->program_nilai->count();
                return "<a  href='".route('setup.program_nilai.index')."?program_nilai_id=".$p->id."'  title='Nilai Program'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['program_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_program = $request->id_program;
        if (!$id_program || !Model_program::whereid($id_program)->first()) {
            return redirect()->route('setup.program.index');
        }

        // $visi = Model_Program::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $program = Model_Program::whereid($id_program)->get();
        // $sasaran = Model_Sasaran::whereid($id_sasaran)->get();
        
        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.program_indikator.index', compact('tahun','program'));
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
            "indikator" => 'required',
        ]);

        Model_Program_Indikator::create([
            "id_program" => $request->id_program,
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
        $misi  = Model_Program_indikator::find($id);
        $rule = [
            "indikator" => 'required',
            "id_program" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_program" => $request->id_program,
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
    $misi  = Model_Program_Indikator::find($id);

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
