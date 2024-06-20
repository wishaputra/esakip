<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CategoryBusiness;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Storage;

class BusinessMenpanController extends Controller
{
    protected $route = "business.list.";
    public function api_list_menpan()
    {
        $business = Business::where('type', '=', 'business')->orderBy('id', 'DESC')->orderBy('business_category_id')->get();
        return DataTables::of($business)

            ->addColumn('link', function ($p) {
                return "<center>
                <a target='_blank'   href='" . route('main.page.business', $p->slug) . "'  title='link " . $p->title . "'><i class='icon-eye mr-1'></i></a>
                </center>";
            })
            ->addColumn('category_name', function ($p) {
                return $p->category->name;
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['menu', 'action', 'link'])
            ->toJson();
    }
    
    public function index()
    {
        $title = "List Businesss ";
        $route = $this->route;

        return view('business_menpan.list.index', compact('title', 'route'));
    }

    
    public function create()
    {
        $title = "Create Business List ";
        $route = $this->route;
        $categories = CategoryBusiness::wheretype('post')->get();

        return view('business_menpan.list.create', compact('title', 'route', 'categories'));
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
            "title" => 'required|unique:business',
            "tab_content" => 'required',
            "content" => 'required',
            "status" => 'required',
            "business_category_id" => 'required',
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
            $file->storeAs('business/thumbnail', $nameFile, 'public');
            $photo = 'storage/business/thumbnail/' . $nameFile;
        }


        Business::create([
            "title" => $request->title,
            "tab_content" => $request->tab_content,
            "content" => $request->content,
            "tab_content_2" => $request->tab_content_2,
            "content_2" => $request->content_2,
            "tab_content_3" => $request->tab_content_3,
            "content_3" => $request->content_3,
            "tab_content_4" => $request->tab_content_4,
            "content_4" => $request->content_4,
            "tab_content_5" => $request->tab_content_5,
            "content_5" => $request->content_5,
            "status" => $request->status,
            "type" => 'business',
            "business_category_id" => $request->business_category_id,
            "thumbnail" => $photo,
            "date" => date('Y-m-d H:i:s'),
            "slug" => Str::slug($request->title, '-')
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    
    public function show(Business $list)
    {
        //
    }

    
    public function edit(Business $list)
    {
        $title = "Edit Business List ";
        $route = $this->route;
        if ($list->type != "business") {
            return abort(404);
        }
        $categories = CategoryBusiness::wheretype('post')->get();

        return view('business.list.edit', compact('title', 'route', 'list', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Business  $list
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $list)
    {
        $request->validate([
            "title" => 'required||unique:business,title,' . $list->id,
            "content" => 'required',
            "status" => 'required',
            "business_category_id" => 'required',

        ]);



        // Upload Gambar
        $file = $request->file('thumbnail');
        $photo = $list->thumbnail;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'thumbnail';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('business/thumbnail', $nameFile, 'public');
            $photo = 'storage/business/thumbnail/' . $nameFile;
            if ($list->thumbnail != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $list->thumbnail));
            }
        }

        $list->update([
            "title" => $request->title,
            "tab_content" => $request->tab_content,
            "content" => $request->content,
            "tab_content_2" => $request->tab_content_2,
            "content_2" => $request->content_2,
            "tab_content_3" => $request->tab_content_3,
            "content_3" => $request->content_3,
            "tab_content_4" => $request->tab_content_4,
            "content_4" => $request->content_4,
            "tab_content_5" => $request->tab_content_5,
            "content_5" => $request->content_5,
            "status" => $request->status,
            "business_category_id" => $request->business_category_id,
            "thumbnail" => $photo,
            "type" => 'business',
            "slug" => Str::slug($request->title, '-')
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Business  $list
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $list)
    {
        $list->delete();
        if ($list->thumbnail != null) {
            Storage::disk('public')->delete(str_replace("storage/", "", $list->thumbnail));
        }
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
