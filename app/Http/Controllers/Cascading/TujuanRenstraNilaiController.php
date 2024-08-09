<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Tujuan_Renstra_Nilai;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Urusan;
use App\Models\Cascading\Model_Urusan_Indikator;
use App\Models\Cascading\Model_Urusan_Nilai;
use App\Models\Cascading\Model_Tujuan_Renstra_Indikator;
use App\Models\Cascading\Model_Tujuan_Renstra;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanRenstraNilaiController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $tujuan_renstra_nilai   = Model_Tujuan_Renstra_Nilai::whereid_indikator_tujuan_renstra($request->id_indikator_tujuan_renstra)->get();
        return DataTables::of($tujuan_renstra_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['tujuan_renstra_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_indikator_tujuan_renstra = $request->id_indikator_tujuan_renstra;
        if (!$id_indikator_tujuan_renstra || !Model_Tujuan_Renstra_Indikator::whereid($id_indikator_tujuan_renstra)->first()) {
            return redirect()->route('setup.tujuan_renstra_indikator.index');
        }


        $indikator   = Model_Tujuan_Renstra_Indikator::whereid($id_indikator_tujuan_renstra)->get();
        $tahun  = Model_Visi::all();

        // return view('cascading.tujuan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.tujuan_renstra_nilai.index', compact('indikator','id_indikator_tujuan_renstra','tahun'));
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
        "id_indikator_tujuan_renstra" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Create the new entry in cascading_tujuan_renstra_nilai
    $tujuanRenstraNilai = Model_Tujuan_Renstra_Nilai::create([
        "id_indikator_tujuan_renstra" => $request->id_indikator_tujuan_renstra,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Get the related id_tujuan_renstra from the Tujuan Renstra Indikator
    $id_tujuan_renstra = Model_Tujuan_Renstra_Indikator::where('id', $request->id_indikator_tujuan_renstra)
                                                      ->pluck('id_tujuan_renstra')
                                                      ->first();

    // Calculate total pagu for the tujuan renstra
    $totalPaguTujuanRenstra = DB::table('cascading_tujuan_renstra_nilai')
                               ->join('cascading_tujuan_renstra_indikator', 'cascading_tujuan_renstra_nilai.id_indikator_tujuan_renstra', '=', 'cascading_tujuan_renstra_indikator.id')
                               ->where('cascading_tujuan_renstra_indikator.id_tujuan_renstra', $id_tujuan_renstra)
                               ->sum('cascading_tujuan_renstra_nilai.pagu');

    // Get the related id_urusan from the Tujuan Renstra
    $id_urusan = Model_Tujuan_Renstra::where('id', $id_tujuan_renstra)
                                    ->pluck('id_urusan')
                                    ->first();

    // Calculate total pagu for the urusan
    $totalPaguUrusan = DB::table('cascading_tujuan_renstra_nilai')
                        ->join('cascading_tujuan_renstra_indikator', 'cascading_tujuan_renstra_nilai.id_indikator_tujuan_renstra', '=', 'cascading_tujuan_renstra_indikator.id')
                        ->join('cascading_tujuan_renstra', 'cascading_tujuan_renstra_indikator.id_tujuan_renstra', '=', 'cascading_tujuan_renstra.id')
                        ->where('cascading_tujuan_renstra.id_urusan', $id_urusan)
                        ->sum('cascading_tujuan_renstra_nilai.pagu');

    // Get the related urusan_indikator IDs
    $urusanIndikatorIds = Model_Urusan_Indikator::where('id_urusan', $id_urusan)
                                               ->pluck('id')
                                               ->toArray();

    // Update the total pagu in cascading_urusan_nilai
    Model_Urusan_Nilai::whereIn('id_indikator_urusan', $urusanIndikatorIds)
                      ->update(['pagu' => $totalPaguUrusan]);

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
        return Model_Tujuan_Renstra_Nilai::find($id);
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
        $tujuan_renstra_nilai = Model_Tujuan_Renstra_Nilai::find($id);
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "triwulan" => 'required',
            "pagu" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $tujuan_renstra_nilai->update([
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
    $misi  = Model_Tujuan_Renstra_Nilai::find($id);

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
