<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Storage;

class Blog2Controller extends Controller
{
    protected $route = "blog.";
    public function api2()
    {
        $posts = Post::where('type', '=', 'blog')->orderBy('id', 'DESC')->get();
        return DataTables::of($posts)

            ->addColumn('link', function ($p) {
                return "
                <a target='_blank'  href='" . route('main.page.blog', $p->slug) . "'  title='link " . $p->title . "'><i class='icon-eye mr-1'></i></a>
                ";
            })
            ->addColumn('category_name', function ($p) {
                return $p->category->nama;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action', 'link'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Blog";
        $route = $this->route;
        $txt = TextContent::whereid(8)->first();

        return view('posts2.index', compact('title', 'route', 'txt'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Create Post Blog";
        $route = $this->route;
        $categories = Category::all();


        return view('posts2.create', compact('title', 'route', 'categories'));
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
            "title" => 'required',
            "content" => 'required',
            "status" => 'required',
            "post_category_id" => 'required',
            "thumbnail" => 'required'
        ]);

        // Upload Gambar
        $file = $request->file('thumbnail');

        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'thumbnail';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('blog/thumbnail', $nameFile, 'public');
            $photo = 'storage/blog/thumbnail/' . $nameFile;
        }


        Post::create([
            "title" => $request->title,
            "content" => $request->content,
            "status" => $request->status,
            "type" => 'blog',
            "post_category_id" => $request->post_category_id,
            "thumbnail" => $photo,
            "date" => date('Y-m-d H:i:s'),
            "slug" => Str::slug($request->title . ' ' . rand(0, 99), '-')
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
        $title = "Edit Post Blog";
        $route = $this->route;
        if ($post->type != "blog") {
            return abort(404);
        }
        $categories = Category::all();

        return view('posts2.edit', compact('title', 'route', 'post', 'categories'));
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
            "title" => 'required',
            "content" => 'required',
            "status" => 'required',
            "post_category_id" => 'required',

        ]);



        // Upload Gambar
        $file = $request->file('thumbnail');
        $photo = $post->thumbnail;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'thumbnail';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('blog/thumbnail', $nameFile, 'public');
            $photo = 'storage/blog/thumbnail/' . $nameFile;
            if ($post->thumbnail != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $post->thumbnail));
            }
        }

        $post->update([
            "title" => $request->title,
            "content" => $request->content,
            "status" => $request->status,
            "post_category_id" => $request->post_category_id,
            "created_at" => $request->created_at,
            "thumbnail" => $photo,
            "type" => 'blog',
            "slug" => Str::slug($request->title . ' ' . rand(0, 99), '-')
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
        if ($post->thumbnail != null) {
            Storage::disk('public')->delete(str_replace("storage/", "", $post->thumbnail));
        }
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
