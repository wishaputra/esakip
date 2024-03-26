<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FooterController extends Controller
{
    protected $title = "Footer";
    protected $route = "setup.footer.";

    public function api_link()
    {
        $link = DB::table('footer_link')
            ->select('id', 'content', 'order')
            ->orderBy('order')
            ->get();
    
       
        return DataTables::of($link)

            
            ->editColumn('content', function ($p) {
                return $p->content;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#!' onclick='edit_link(".$p->id.")'  title='Edit Link'><i class='icon-pencil mr-1'></i></a>
                    <a href='#!' onclick='remove_link(".$p->id.")' class='text-danger' title='Hapus Link'><i class='icon-remove'></i></a>";
            })
            ->rawColumns([ 'action','content'])
            ->toJson();
    }
    public function api_social()
    {
        $social = DB::table('footer_link_social')
            ->select('id', 'icon', 'name', 'order', 'link')
            ->orderBy('order')
            ->get();
        
        return DataTables::of($social)

        ->editColumn('icon', function ($p) {
            return ' <i class="'.$p->icon .'"></i>';
        })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#!' onclick='edit_social(".$p->id.")'  title='Edit Link'><i class='icon-pencil mr-1'></i></a>";
                // <a href='#!' onclick='remove_social(".$p->id.")' class='text-danger' title='Hapus Link'><i class='icon-remove'></i></a>";
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
        $title = $this->title;
        $route = $this->route;
        $about = TextContent::whereid(9)->first();
        $link = TextContent::whereid(10)->first();
        $social = TextContent::whereid(11)->first();

        return view('footer.index', compact('about', 'link', 'social', 'title', 'route'));
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
        //
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
        //update About
        
        if ($request->type == "Left") {
            $id = $request->id_about;
            $title = $request->title_about;
            $content = $request->content_about;
        } elseif ($request->type == "Middle") {
            $id = $request->id_link;
            $title = $request->title_link;
            $content = $request->content_link;
        } else {
            $id = $request->id_social;
            $title = $request->title_social;
            $content = $request->content_social;
        }
        
        $tc = TextContent::find($id);
        $tc->update([
            "title" => $title,
            "content" => $content

        ]);

        return response()->json(["message" => "Berhasil merubah ".$request->type." Footer!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function link_store(Request $request)
    {
        $request->validate([
            "frm_link_order" => 'required',
            
            "frm_link_content" => 'required',
        ]);
        DB::table('footer_link')->insert([
            'order' => $request->frm_link_order,
            'content' => strip_tags($request->frm_link_content, '<a><span><b><u>'),
            
        ]);
        return response()->json(["message" => "Berhasil menambah data!"], 200);
    }
    public function link_edit($id)
    {
        $db =  DB::table('footer_link')
        ->select('id', 'content', 'order')
        ->where('id', '=', $id)
        ->first();
        return json_encode($db);
    }
    public function link_patch(Request $request, $id)
    {
        $request->validate([
            "frm_link_order" => 'required',
            
            "frm_link_content" => 'required',
        ]);
        DB::table('footer_link')
            ->where('id', $id)
            ->update([
            'order' => $request->frm_link_order,
            'content' => strip_tags($request->frm_link_content, '<a><span><b><u>'),
            
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }
    public function link_destroy($id)
    {
        DB::table('footer_link')->where('id', '=', $id)->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }

    public function social_store(Request $request)
    {
        $request->validate([
            "frm_social_order" => 'required',
            
            "frm_social_icon" => 'required',
            "frm_social_name" => 'required',
            "frm_social_link" => 'required',
        ]);
        DB::table('footer_link_social')->insert([
            'order' => $request->frm_social_order,
            'icon' => $request->frm_social_icon,
            'name' => $request->frm_social_name,
            'link' => $request->frm_social_link,
            
            
        ]);
        return response()->json(["message" => "Berhasil menambah data!"], 200);
    }
    public function social_edit($id)
    {
        $db =  DB::table('footer_link_social')
        ->select('id', 'order', 'name', 'icon', 'link')
        ->where('id', '=', $id)
        ->first();
        return json_encode($db);
    }
    public function social_patch(Request $request, $id)
    {
        $request->validate([
            "frm_social_order" => 'required',
            
            "frm_social_icon" => 'required',
            "frm_social_name" => 'required',
            "frm_social_link" => 'required',
        ]);
        DB::table('footer_link_social')
            ->where('id', $id)
            ->update([
                'order' => $request->frm_social_order,
                'icon' => $request->frm_social_icon,
                'name' => $request->frm_social_name,
                'link' => $request->frm_social_link,
            
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }
    public function social_destroy($id)
    {
        DB::table('footer_link_social')->where('id', '=', $id)->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
