<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Client;
use App\Models\Section\Video;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class VideoMenpanController extends Controller
{
    protected $route  = "setup.section.video.";
    public function api_video_menpan()
    {
        $video = Video::orderBy('order', 'ASC')->get();
        return DataTables::of($video)
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
    
    public function index()
    {
        $title = "Video";
        $route = $this->route;
        $txt = TextContent::whereid(14)->first();
        
        return view('section.video_menpan.index', compact('title', 'route', 'txt'));
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

    
    public function show(Video $video)
    {
    }

   
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
