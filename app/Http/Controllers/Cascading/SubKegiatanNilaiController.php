<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Kegiatan;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_SubKegiatan;
use App\Models\Cascading\Model_SubKegiatan_Indikator;
use App\Models\Cascading\Model_SubKegiatan_Nilai;
use App\Models\Cascading\Model_Kegiatan_Nilai;
use App\Models\Cascading\Model_Program_Nilai;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SubKegiatanNilaiController extends Controller
{
    public function api(Request $request)
    {
        $subkegiatan_nilai = Model_SubKegiatan_Nilai::where('id_indikator_sub_kegiatan', $request->id_indikator_sub_kegiatan)->get();
    
        return DataTables::of($subkegiatan_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['kegiatan_nilai_count', 'action'])
            ->toJson();
    }

    public function index(Request $request)
    {
        $id_indikator_sub_kegiatan = $request->id_indikator_sub_kegiatan;
        if (!$id_indikator_sub_kegiatan || !Model_SubKegiatan_Indikator::where('id', $id_indikator_sub_kegiatan)->first()) {
            return redirect()->route('setup.subkegiatan_indikator.index');
        }

        $indikator = Model_SubKegiatan_Indikator::where('id', $id_indikator_sub_kegiatan)->get();
        $tahun  = Model_Visi::all();

        return view('cascading.subkegiatan_nilai.index', compact('indikator', 'id_indikator_sub_kegiatan', 'tahun'));
    }

  
    public function create()
    {
        //
    }

  
    public function store(Request $request)
{
    $request->validate([
        "id_indikator_sub_kegiatan" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Create the new entry in cascading_sub_kegiatan_nilai
    $subKegiatanNilai = Model_SubKegiatan_Nilai::create([
        "id_indikator_sub_kegiatan" => $request->id_indikator_sub_kegiatan,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Get the id_kegiatan related to the indikator_sub_kegiatan
    $id_kegiatan = DB::table('cascading_sub_kegiatan')
                ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan.id', '=', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan')
                ->where('cascading_sub_kegiatan_indikator.id', $request->id_indikator_sub_kegiatan)
                ->pluck('cascading_sub_kegiatan.id_kegiatan')
                ->first();

    // Calculate total pagu for the kegiatan
    $totalPaguKegiatan = DB::table('cascading_sub_kegiatan_nilai')
                        ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_indikator.id', '=', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan')
                        ->join('cascading_sub_kegiatan', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan', '=', 'cascading_sub_kegiatan.id')
                        ->where('cascading_sub_kegiatan.id_kegiatan', $id_kegiatan)
                        ->sum('cascading_sub_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_kegiatan_nilai
    $model_kegiatan_nilai  = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function($query) use ($id_kegiatan) {
        $query->where('id_kegiatan', $id_kegiatan);
    })->first();

    if ($model_kegiatan_nilai) {
        $model_kegiatan_nilai->update(["pagu" => $totalPaguKegiatan]);
    }

    // Calculate total pagu for the program
    $id_program = Model_Kegiatan::where('id', $id_kegiatan)->pluck('id_program')->first();

    $totalPaguProgram = DB::table('cascading_kegiatan_nilai')
                        ->join('cascading_kegiatan_indikator', 'cascading_kegiatan_nilai.id_indikator_kegiatan', '=', 'cascading_kegiatan_indikator.id')
                        ->join('cascading_kegiatan', 'cascading_kegiatan_indikator.id_kegiatan', '=', 'cascading_kegiatan.id')
                        ->where('cascading_kegiatan.id_program', $id_program)
                        ->sum('cascading_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_program_nilai
    $model_program_nilai  = Model_Program_Nilai::where('id', $id_program)->first();

    if ($model_program_nilai) {
        $model_program_nilai->update(["pagu" => $totalPaguProgram]);
    }

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
    $model_subKegiatan_Nilai = Model_SubKegiatan_Nilai::find($id);
    if (!$model_subKegiatan_Nilai) {
        return response()->json(["message" => "Data tidak ditemukan!"], 404);
    }

    $request->validate([
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Get the old pagu value to be able to adjust the total
    $oldPagu = $model_subKegiatan_Nilai->pagu;

    $model_subKegiatan_Nilai->update([
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Get the id_kegiatan related to the indikator_sub_kegiatan
    $id_kegiatan = DB::table('cascading_sub_kegiatan')
                ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan.id', '=', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan')
                ->where('cascading_sub_kegiatan_indikator.id', $model_subKegiatan_Nilai->id_indikator_sub_kegiatan)
                ->pluck('cascading_sub_kegiatan.id_kegiatan')
                ->first();

    // Update total pagu for kegiatan
    $totalPaguKegiatan = DB::table('cascading_sub_kegiatan_nilai')
                        ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_indikator.id', '=', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan')
                        ->join('cascading_sub_kegiatan', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan', '=', 'cascading_sub_kegiatan.id')
                        ->where('cascading_sub_kegiatan.id_kegiatan', $id_kegiatan)
                        ->sum('cascading_sub_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_kegiatan_nilai
    $model_kegiatan_nilai  = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function($query) use ($id_kegiatan) {
        $query->where('id_kegiatan', $id_kegiatan);
    })->first();

    if ($model_kegiatan_nilai) {
        $model_kegiatan_nilai->update(["pagu" => $totalPaguKegiatan]);
    }

    // Calculate total pagu for the program
    $id_program = Model_Kegiatan::where('id', $id_kegiatan)->pluck('id_program')->first();

    $totalPaguProgram = DB::table('cascading_kegiatan_nilai')
                        ->join('cascading_kegiatan_indikator', 'cascading_kegiatan_nilai.id_indikator_kegiatan', '=', 'cascading_kegiatan_indikator.id')
                        ->join('cascading_kegiatan', 'cascading_kegiatan_indikator.id_kegiatan', '=', 'cascading_kegiatan.id')
                        ->where('cascading_kegiatan.id_program', $id_program)
                        ->sum('cascading_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_program_nilai
    $model_program_nilai  = Model_Program_Nilai::where('id', $id_program)->first();

    if ($model_program_nilai) {
        $model_program_nilai->update(["pagu" => $totalPaguProgram]);
    }

    return response()->json(["message" => "Berhasil merubah data!"], 200);
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $model_subKegiatan_Nilai = Model_SubKegiatan_Nilai::find($id);
    if (!$model_subKegiatan_Nilai) {
        return response()->json(["message" => "Data tidak ditemukan!"], 404);
    }

    // Get the pagu value before deletion
    $paguToDelete = $model_subKegiatan_Nilai->pagu;

    // Get the id_kegiatan related to the indikator_sub_kegiatan
    $id_kegiatan = DB::table('cascading_sub_kegiatan')
                ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan.id', '=', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan')
                ->where('cascading_sub_kegiatan_indikator.id', $model_subKegiatan_Nilai->id_indikator_sub_kegiatan)
                ->pluck('cascading_sub_kegiatan.id_kegiatan')
                ->first();

    // Delete the record
    $model_subKegiatan_Nilai->delete();

    // Recalculate total pagu for kegiatan
    $totalPaguKegiatan = DB::table('cascading_sub_kegiatan_nilai')
                        ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_indikator.id', '=', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan')
                        ->join('cascading_sub_kegiatan', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan', '=', 'cascading_sub_kegiatan.id')
                        ->where('cascading_sub_kegiatan.id_kegiatan', $id_kegiatan)
                        ->sum('cascading_sub_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_kegiatan_nilai
    $model_kegiatan_nilai  = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function($query) use ($id_kegiatan) {
        $query->where('id_kegiatan', $id_kegiatan);
    })->first();

    if ($model_kegiatan_nilai) {
        $model_kegiatan_nilai->update(["pagu" => $totalPaguKegiatan]);
    }

    // Calculate total pagu for the program
    $id_program = Model_Kegiatan::where('id', $id_kegiatan)->pluck('id_program')->first();

    $totalPaguProgram = DB::table('cascading_kegiatan_nilai')
                        ->join('cascading_kegiatan_indikator', 'cascading_kegiatan_nilai.id_indikator_kegiatan', '=', 'cascading_kegiatan_indikator.id')
                        ->join('cascading_kegiatan', 'cascading_kegiatan_indikator.id_kegiatan', '=', 'cascading_kegiatan.id')
                        ->where('cascading_kegiatan.id_program', $id_program)
                        ->sum('cascading_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_program_nilai
    $model_program_nilai  = Model_Program_Nilai::where('id', $id_program)->first();

    if ($model_program_nilai) {
        $model_program_nilai->update(["pagu" => $totalPaguProgram]);
    }

    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}


    private function updatePagu($id_indikator_sub_kegiatan)
    {
        // Get the ID of the related Kegiatan
        $id_kegiatan = DB::table('cascading_sub_kegiatan')
                        ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan.id', '=', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan')
                        ->where('cascading_sub_kegiatan_indikator.id', $id_indikator_sub_kegiatan)
                        ->pluck('cascading_sub_kegiatan.id_kegiatan')
                        ->first();

        if (!$id_kegiatan) {
            return;
        }

        // Calculate the total pagu
        $totalPaguKegiatan = DB::table('cascading_sub_kegiatan_nilai')
                            ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_indikator.id', '=', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan')
                            ->join('cascading_sub_kegiatan', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan', '=', 'cascading_sub_kegiatan.id')
                            ->where('cascading_sub_kegiatan.id_kegiatan', $id_kegiatan)
                            ->sum('cascading_sub_kegiatan_nilai.pagu');

        // Update the pagu in kegiatan_nilai
        $model_kegiatan_nilai = Model_Kegiatan_Nilai::find($id_kegiatan);
        if ($model_kegiatan_nilai) {
            $model_kegiatan_nilai->pagu = $totalPaguKegiatan;
            $model_kegiatan_nilai->save();
        }

        // Optionally, you can add logic to update pagu in other related models like Model_Program_Nilai
    }
}