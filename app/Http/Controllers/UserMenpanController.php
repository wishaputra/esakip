<?php

namespace App\Http\Controllers;

use App\Models\Cascading\Model_Perangkat_Daerah;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use Hash;

class UserMenpanController extends Controller
{
    public function api_user_menpan()
    {
        $users = User::with('perangkatDaerah')->orderBy('id', 'ASC')->get();

        return DataTables::of($users)
            ->addColumn('action', function ($user) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->addColumn('perangkat_daerah', function ($user) {
                return $user->perangkatDaerah ? $user->perangkatDaerah->perangkat_daerah : '';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function index()
    {
        $title  = "Manajemen User";
        $opd    = Model_Perangkat_Daerah::all();
        
        return view('user_menpan.index', compact('title', 'opd'));
    }

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

    public function edit($id)
    {
        return User::find($id);
    }

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

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
