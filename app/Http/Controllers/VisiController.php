<?php

namespace App\Http\Controllers;

use App\Models\model_misi;
use App\Models\model_visi;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;

class VisiController extends Controller
{
    public function api()
    {
        $visi = model_visi::orderBy('id', 'ASC')->get();
        return DataTables::of($visi)

            ->addColumn('misi_count', function ($p) {
                $count = $p->misi->count();
                return "<a  href='".route('setup.misi.index')."?visi_id=".$p->id."'  title='misi'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(".$p->id.")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action','photo','misi_count'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "visi";
        
        return view('visi.index', compact('title'));
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
            "tahun_awal" => 'required',
            "tahun_akhir" => 'required',
            "visi" => 'required',
            
        ]);

        model_visi::create([
            "tahun_awal" => $request->tahun_awal,
            "tahun_akhir" => $request->tahun_akhir,
            "visi" => $request->visi,
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
        return model_visi::find($id);
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
        $menu = model_visi::find($id);
        $request->validate([
            "tahun_awal" => 'required',
            "tahun_akhir" => 'required',
            "visi" => 'required',
        ]);

        $menu->update([
            "tahun_awal" => $request->tahun_awal,
            "tahun_akhir" => $request->tahun_akhir,
            "visi" => $request->visi,
        ]);
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
        $visi  = model_visi::find($id);
        if ($visi->model_misi->count() > 0) {
            return response()->json(["message" => "<center>Hapus misi terlebih dahulu</center>"], 500);
        }
        
        $visi->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}


