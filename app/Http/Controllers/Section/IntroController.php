<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Intro;
use Illuminate\Http\Request;
use Storage;

class IntroController extends Controller
{
    protected $route  = "setup.section.intro.";
    public function index()
    {
        $title = "Intro";
        $intro = Intro::first();
        $route = $this->route;

        return view('section.intro.index', compact('title', 'intro', 'route'));
    }

    public function update(Request $request, Intro $intro)
    {
        // Upload Gambar
        $rule = [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'text_button' => 'required',
        ];

        $request->validate($rule);

        $file = $request->file('image');
        $photo = $intro->image;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'svg', 'SVG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }


            $nameFile   =   date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/intro', $nameFile, 'public');
            $photo = 'storage/section/intro/' . $nameFile;
            if ($intro->image != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $intro->image));
            }
        }

        $intro->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
            'text_button' => $request->text_button,
            'href_button' => $request->href_button,
            'image' => $photo,
        ]);


        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }
}
