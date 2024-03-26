<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Slider;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class SliderController extends Controller
{
    protected $route  = "setup.section.slider.";
    public function api()
    {
        $slider = Slider::orderBy('order', 'ASC')->get();

        return DataTables::of($slider)

            ->editColumn('image', function ($p) {
                return "<img src='" . $p->getImage() . "' width='100px' > ";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Slider'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Slider'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['image', 'action'])
            ->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $title = "Slider";
        $route = $this->route;


        return view('section.slider.index', compact('title', 'route'));
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
            // "judul" => 'required',
            // "deskripsi" => 'required',
            "order" => 'required|numeric',
            "image" => 'required',
        ]);

        // Upload Gambar
        $file = $request->file('image');

        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'slider';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/slider', $nameFile, 'public');
            $photo = 'storage/section/slider/' . $nameFile;
        }

        Slider::create([
            "title" => $request->judul,
            "description" => $request->deskripsi,
            "link" => $request->link,
            "order" => $request->order,
            "image" => $photo,
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit(Slider $slider)
    {
        return $slider;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            // "judul" => 'required',
            // "deskripsi" => 'required',
            "order" => 'required|numeric',

        ]);

        // Upload Gambar
        $file = $request->file('image');
        $photo = $slider->image;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'slider';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/slider', $nameFile, 'public');
            $photo = 'storage/section/slider/' . $nameFile;
            if ($slider->image != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $slider->image));
            }
        }

        $slider->update([
            "title" => $request->judul,
            "description" => $request->deskripsi,
            "link" => $request->link,
            "order" => $request->order,
            "image" => $photo,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy(Slider $slider)
    {
        if ($slider->image != null) {
            Storage::disk('public')->delete(str_replace("storage/", "", $slider->image));
        }
        $slider->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
