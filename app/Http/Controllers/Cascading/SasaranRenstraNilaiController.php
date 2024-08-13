<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran_Renstra;
use App\Models\Cascading\Model_Sasaran_Renstra_Indikator;
use App\Models\Cascading\Model_Sasaran_Renstra_Nilai;
use App\Models\Cascading\Model_Tujuan_Renstra_Nilai;
use App\Models\Cascading\Model_Tujuan_Renstra_Indikator;
use App\Models\Cascading\Model_Urusan_Nilai;
use App\Models\Cascading\Model_Urusan_Indikator;
use App\Models\Cascading\Model_Tujuan_Renstra;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SasaranRenstraNilaiController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $sasaran_renstra_nilai   = Model_Sasaran_Renstra_nilai::whereid_indikator_sasaran_renstra($request->id_indikator_sasaran_renstra)->get();
        return DataTables::of($sasaran_renstra_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['sasaran_renstra_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_sasaran_renstra_indikator = $request->id_sasaran_renstra_indikator;
        if (!$id_sasaran_renstra_indikator || !Model_Sasaran_Renstra_Indikator::whereid($id_sasaran_renstra_indikator)->first()) {
            return redirect()->route('setup.sasaran_renstra_indikator.index');
        }

        
        $indikator = Model_Sasaran_Renstra_Indikator::whereid($id_sasaran_renstra_indikator)->get();
        $tahun  = Model_Visi::all();

        return view('cascading.sasaran_renstra_nilai.index', compact('indikator','id_sasaran_renstra_indikator','tahun'));
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
        "id_indikator_sasaran_renstra" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Create the new entry in cascading_sasaran_renstra_nilai
    $sasaranRenstraNilai = Model_Sasaran_Renstra_Nilai::create([
        "id_indikator_sasaran_renstra" => $request->id_indikator_sasaran_renstra,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
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
        return Model_Sasaran_Renstra_Nilai::find($id);
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
    // Validate the request
    $request->validate([
        "id_indikator_sasaran_renstra" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Find the existing entry
    $sasaranRenstraNilai = Model_Sasaran_Renstra_Nilai::find($id);

    if (!$sasaranRenstraNilai) {
        return response()->json(["message" => "Data not found!"], 404);
    }

    // Update the existing entry
    $sasaranRenstraNilai->update([
        "id_indikator_sasaran_renstra" => $request->id_indikator_sasaran_renstra,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
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
    // Find the entry to delete
    $sasaranRenstraNilai = Model_Sasaran_Renstra_Nilai::find($id);

    if (!$sasaranRenstraNilai) {
        return response()->json(["message" => "Data not found!"], 404);
    }

    // Get the related id_indikator_sasaran_renstra from the Sasaran Renstra Nilai
    $id_indikator_sasaran_renstra = $sasaranRenstraNilai->id_indikator_sasaran_renstra;


    // Delete the entry
    $sasaranRenstraNilai->delete();

    // Recalculate totals after deletion

    // Get the related id_sasaran_renstra from Sasaran Renstra Indikator
    $id_sasaran_renstra = Model_Sasaran_Renstra_Indikator::where('id', $id_indikator_sasaran_renstra)
                                                         ->pluck('id_sasaran_renstra')
                                                         ->first();

    if ($id_sasaran_renstra) {
        // Calculate total pagu for the sasaran renstra
        $totalPaguSasaranRenstra = DB::table('cascading_sasaran_renstra_nilai')
                                    ->join('cascading_sasaran_renstra_indikator', 'cascading_sasaran_renstra_nilai.id_indikator_sasaran_renstra', '=', 'cascading_sasaran_renstra_indikator.id')
                                    ->where('cascading_sasaran_renstra_indikator.id_sasaran_renstra', $id_sasaran_renstra)
                                    ->sum('cascading_sasaran_renstra_nilai.pagu');

        // Get the related id_tujuan_renstra from the Sasaran Renstra
        $id_tujuan_renstra = Model_Sasaran_Renstra::where('id', $id_sasaran_renstra)
                                                 ->pluck('id_tujuan_renstra')
                                                 ->first();

        if ($id_tujuan_renstra) {

            // Update total pagu for tujuan_renstra
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

                // Update total pagu for urusan
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

    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}

}
