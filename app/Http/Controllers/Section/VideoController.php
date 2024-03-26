<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Client;
use App\Models\Section\Video;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class VideoController extends Controller
{
    protected $route  = "setup.section.video.";
    public function api()
    {
        $video = Video::orderBy('order', 'ASC')->get();
        return DataTables::of($video)
            ->editColumn('icon', function ($p) {
                return "<i class='".$p->icon."'></i>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(".$p->id.")' title='Edit Video'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Video'><i class='icon-remove'></i></a>";
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
        $title = "Video";
        $route = $this->route;
        $txt = TextContent::whereid(14)->first();
        
        return view('section.video.index', compact('title', 'route', 'txt'));
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
            "link" => 'required',
        ]);
        
        Video::create([
            "nama" => $request->nama,
            "order" => $request->order,
            "deskripsi" => $request->deskripsi,
            "link" => $request->link,
           
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return $video;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            "nama" => 'required',
            "order" => 'required|numeric',
            "deskripsi" => 'required',
            "link" => 'required',
            
        ]);

        $video->update([
            "nama" => $request->nama,
            "order" => $request->order,
            "deskripsi" => $request->deskripsi,
            "link" => $request->link,
           
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Video $video)
    {
        $video->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
