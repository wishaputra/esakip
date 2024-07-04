<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Tujuan_Renstra;
use App\Models\Cascading\Model_Tujuan_Renstra_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanRenstraIndikatorController extends Controller
{
    public function api(Request $request)
    {
        $tujuan_renstra_indikator   = Model_Tujuan_Renstra_Indikator::whereid_tujuan_renstra($request->id_tujuan_renstra)->get();

        return DataTables::of($tujuan_renstra_indikator)
            ->addColumn('tujuan_renstra_nilai_count', function ($p) {
                $count = $p->tujuan_renstra_nilai->count();
               
                return "<a  href='".route('setup.tujuan_renstra_nilai.index')."?id_indikator_tujuan_renstra=".$p->id."'  title='Nilai Tujuan Renstra'>".$count."</a>";
            })
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
        $id_tujuan_renstra = $request->id_tujuan_renstra;
        if (!$id_tujuan_renstra || !Model_Tujuan_Renstra::whereid($id_tujuan_renstra)->first()) {
            return redirect()->route('setup.tujuan_renstra.index');
        }

        // $visi = Model_Tujuan_Renstra::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tujuan_renstra   = Model_Tujuan_Renstra::whereid($id_tujuan_renstra)->get();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.tujuan_renstra_indikator.index', compact('tujuan_renstra','id_tujuan_renstra'));
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
       
        "indikator" => 'required',
    ]);

    Model_Tujuan_Renstra_Indikator::create([
        "id_tujuan_renstra" => $request->id_tujuan_renstra,
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
        return Model_Tujuan_Renstra_Indikator::find($id);
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
        $misi  = Model_Tujuan_Renstra_Indikator::find($id);
        $rule = [
            "indikator" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "id_tujuan_renstra"        => $request->id_tujuan_renstra,
            "indikator"=> $request->indikator,
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
        $tujuan_renstra  = Model_tujuan_renstra_indikator::find($id);
    
        if ($tujuan_renstra && $tujuan_renstra->indikator && is_iterable($tujuan_renstra->indikator)) {
            $count = $tujuan_renstra->indikator->count();
        } else {
            $count = 0;
        }
    
        if ($count > 0) {
            return response()->json(["message" => "<center>Hapus Urusan terlebih dahulu</center>"], 500);
        }
    
        $tujuan_renstra->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
