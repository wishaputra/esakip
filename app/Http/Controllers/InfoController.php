<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class InfoController extends Controller
{
    public function api()
    {
        $info = Info::orderBy('id', 'ASC')->get();
        return DataTables::of($info)

            // ->addColumn('submenu_count', function ($p) {
            //     $count = $p->sub_menus->count();
            //     return "<a  href='".route('setup.submenu.index')."?menu_id=".$p->id."'  title='Sub Menu'>".$count."</a>";
            // })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(".$p->id.")' title='Edit Info'><i class='icon-pencil mr-1'></i></a>";
                    // <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['info', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Informasi Bed";
        
        return view('info.index', compact('title'));
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
            "kategori" => 'required',
            "total_bed" => 'required|numeric',
            "bed_terpakai" => 'required',
        ]);

        Info::create([
            "kategori" => $request->kategori,
            "total_bed" => $request->total_bed,
            "bed_terpakai" => $request->bed_terpakai,
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
        return Info::find($id);
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
        $info = Info::find($id);
        // $request->validate([
        //     "kategori" => 'required',
        //     "total_bed" => 'required|numeric',
        //     "bed_terpakai" => 'required|numeric',
        // ]);

        $info->update([
            "kategori" => $request->kategori,
            "totalBed" => $request->totalBed,
            "bedTerpakai" => $request->bedTerpakai,
        ]);
        return response()->json(["message"   => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $info  = Info::find($id);
        // if ($info->sub_menus->count() > 0) {
        //     return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        // }
        
        $info->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}