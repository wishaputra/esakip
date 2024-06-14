<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Urusan;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UrusanController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $urusan   = Model_Urusan::all();
        return DataTables::of($urusan)
            ->addColumn('urusan_indikator_count', function ($p) {
                $count = $p->urusan_indikator->count();
                return "<a  href='".route('setup.urusan_indikator.index')."?id_urusan=".$p->id."'  title='Indikator Urusan'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['urusan_indikator_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function getSasaranByTahun($id)
{
    $sasaran = Model_Sasaran::where('id_visi', $id)->get();
    return response()->json($sasaran->pluck('sasaran', 'id'));
}



    public function index(Request $request)
    {
        // $id_visi = $request->id_visi;
        // if (!$id_visi || !Model_Tujuan::whereid($id_visi)->first()) {
        //     return redirect()->route('setup.tujuan.index');
        // }

        // $visi = Model_Tujuan::find($id_visi);
        // $title = "Tujuan " . $visi->tujuan;
        $tahun  = Model_Visi::all();
        $sasaran = Model_Sasaran::all();

        // return view('cascading.tujuan.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.urusan.index', compact('tahun','sasaran'));
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
            "id_sasaran" => 'required',
            "urusan" => 'required',
        ]);

        Model_Urusan::create([
            "id_visi" => $request->tahun,
            "id_sasaran" => $request->id_sasaran,
            "urusan" => $request->urusan,
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
        return Model_Urusan::find($id);
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
        $urusan  = Model_Urusan::find($id);
        $rule = [
            "id_sasaran"    => 'required',
            "urusan"        => 'required',
        ];

        $request->validate($rule);

        $urusan->update([
            "id_visi" => $request->tahun,
            "id_sasaran" => $request->id_sasaran,
            "urusan" => $request->urusan,
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
    $urusan  = Model_Urusan::find($id);

    if ($urusan && $urusan->sasaran && is_iterable($urusan->sasaran)) {
        $count = $urusan->sasaran->count();
    } else {
        $count = 0;
    }

    if ($count > 0) {
        return response()->json(["message" => "<center>Hapus Sasaran terlebih dahulu</center>"], 500);
    }

    $urusan->delete();
    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}
}