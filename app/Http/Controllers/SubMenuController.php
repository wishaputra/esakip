<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sub_menu;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class SubMenuController extends Controller
{
    public function api(Request $request)
    {
        $menu = Sub_menu::wheremenu_id($request->menu_id)->orderBy('no_urut', 'ASC')->get();
        return DataTables::of($menu)
            ->addColumn('submenu_count', function ($p) {
                $count = $p->sub_menus2->count();
                return "<a  href='" . route('setup.submenu2.index') . "?sub_menu_id=" . $p->id . "'  title='Sub Menu'>" . $count . "</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action', 'photo', 'submenu_count'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menu_id = $request->menu_id;
        if (!$menu_id || !Menu::whereid($menu_id)->first()) {
            return redirect()->route('setup.menu.index');
        }

        $menu = Menu::find($menu_id);
        $title = "Sub Menu " . $menu->nama;


        return view('submenu.index', compact('title', 'menu_id'));
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
            "menu_id" => 'required',
            "nama" => 'required',
            "no_urut" => 'required|numeric',
            "route" => 'required',

        ]);



        Sub_menu::create([

            "menu_id" => $request->menu_id,
            "nama" => $request->nama,
            "no_urut" => $request->no_urut,
            "route" => $request->route
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
        return Sub_menu::find($id);
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
        $submenu  = Sub_menu::find($id);

        $rule = [
            "menu_id" => 'required',
            "nama" => 'required',
            "no_urut" => 'required|numeric',
            "route" => 'required',

        ];

        $request->validate($rule);





        $submenu->update([

            "menu_id" => $request->menu_id,
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
        $submenu  = Sub_menu::find($id);

        if ($submenu->sub_menus2->count() > 0) {
            return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        }

        $submenu->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
