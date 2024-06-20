<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FrontMenpanController extends Controller
{
    public function api_front_menpan()
    {
        $menu = Frontend::orderBy('order', 'ASC')->get();
        return DataTables::of($menu)

            ->editColumn('status', function ($p) {
                $status = $p->status == 1 ? "Active" : "Inactive";
                return $status;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    
    
    public function index()
    {
        $title = "Front End";
        
        return view('frontend_menpan.index', compact('title'));
    }

    
    public function create()
    {
        //
    }

       public function store(Request $request)
    {
        //
    }

    
    public function show(Frontend $frontend)
    {
    }

    
    public function edit(Frontend $front)
    {
        return $front;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Frontend $front)
    {
        $request->validate([
            "order" => 'required|numeric',
            "name" => 'required',
            "status" => 'required',
        ]);

        $front->update([
            "name" => $request->name,
            "order" => $request->order,
            "status" => $request->status,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

   
    public function destroy(Frontend $frontend)
    {
        //
    }
}
