<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\model_misi;
use App\Models\model_visi;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;

class MisiController extends Controller
{
    public function api(Request $request)
    {
        $visi = model_misi::where($request->visi_id)->orderBy('id', 'ASC')->get();
        return DataTables::of($visi)
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
        $visi_id = $request->visi_id;
        if (!$visi_id || !model_visi::whereid($visi_id)->first()) {
            return redirect()->route('setup.menu.index');
        }

        $visi = model_visi::find($visi_id);
        $title = "misi " . $visi->awal_tahun;


        return view('misi.index', compact('title', 'visi_id', 'visi'));
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
            "id_visi" => 'required',
            "misi" => 'required',
            "creator" => 'required',
           
        ]);



        model_misi::create([

            "id_visi" => $request->id_visi,
            "misi" => $request->misi,
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
        return model_misi::find($id);
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
        $misi  = model_misi::find($id);

        $rule = [
            
            "misi" => 'required',
            "creator" => 'required',
            

        ];

        $request->validate($rule);





        $misi->update([

            
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
    $visi  = model_misi::find($id);

    if ($visi && $visi->misi && is_iterable($visi->misi)) {
        $count = $visi->misi->count();
    } else {
        $count = 0;
    }

    if ($count > 0) {
        return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
    }

    $visi->delete();
    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}
}
