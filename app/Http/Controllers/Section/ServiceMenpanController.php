<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Client;
use App\Models\Section\Service;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class ServiceMenpanController extends Controller
{
    protected $route  = "setup.section.service.";
    public function api_service_menpan()
    {
        $service = Service::orderBy('order', 'ASC')->get();
        
        return DataTables::of($service)

            ->editColumn('icon', function ($p) {
                return "<i class='".$p->icon."'></i>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['icon', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Service";
        $route = $this->route;
        $txt = TextContent::whereid(2)->first();
        
        return view('section.service_menpan.index', compact('title', 'route', 'txt'));
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
            "nama" => 'required',
            "order" => 'required|numeric',
           
            "deskripsi" => 'required',
            "icon" => 'required',
        ]);

        

        Service::create([
            "nama" => $request->nama,
            "order" => $request->order,
            "deskripsi" => $request->deskripsi,
            "icon" => $request->icon,
           
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        return $service;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            "nama" => 'required',
            "order" => 'required|numeric',
           
            "deskripsi" => 'required',
            "icon" => 'required',
            
        ]);

        

        $service->update([
            "nama" => $request->nama,
            "order" => $request->order,
            "deskripsi" => $request->deskripsi,
            "icon" => $request->icon,
           
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
