<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Visi;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class MisiMenpanController extends Controller
{
    public function api_misi_menpan(Request $request)
{
    $misi = Model_Misi::whereid_visi($request->id_visi)->orderBy('id', 'ASC')->get();
    return DataTables::of($misi)
        ->addColumn('action', function ($p) {
            return "
                <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
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
    $id_visi = $request->id_visi;
    if (!Model_Visi::find($id_visi)) {
        return redirect()->route('setup.visi.index');
    }

    $visi = Model_Visi::find($id_visi);
    $title = "Misi " . $visi->tahun_awal;
    $misi = Model_Misi::whereid_visi($id_visi)->orderBy('id', 'ASC')->get();

    return view('cascading.misi_menpan.index', compact('title', 'id_visi', 'visi', 'misi'));
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



        Model_Misi::create([

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
        return Model_Misi::find($id);
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
        $misi  = Model_Misi::find($id);

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
    $visi  = Model_Misi::find($id);

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
