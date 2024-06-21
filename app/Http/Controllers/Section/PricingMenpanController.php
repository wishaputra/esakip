<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Pricing;
use App\Models\Section\PricingList;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PricingMenpanController extends Controller
{
    protected $route  = "setup.section.pricing.";
    public function api_pricing_menpan()
    {
        $pricing = Pricing::orderBy('order', 'ASC')->get();
        
        return DataTables::of($pricing)

            
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns([ 'action'])
            ->toJson();
    }
    
    public function index()
    {
        $title = "Pricing";
        $route = $this->route;
        $txt = TextContent::whereid(3)->first();
        
        return view('section.pricing_menpan.index', compact('title', 'route', 'txt'));
    }

   
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'order' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'durasi' => 'required',
            'badge_text' => 'required',
            'text_button' => 'required',
            'link_button' => 'required',
            ]);

        

        $pricing =  Pricing::create([
            'order' => $request->order ,
            'nama' => $request->nama ,
            'deskripsi' => $request->deskripsi ,
            'harga' => $request->harga ,
            'durasi' => $request->durasi ,
            'badge_text' => $request->badge_text ,
            'text_button' => $request->text_button ,
            'link_button' => $request->link_button ,
        ]);

        foreach ($request->fitur as $k=> $v) {
            if ($request->fitur[$k] != '') {
                PricingList::create([
                    'order' => $request->urutan[$k],
                    'pricing_id' => $pricing->id,
                    'nama' => $request->fitur[$k],
                    'check' => $request->cheklist[$k],
                ]);
            }
        }
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    
    public function show(Pricing $pricing)
    {
        //
    }

    
    public function edit(Pricing $pricing)
    {
        return [ "pricing" => $pricing,"list" => $pricing->pricing_lists];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pricing $pricing)
    {
        $request->validate([
            'order' => 'required',
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required',
            'durasi' => 'required',
            'badge_text' => 'required',
            'text_button' => 'required',
            'link_button' => 'required',
            ]);

        

        $pricing->update([
            'order' => $request->order ,
            'nama' => $request->nama ,
            'deskripsi' => $request->deskripsi ,
            'harga' => $request->harga ,
            'durasi' => $request->durasi ,
            'badge_text' => $request->badge_text ,
            'text_button' => $request->text_button ,
            'link_button' => $request->link_button ,
        ]);
        $pricing->pricing_lists()->delete();
        foreach ($request->fitur as $k=> $v) {
            if ($request->fitur[$k] != '') {
                PricingList::create([
                    'order' => $request->urutan[$k],
                    'pricing_id' => $pricing->id,
                    'nama' => $v,
                    'check' => $request->cheklist[$k],
                ]);
            }
        }
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Pricing  $pricing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pricing $pricing)
    {
        $pricing->pricing_lists()->delete();
        $pricing->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
