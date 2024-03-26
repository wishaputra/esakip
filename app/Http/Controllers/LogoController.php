<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Storage;

class LogoController extends Controller
{
    protected $title = "Logo";
    protected $route = "setup.logo.";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Logo";
        $route = $this->route;
        $logo = Logo::first();

        return view('logo.index', compact('title', 'route', 'logo'));
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
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function show(Logo $logo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function edit(Logo $logo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Logo $logo)
    {
        // Upload Gambar
        $file = $request->file('logo');
        $path_logo = $logo->logo;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }
            if ($logo->logo != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $logo->logo));
            }


            $nameFile   = 'Logo_' . date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('logo', $nameFile, 'public');
            $path_logo = 'storage/logo/' . $nameFile;
        }

        // Upload Gambar
        $file = $request->file('favicon');
        $path_favicon = $logo->favicon;
        if ($file) {
            if ($logo->favicon != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $logo->favicon));
            }

            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }


            $nameFile   = 'Favicon_' . date('Ymd') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('favicon', $nameFile, 'public');
            $path_favicon = 'storage/favicon/' . $nameFile;
        }



        $logo->update([
            "nama" => $request->nama,

            "logo" => $path_logo,
            "favicon" => $path_favicon,
        ]);
        return response()->json(["message" => "Berhasil merubah data!", "logo" => $logo], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Logo  $logo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Logo $logo)
    {
        //
    }
}
