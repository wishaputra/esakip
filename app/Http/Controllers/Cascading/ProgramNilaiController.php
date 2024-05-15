<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Program_Nilai;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Program_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class ProgramNilaiController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $program_nilai   = Model_Program_Nilai::whereid_indikator_program($request->id_indikator_program)->get();
        return DataTables::of($program_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_indikator_program = $request->id_indikator_program;
        if (!$id_indikator_program || !Model_Program_Indikator::whereid($id_indikator_program)->first()) {
            return redirect()->route('setup.program_indikator.index');
        }

        // $visi = Model_Program::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
       
        $indikator = Model_Program_Indikator::whereid($id_indikator_program)->get();
        
        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.program_nilai.index', compact('indikator','id_indikator_program'));
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
        $request->validate([
            "id_indikator_program" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_program_Nilai::create([
            "id_indikator_program" => $request->id_indikator_program,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "target" => $request->target,
            "capaian" => $request->capaian,
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
        return Model_Program_Nilai::find($id);
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
        $program_nilai  = Model_program_Nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $program_nilai->update([
            "id_program_indikator" => $request->id_program_indikator,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
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
    $misi  = Model_Program_nilai::find($id);

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
