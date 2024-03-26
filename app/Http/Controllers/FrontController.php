<?php

namespace App\Http\Controllers;

use App\Models\Frontend;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FrontController extends Controller
{
    public function api()
    {
        $menu = Frontend::orderBy('order', 'ASC')->get();
        return DataTables::of($menu)

            ->editColumn('status', function ($p) {
                $status = $p->status == 1 ? "Active" : "Inactive";
                return $status;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(".$p->id.")' title='Edit Menu'><i class='icon-pencil mr-1'></i></a>";
                // <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action','status'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Front End";
        
        return view('frontend.index', compact('title'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function show(Frontend $frontend)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Frontend  $frontend
     * @return \Illuminate\Http\Response
     */
    public function destroy(Frontend $frontend)
    {
        //
    }
}
