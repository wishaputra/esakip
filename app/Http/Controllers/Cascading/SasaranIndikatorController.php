<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Tujuan_Indikator;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Sasaran_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SasaranIndikatorController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $sasaran_indikator   = Model_Sasaran_Indikator::all();
        return DataTables::of($sasaran_indikator)
            ->addColumn('sasaran_nilai_count', function ($p) {
                $count = $p->sasaran_nilai->count();
                return "<a  href='".route('setup.sasaran_nilai.index')."?sasaran_nilai_id=".$p->id."'  title='Nilai Sasaran'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['sasaran_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $id_sasaran = $request->id_sasaran;
        // if (!$id_sasaran || !Model_sasaran_Indikator::whereid($id_sasaran)->first()) {
        //     return redirect()->route('setup.sasaran_indikator.index');
        // }

        // $tujuan = Model_Tujuan::find($id_tujuan);
        // $title = "Tujuan " . $tujuan->tujuan;
        $indikator  = Model_Sasaran_Indikator::all();
        $sasaran = Model_Sasaran::all();
        $id_sasaran = Model_Sasaran_Indikator::all();

        return view('cascading.sasaran_indikator.index', compact('indikator','sasaran', 'id_sasaran'));
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
        "id_sasaran" => 'required',
        "indikator" => 'required',
    ]);

    Model_Sasaran_Indikator::create([
        "id_sasaran" => $request->id_sasaran,
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
        return Model_Sasaran_Indikator::find($id);
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
        $misi  = Model_Sasaran_indikator::find($id);
        $rule = [
            "indikator" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "indikator" => $request->sasaran,
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
    $sasaran  = Model_Sasaran_Indikator::find($id);

    if ($sasaran && $sasaran->indikator && is_iterable($sasaran->indikator)) {
        $count = $sasaran->indikator->count();
    } else {
        $count = 0;
    }

    if ($count > 0) {
        return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
    }

    $sasaran->delete();
    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}
}
