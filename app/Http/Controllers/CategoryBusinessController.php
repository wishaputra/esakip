<?php

namespace App\Http\Controllers;

use App\Models\CategoryBusiness;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;

class CategoryBusinessController extends Controller
{
    public function api()
    {
        $cat_b = CategoryBusiness::orderBy('order', 'ASC')->get();
        return DataTables::of($cat_b)

            ->editColumn('icon', function ($p) {
                return "<i class='" . $p->icon . "'></i>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Category'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Category'><i class='icon-remove'></i></a>";
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
        $title = "Category Business";
        $txt = TextContent::whereid(12)->first();

        return view('business.category.index', compact('title', 'txt'));
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
            "name" => 'required|unique:category_business',
            "order" => 'required|numeric',

            "icon" => 'required',


        ]);


        CategoryBusiness::create([
            "name" => $request->name,
            "order" => $request->order,
            "icon" => $request->icon,
            "type" => $request->type,
            "url" => $request->url,
            "slug" => Str::slug($request->name, '-'),


        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CategoryBusiness  $category
     * @return \Illuminate\Http\Response
     */
    public function show(CategoryBusiness $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CategoryBusiness  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoryBusiness $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CategoryBusiness  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CategoryBusiness $category)
    {
        $request->validate([
            "name" => 'required|unique:category_business,name,' . $category->id,
            "order" => 'required|numeric',

            "icon" => 'required',


        ]);


        $category->update([
            "name" => $request->name,
            "order" => $request->order,
            "icon" => $request->icon,
            "type" => $request->type,
            "url" => $request->url,
            "slug" => Str::slug($request->name, '-'),


        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CategoryBusiness  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoryBusiness $category)
    {
        if ($category->business->count() > 0) {
            return response()->json(["message" => "<center>Hapus Business kategori " . $category->name . " terlebih dahulu</center>"], 500);
        }
        $category->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
