<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class MenuMenpanController extends Controller
{
    public function api_menu_menpan()
    {
        $menu = Menu::orderBy('no_urut', 'ASC')->get();
        return DataTables::of($menu)

            ->addColumn('submenu_count', function ($p) {
                $count = $p->sub_menus->count();
                return "<a  href='".route('setup.submenu_menpan.index')."?menu_id=".$p->id."'  title='Sub Menu'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action','photo','submenu_count'])
            ->toJson();
    }
    
    public function index()
    {
        $title = "Menu";
        
        return view('menu_menpan.index', compact('title'));
    }

    
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
            "nama" => 'required',
            "no_urut" => 'required|numeric',
            "route" => 'required',
        ]);

        Menu::create([
            "nama" => $request->nama,
            "no_urut" => $request->no_urut,
            "route" => $request->route,
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

   
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        return Menu::find($id);
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
        $menu = Menu::find($id);
        $request->validate([
            "nama" => 'required',
            "no_urut" => 'required|numeric',
            "route" => 'required',
        ]);

        $menu->update([
            "nama" => $request->nama,
            "no_urut" => $request->no_urut,
            "route" => $request->route,
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
        $menu  = Menu::find($id);
        if ($menu->sub_menus->count() > 0) {
            return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        }
        
        $menu->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
