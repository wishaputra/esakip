<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class PostController extends Controller
{
    protected $route = "posts.";
    public function api()
    {
        $posts = Post::where('type', '=', 'page')->orderBy('id', 'DESC')->get();
        
        return DataTables::of($posts)

            ->addColumn('link', function ($p) {
                return "
                <a target='_blank'  href='".route('main.page', $p->slug)."'  title='link ".$p->title."'><i class='icon-eye mr-1'></i></a>
                ";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='".route($this->route.'edit', $p->id)."'  title='Edit Menu'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action','link'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Page";
        $route = $this->route;
        
        return view('posts.index', compact('title', 'route'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Page";
        $route = $this->route;
        
        return view('posts.create', compact('title', 'route'));
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
            "title" => 'required|unique:posts',
            "content" => 'required',
            "status" => 'required',
        ]);

        Post::create([
            "title" => $request->title,
            "content" => $request->content,
            "status" => $request->status,
            "date" => date('Y-m-d H:i:s'),
            "type" => 'page',
            "slug" => Str::slug($request->title, '-')
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $title = "Edit Page";
        $route = $this->route;
        if ($post->type != "page") {
            return abort(404);
        }
        
        return view('posts.edit', compact('title', 'post', 'route'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            "title" => 'required|unique:posts,title,'.$post->id,
            "content" => 'required',
            "status" => 'required',
        ]);

        $post->update([
            "title" => $request->title,
            "content" => $request->content,
            "status" => $request->status,
            "type" => 'page',
            
            "slug" => Str::slug($request->title, '-')
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
