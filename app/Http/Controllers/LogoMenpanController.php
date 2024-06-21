<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Storage;

class LogoMenpanController extends Controller
{
    protected $title = "Logo";
    protected $route = "setup.logo.";
   
    public function index()
    {
        $title = "Logo";
        $route = $this->route;
        $logo = Logo::first();

        return view('logo_menpan.index', compact('title', 'route', 'logo'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        //
    }

   
    public function show(Logo $logo)
    {
        //
    }

    
    public function edit(Logo $logo)
    {
        //
    }

    
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

   
    public function destroy(Logo $logo)
    {
        //
    }
}
