<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class FooterMenpanController extends Controller
{
    protected $title = "Footer";
    protected $route = "setup.footer.";

    public function api_link_menpan()
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
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns([ 'action','content'])
            ->toJson();
    }
    public function api_social_menpan()
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
                   <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['icon', 'action'])
            ->toJson();
    }

    
    public function index()
    {
        $title = $this->title;
        $route = $this->route;
        $about = TextContent::whereid(9)->first();
        $link = TextContent::whereid(10)->first();
        $social = TextContent::whereid(11)->first();

        return view('footer_menpan.index', compact('about', 'link', 'social', 'title', 'route'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
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
