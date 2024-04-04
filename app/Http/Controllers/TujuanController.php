<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\model_misi;
use App\Models\model_visi;
use App\Models\model_tujuan;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;

class TujuanController extends Controller
{
    public function api(Request $request)
    {
        $misi = model_misi::where($request->misi_id)->orderBy('id', 'ASC')->get();
        return DataTables::of($misi)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $misi_id = $request->misi_id;
        if (!$misi_id || !model_misi::whereid($misi_id)->first()) {
            return redirect()->route('setup.tujuan.index');
        }

        $visi = model_misi::find($misi_id);
        $title = "misi " . $visi->awal_tahun;


        return view('tujuan.index', compact('title', 'misi_id', 'misi'));
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
            "id_misi" => 'required',
            "misi" => 'required',
            "creator" => 'required',
           
        ]);



        model_tujuan::create([

            "id_misi" => $request->id_misi,
            "tujuan" => $request->misi,
            "creator" => $request->creator,
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
        return model_tujuan::find($id);
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
        $tujuan  = model_tujuan::find($id);

        $rule = [
            
            "tujuan" => 'required',
            "creator" => 'required',
            

        ];

        $request->validate($rule);





        $tujuan->update([

            
            "misi" => $request->misi,
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
    $misi  = model_tujuan::find($id);

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
