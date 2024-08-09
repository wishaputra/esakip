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
use App\Models\Cascading\Model_Program;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Sasaran_Renstra_Nilai;
use App\Models\Cascading\Model_Sasaran_Renstra_Indikator;
use App\Models\Cascading\Model_Tujuan_Renstra_Nilai;
use App\Models\Cascading\Model_Tujuan_Renstra;
use App\Models\Cascading\Model_Tujuan_Renstra_Indikator;
use App\Models\Cascading\Model_Urusan_Nilai;
use App\Models\Cascading\Model_Urusan_Indikator;
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
    $model_program_nilai  = Model_Program_Nilai::where('id_indikator_program', $model_kegiatan_nilai->id_indikator_program)->first();

    if ($model_program_nilai) {
        $model_program_nilai->update(["pagu" => $totalPaguProgram]);
    }

    // Calculate total pagu for the sasaran_renstra
    $id_sasaran_renstra = Model_Program::where('id', $id_program)->pluck('id_sasaran_renstra')->first();

    $totalPaguSasaranRenstra = DB::table('cascading_program_nilai')
                                    ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                                    ->join('cascading_program', 'cascading_program_indikator.id_program', '=', 'cascading_program.id')
                                    ->where('cascading_program.id_sasaran_renstra', $id_sasaran_renstra)
                                    ->sum('cascading_program_nilai.pagu');

    $sasaranRenstraIndikatorIds = Model_Sasaran_Renstra_Indikator::where('id_sasaran_renstra', $id_sasaran_renstra)
                                                                    ->pluck('id')
                                                                    ->toArray();

    Model_Sasaran_Renstra_Nilai::whereIn('id_indikator_sasaran_renstra', $sasaranRenstraIndikatorIds)
                                ->update(["pagu" => $totalPaguSasaranRenstra]);

    // Calculate total pagu for the tujuan_renstra
    $id_tujuan_renstra = Model_Sasaran_Renstra::where('id', $id_sasaran_renstra)->pluck('id_tujuan_renstra')->first();

    $totalPaguTujuanRenstra = DB::table('cascading_sasaran_renstra_nilai')
                                    ->join('cascading_sasaran_renstra_indikator', 'cascading_sasaran_renstra_nilai.id_indikator_sasaran_renstra', '=', 'cascading_sasaran_renstra_indikator.id')
                                    ->join('cascading_sasaran_renstra', 'cascading_sasaran_renstra_indikator.id_sasaran_renstra', '=', 'cascading_sasaran_renstra.id')
                                    ->where('cascading_sasaran_renstra.id_tujuan_renstra', $id_tujuan_renstra)
                                    ->sum('cascading_sasaran_renstra_nilai.pagu');

    $tujuanRenstraIndikatorIds = Model_Tujuan_Renstra_Indikator::where('id_tujuan_renstra', $id_tujuan_renstra)
                                                                ->pluck('id')
                                                                ->toArray();

    Model_Tujuan_Renstra_Nilai::whereIn('id_indikator_tujuan_renstra', $tujuanRenstraIndikatorIds)
                                ->update(["pagu" => $totalPaguTujuanRenstra]);

    // Calculate total pagu for the urusan
    $id_urusan = Model_Tujuan_Renstra::where('id', $id_tujuan_renstra)->pluck('id_urusan')->first();

    $totalPaguUrusan = DB::table('cascading_tujuan_renstra_nilai')
                            ->join('cascading_tujuan_renstra_indikator', 'cascading_tujuan_renstra_nilai.id_indikator_tujuan_renstra', '=', 'cascading_tujuan_renstra_indikator.id')
                            ->join('cascading_tujuan_renstra', 'cascading_tujuan_renstra_indikator.id_tujuan_renstra', '=', 'cascading_tujuan_renstra.id')
                            ->where('cascading_tujuan_renstra.id_urusan', $id_urusan)
                            ->sum('cascading_tujuan_renstra_nilai.pagu');

    $urusanIndikatorIds = Model_Urusan_Indikator::where('id_urusan', $id_urusan)
                                                ->pluck('id')
                                                ->toArray();

    Model_Urusan_Nilai::whereIn('id_indikator_urusan', $urusanIndikatorIds)
                      ->update(["pagu" => $totalPaguUrusan]);

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

    // Update the Subkegiatan_Nilai
    $model_subKegiatan_Nilai->update([
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Get id_kegiatan related to the indikator_sub_kegiatan
    $id_kegiatan = DB::table('cascading_sub_kegiatan')
                    ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan.id', '=', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan')
                    ->where('cascading_sub_kegiatan_indikator.id', $model_subKegiatan_Nilai->id_indikator_sub_kegiatan)
                    ->pluck('cascading_sub_kegiatan.id_kegiatan')
                    ->first();

    // Update total pagu for Kegiatan_Nilai
    $totalPaguKegiatan = DB::table('cascading_sub_kegiatan_nilai')
                            ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_indikator.id', '=', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan')
                            ->join('cascading_sub_kegiatan', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan', '=', 'cascading_sub_kegiatan.id')
                            ->where('cascading_sub_kegiatan.id_kegiatan', $id_kegiatan)
                            ->sum('cascading_sub_kegiatan_nilai.pagu');

    $model_kegiatan_nilai  = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function($query) use ($id_kegiatan) {
        $query->where('id_kegiatan', $id_kegiatan);
    })->first();

    if ($model_kegiatan_nilai) {
        $model_kegiatan_nilai->update(["pagu" => $totalPaguKegiatan]);
    }

    // Update total pagu for Program_Nilai
    $id_program = Model_Kegiatan::where('id', $id_kegiatan)->pluck('id_program')->first();

    $totalPaguProgram = DB::table('cascading_kegiatan_nilai')
                            ->join('cascading_kegiatan_indikator', 'cascading_kegiatan_nilai.id_indikator_kegiatan', '=', 'cascading_kegiatan_indikator.id')
                            ->join('cascading_kegiatan', 'cascading_kegiatan_indikator.id_kegiatan', '=', 'cascading_kegiatan.id')
                            ->where('cascading_kegiatan.id_program', $id_program)
                            ->sum('cascading_kegiatan_nilai.pagu');

    $model_program_nilai  = Model_Program_Nilai::where('id_indikator_program', $model_kegiatan_nilai->id_indikator_program)->first();

    if ($model_program_nilai) {
        $model_program_nilai->update(["pagu" => $totalPaguProgram]);
    }

    // Update total pagu for Sasaran_Renstra_Nilai
    $id_sasaran_renstra = Model_Program::where('id', $id_program)->pluck('id_sasaran_renstra')->first();

    $totalPaguSasaranRenstra = DB::table('cascading_program_nilai')
                                    ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                                    ->join('cascading_program', 'cascading_program_indikator.id_program', '=', 'cascading_program.id')
                                    ->where('cascading_program.id_sasaran_renstra', $id_sasaran_renstra)
                                    ->sum('cascading_program_nilai.pagu');

    $sasaranRenstraIndikatorIds = Model_Sasaran_Renstra_Indikator::where('id_sasaran_renstra', $id_sasaran_renstra)
                                                                    ->pluck('id')
                                                                    ->toArray();

    Model_Sasaran_Renstra_Nilai::whereIn('id_indikator_sasaran_renstra', $sasaranRenstraIndikatorIds)
                                ->update(["pagu" => $totalPaguSasaranRenstra]);

    // Update total pagu for Tujuan_Renstra_Nilai
    $id_tujuan_renstra = Model_Sasaran_Renstra::where('id', $id_sasaran_renstra)->pluck('id_tujuan_renstra')->first();

    $totalPaguTujuanRenstra = DB::table('cascading_sasaran_renstra_nilai')
                                    ->join('cascading_sasaran_renstra_indikator', 'cascading_sasaran_renstra_nilai.id_indikator_sasaran_renstra', '=', 'cascading_sasaran_renstra_indikator.id')
                                    ->join('cascading_sasaran_renstra', 'cascading_sasaran_renstra_indikator.id_sasaran_renstra', '=', 'cascading_sasaran_renstra.id')
                                    ->where('cascading_sasaran_renstra.id_tujuan_renstra', $id_tujuan_renstra)
                                    ->sum('cascading_sasaran_renstra_nilai.pagu');

    $tujuanRenstraIndikatorIds = Model_Tujuan_Renstra_Indikator::where('id_tujuan_renstra', $id_tujuan_renstra)
                                                                ->pluck('id')
                                                                ->toArray();

    Model_Tujuan_Renstra_Nilai::whereIn('id_indikator_tujuan_renstra', $tujuanRenstraIndikatorIds)
                                ->update(["pagu" => $totalPaguTujuanRenstra]);

    // Update total pagu for Urusan_Nilai
    $id_urusan = Model_Tujuan_Renstra::where('id', $id_tujuan_renstra)->pluck('id_urusan')->first();

    $totalPaguUrusan = DB::table('cascading_tujuan_renstra_nilai')
                            ->join('cascading_tujuan_renstra_indikator', 'cascading_tujuan_renstra_nilai.id_indikator_tujuan_renstra', '=', 'cascading_tujuan_renstra_indikator.id')
                            ->join('cascading_tujuan_renstra', 'cascading_tujuan_renstra_indikator.id_tujuan_renstra', '=', 'cascading_tujuan_renstra.id')
                            ->where('cascading_tujuan_renstra.id_urusan', $id_urusan)
                            ->sum('cascading_tujuan_renstra_nilai.pagu');

    $urusanIndikatorIds = Model_Urusan_Indikator::where('id_urusan', $id_urusan)
                                                ->pluck('id')
                                                ->toArray();

    Model_Urusan_Nilai::whereIn('id_indikator_urusan', $urusanIndikatorIds)
                      ->update(["pagu" => $totalPaguUrusan]);

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

    // Delete the SubKegiatan Nilai entry
    $model_subKegiatan_Nilai->delete();

    // Update total pagu for kegiatan
    $totalPaguKegiatan = DB::table('cascading_sub_kegiatan_nilai')
                        ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_indikator.id', '=', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan')
                        ->join('cascading_sub_kegiatan', 'cascading_sub_kegiatan_indikator.id_sub_kegiatan', '=', 'cascading_sub_kegiatan.id')
                        ->where('cascading_sub_kegiatan.id_kegiatan', $id_kegiatan)
                        ->sum('cascading_sub_kegiatan_nilai.pagu');

    // Update the total pagu in cascading_kegiatan_nilai
    $model_kegiatan_nilai = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function($query) use ($id_kegiatan) {
        $query->where('id_kegiatan', $id_kegiatan);
    })->first();

    if ($model_kegiatan_nilai) {
        $model_kegiatan_nilai->update(["pagu" => $totalPaguKegiatan]);
    }

    // Calculate total pagu for the program
    $id_program = DB::table('cascading_kegiatan')
                    ->where('id', $id_kegiatan)
                    ->pluck('id_program')
                    ->first();

    if ($id_program) {
        $totalPaguProgram = DB::table('cascading_kegiatan_nilai')
                            ->join('cascading_kegiatan_indikator', 'cascading_kegiatan_nilai.id_indikator_kegiatan', '=', 'cascading_kegiatan_indikator.id')
                            ->join('cascading_kegiatan', 'cascading_kegiatan_indikator.id_kegiatan', '=', 'cascading_kegiatan.id')
                            ->where('cascading_kegiatan.id_program', $id_program)
                            ->sum('cascading_kegiatan_nilai.pagu');

        // Update the total pagu in cascading_program_nilai
        $model_program_nilai = Model_Program_Nilai::where('id_indikator_program', $id_program)->first();
        if ($model_program_nilai) {
            $model_program_nilai->update(["pagu" => $totalPaguProgram]);
        }

        // Calculate total pagu for sasaran_renstra
        $id_sasaran_renstra = DB::table('cascading_program')
                                ->where('id', $id_program)
                                ->pluck('id_sasaran_renstra')
                                ->first();

        if ($id_sasaran_renstra) {
            $totalPaguSasaranRenstra = DB::table('cascading_program_nilai')
                                        ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                                        ->join('cascading_program', 'cascading_program_indikator.id_program', '=', 'cascading_program.id')
                                        ->where('cascading_program.id_sasaran_renstra', $id_sasaran_renstra)
                                        ->sum('cascading_program_nilai.pagu');

            $sasaranRenstraIndikatorIds = Model_Sasaran_Renstra_Indikator::where('id_sasaran_renstra', $id_sasaran_renstra)
                                                                        ->pluck('id')
                                                                        ->toArray();

            Model_Sasaran_Renstra_Nilai::whereIn('id_indikator_sasaran_renstra', $sasaranRenstraIndikatorIds)
                                        ->update(["pagu" => $totalPaguSasaranRenstra]);

            // Calculate total pagu for tujuan_renstra
            $id_tujuan_renstra = Model_Sasaran_Renstra::where('id', $id_sasaran_renstra)->pluck('id_tujuan_renstra')->first();

            if ($id_tujuan_renstra) {
                $totalPaguTujuanRenstra = DB::table('cascading_sasaran_renstra_nilai')
                                            ->join('cascading_sasaran_renstra_indikator', 'cascading_sasaran_renstra_nilai.id_indikator_sasaran_renstra', '=', 'cascading_sasaran_renstra_indikator.id')
                                            ->join('cascading_sasaran_renstra', 'cascading_sasaran_renstra_indikator.id_sasaran_renstra', '=', 'cascading_sasaran_renstra.id')
                                            ->where('cascading_sasaran_renstra.id_tujuan_renstra', $id_tujuan_renstra)
                                            ->sum('cascading_sasaran_renstra_nilai.pagu');

                $tujuanRenstraIndikatorIds = Model_Tujuan_Renstra_Indikator::where('id_tujuan_renstra', $id_tujuan_renstra)
                                                                        ->pluck('id')
                                                                        ->toArray();

                Model_Tujuan_Renstra_Nilai::whereIn('id_indikator_tujuan_renstra', $tujuanRenstraIndikatorIds)
                                            ->update(["pagu" => $totalPaguTujuanRenstra]);

                // Calculate total pagu for urusan
                $id_urusan = Model_Tujuan_Renstra::where('id', $id_tujuan_renstra)->pluck('id_urusan')->first();

                if ($id_urusan) {
                    $totalPaguUrusan = DB::table('cascading_tujuan_renstra_nilai')
                                        ->join('cascading_tujuan_renstra_indikator', 'cascading_tujuan_renstra_nilai.id_indikator_tujuan_renstra', '=', 'cascading_tujuan_renstra_indikator.id')
                                        ->join('cascading_tujuan_renstra', 'cascading_tujuan_renstra_indikator.id_tujuan_renstra', '=', 'cascading_tujuan_renstra.id')
                                        ->where('cascading_tujuan_renstra.id_urusan', $id_urusan)
                                        ->sum('cascading_tujuan_renstra_nilai.pagu');

                    $urusanIndikatorIds = Model_Urusan_Indikator::where('id_urusan', $id_urusan)
                                                                ->pluck('id')
                                                                ->toArray();

                    Model_Urusan_Nilai::whereIn('id_indikator_urusan', $urusanIndikatorIds)
                                      ->update(["pagu" => $totalPaguUrusan]);
                }
            }
        }
    }

    return response()->json(["message" => "Data berhasil dihapus!"], 200);
}

}