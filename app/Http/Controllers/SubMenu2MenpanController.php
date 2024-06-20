<?php

namespace App\Http\Controllers;

use App\Models\Sub_menu;
use App\Models\SubMenu2;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubMenu2MenpanController extends Controller
{
    public function api_submenu2_menpan(Request $request)
    {
        $menu = SubMenu2::wheresub_menu_id($request->sub_menu_id)->orderBy('no_urut', 'ASC')->get();
        return DataTables::of($menu)

            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action'])
            ->toJson();
    }
    
    public function index(Request $request)
    {
        $sub_menu_id = $request->sub_menu_id;
        if (!$sub_menu_id || !Sub_menu::whereid($sub_menu_id)->first()) {
            return redirect()->route('setup.menu.index');
        }

        $submenu = Sub_menu::find($sub_menu_id);
        $title = "Sub Menu " . $submenu->nama;


        return view('submenu2_menpan.index', compact('title', 'sub_menu_id'));
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
            "sub_menu_id" => 'required',
            "nama" => 'required',
            "no_urut" => 'required|numeric',
            "route" => 'required',

        ]);



        SubMenu2::create([

            "sub_menu_id" => $request->sub_menu_id,
            "nama" => $request->nama,
            "no_urut" => $request->no_urut,
            "route" => $request->route
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

   
    public function show(SubMenu2 $submenu2)
    {
        //
    }

   
    public function edit(SubMenu2 $submenu2)
    {
        return $submenu2;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubMenu2  $submenu2
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubMenu2 $submenu2)
    {

        $rule = [
            "sub_menu_id" => 'required',
            "nama" => 'required',
            "no_urut" => 'required|numeric',
            "route" => 'required',

        ];
        $request->validate($rule);
        $submenu2->update([

            "sub_menu_id" => $request->sub_menu_id,
            "nama" => $request->nama,
            "no_urut" => $request->no_urut,
            "route" => $request->route,

        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubMenu2  $submenu2
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubMenu2 $submenu2)
    {
        $submenu2->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
