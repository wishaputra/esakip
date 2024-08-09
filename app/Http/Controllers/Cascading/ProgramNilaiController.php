<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Program_Nilai;
use App\Models\Cascading\Model_sasaran_renstra_Nilai;
use App\Models\Cascading\Model_sasaran_renstra_indikator;
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
    
    public function index(Request $request)
    {
        $id_indikator_program = $request->id_indikator_program;
        if (!$id_indikator_program || !Model_Program_Indikator::whereid($id_indikator_program)->first()) {
            return redirect()->route('setup.program_indikator.index');
        }

        // $visi = Model_Program::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
       
        $indikator = Model_Program_Indikator::whereid($id_indikator_program)->get();
        $tahun  = Model_Visi::all();
        
        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.program_nilai.index', compact('indikator','id_indikator_program','tahun'));
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
    $request->validate([
        "id_indikator_program" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Create the new entry in cascading_program_nilai
    $programNilai = Model_Program_Nilai::create([
        "id_indikator_program" => $request->id_indikator_program,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Get the related id_program from cascading_program_indikator
    $id_program = Model_Program_Indikator::where('id', $request->id_indikator_program)
                                          ->pluck('id_program')
                                          ->first();

    // Calculate total pagu for the program
    $totalPaguProgram = DB::table('cascading_program_nilai')
                        ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                        ->where('cascading_program_indikator.id_program', $id_program)
                        ->sum('cascading_program_nilai.pagu');

    // Update the total pagu in cascading_program
    $model_program = Model_Program::find($id_program);
    if ($model_program) {
        $model_program->update(["pagu" => $totalPaguProgram]);
    }

    // Get the id_sasaran_renstra related to the program
    $id_sasaran_renstra = Model_Program::where('id', $id_program)
                                        ->pluck('id_sasaran_renstra')
                                        ->first();

    // Calculate total pagu for the sasaran renstra
    $totalPaguSasaranRenstra = DB::table('cascading_program_nilai')
                                ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                                ->join('cascading_program', 'cascading_program_indikator.id_program', '=', 'cascading_program.id')
                                ->where('cascading_program.id_sasaran_renstra', $id_sasaran_renstra)
                                ->sum('cascading_program_nilai.pagu');

    // Get the related sasaran_renstra_indikator IDs
    $sasaranRenstraIndikatorIds = Model_Sasaran_Renstra_Indikator::where('id_sasaran_renstra', $id_sasaran_renstra)
                                                                ->pluck('id')
                                                                ->toArray();

    // Update the total pagu in cascading_sasaran_renstra_nilai
    Model_Sasaran_Renstra_Nilai::whereIn('id_indikator_sasaran_renstra', $sasaranRenstraIndikatorIds)
                                ->update(["pagu" => $totalPaguSasaranRenstra]);

    return response()->json(["message" => "Berhasil menambahkan data!"], 200);
}


  
    public function show($id)
    {
        //
    }

    
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
    $program_nilai = Model_Program_Nilai::find($id);
    
    $rule = [
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ];

    $request->validate($rule);

    // Update the existing entry in cascading_program_nilai
    $program_nilai->update([
        "id_indikator_program" => $request->id_indikator_program,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Get the related id_program from cascading_program_indikator
    $id_program = Model_Program_Indikator::where('id', $request->id_indikator_program)
                                          ->pluck('id_program')
                                          ->first();

    // Calculate total pagu for the program
    $totalPaguProgram = DB::table('cascading_program_nilai')
                        ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                        ->where('cascading_program_indikator.id_program', $id_program)
                        ->sum('cascading_program_nilai.pagu');

    // Update the total pagu in cascading_program
    $model_program = Model_Program::find($id_program);
    if ($model_program) {
        $model_program->update(["pagu" => $totalPaguProgram]);
    }

    // Get the id_sasaran_renstra related to the program
    $id_sasaran_renstra = Model_Program::where('id', $id_program)
                                        ->pluck('id_sasaran_renstra')
                                        ->first();

    // Calculate total pagu for the sasaran renstra
    $totalPaguSasaranRenstra = DB::table('cascading_program_nilai')
                                ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                                ->join('cascading_program', 'cascading_program_indikator.id_program', '=', 'cascading_program.id')
                                ->where('cascading_program.id_sasaran_renstra', $id_sasaran_renstra)
                                ->sum('cascading_program_nilai.pagu');

    // Get the related sasaran_renstra_indikator IDs
    $sasaranRenstraIndikatorIds = Model_Sasaran_Renstra_Indikator::where('id_sasaran_renstra', $id_sasaran_renstra)
                                                                ->pluck('id')
                                                                ->toArray();

    // Update the total pagu in cascading_sasaran_renstra_nilai
    Model_Sasaran_Renstra_Nilai::whereIn('id_indikator_sasaran_renstra', $sasaranRenstraIndikatorIds)
                                ->update(["pagu" => $totalPaguSasaranRenstra]);

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
    // Find the entry in cascading_program_nilai
    $programNilai = Model_Program_Nilai::find($id);

    if (!$programNilai) {
        return response()->json(["message" => "Data tidak ditemukan!"], 404);
    }

    // Get the id_program related to the indikator_program
    $id_program = Model_Program_Indikator::where('id', $programNilai->id_indikator_program)
                                          ->pluck('id_program')
                                          ->first();

    if (!$id_program) {
        return response()->json(["message" => "Program tidak ditemukan!"], 404);
    }

    // Delete the program_nilai entry
    $programNilai->delete();

    // Calculate total pagu for the program
    $totalPaguProgram = DB::table('cascading_program_nilai')
                        ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                        ->where('cascading_program_indikator.id_program', $id_program)
                        ->sum('cascading_program_nilai.pagu');

    // Update the total pagu in cascading_program
    $model_program = Model_Program::find($id_program);
    if ($model_program) {
        $model_program->update(["pagu" => $totalPaguProgram]);
    }

    // Calculate total pagu for the sasaran renstra
    $id_sasaran_renstra = Model_Program::where('id', $id_program)
                                        ->pluck('id_sasaran_renstra')
                                        ->first();

    if ($id_sasaran_renstra) {
        $totalPaguSasaranRenstra = DB::table('cascading_program_nilai')
                                    ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                                    ->join('cascading_program', 'cascading_program_indikator.id_program', '=', 'cascading_program.id')
                                    ->where('cascading_program.id_sasaran_renstra', $id_sasaran_renstra)
                                    ->sum('cascading_program_nilai.pagu');

        // Get the related sasaran_renstra_indikator IDs
        $sasaranRenstraIndikatorIds = Model_Sasaran_Renstra_Indikator::where('id_sasaran_renstra', $id_sasaran_renstra)
                                                                    ->pluck('id')
                                                                    ->toArray();

        // Update the total pagu in cascading_sasaran_renstra_nilai
        Model_Sasaran_Renstra_Nilai::whereIn('id_indikator_sasaran_renstra', $sasaranRenstraIndikatorIds)
                                    ->update(["pagu" => $totalPaguSasaranRenstra]);
    }

    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}

}
