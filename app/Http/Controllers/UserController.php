<?php

namespace App\Http\Controllers;

use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Hash;

class UserController extends Controller
{
    public function api()
    {
        $user = User::orderBy('id', 'ASC')->get();
        return DataTables::of($user)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(".$p->id.")' title='Edit User'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus User'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['user', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title  = "Manajemen User";
        $opd    = Model_Perangkat_Daerah::all();
        
        return view('user.index', compact('title', 'opd'));
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
            "name" => 'required',
            "email" => 'required',
            "telp" => 'required',
            "username" => 'required',
            "password" => 'required',
            "id_opd" => 'required',
            "role" => 'required',
        ]);

        User::create([
            "nik" => "",
            "email" => $request->email,
            "telp" => $request->telp,
            "name" => $request->name,
            "username" => $request->username,
            "password" => Hash::make($request->password),
            "id_opd" => $request->id_opd,
            "role" => $request->role,
            "created_at" => Carbon::now()->timestamp
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
        return User::find($id);
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
        $user = User::find($id);
        $request->validate([
            "name" => 'required',
            "email" => 'required',
            "telp" => 'required',
            "username" => 'required',
            "password" => 'required',
            "id_opd" => 'required',
            "role" => 'required',
        ]);

        $user->update([
            "email" => $request->email,
            "telp" => $request->telp,
            "name" => $request->name,
            "username" => $request->username,
            "password" => Hash::make($request->password),
            "id_opd" => $request->id_opd,
            "role" => $request->role,
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
        $user  = User::find($id);
        // if ($user->sub_menus->count() > 0) {
        //     return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
        // }
        
        $user->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
