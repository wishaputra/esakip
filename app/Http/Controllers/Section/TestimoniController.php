<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Testimoni;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class TestimoniController extends Controller
{
    protected $route  = "setup.section.testimoni.";
    public function api()
    {
        $testimoni = Testimoni::orderBy('order', 'ASC')->get();

        return DataTables::of($testimoni)

            ->editColumn('poto', function ($p) {
                return "<img src='" . asset($p->poto) . "' width='100' />";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Service'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Service'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action', 'poto'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Testimoni";
        $route = $this->route;
        $txt = TextContent::whereid(4)->first();

        return view('section.testimoni.index', compact('title', 'route', 'txt'));
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
            "nama" => 'required',
            "order" => 'required|numeric',

            "profesi" => 'required',
            "testimoni" => 'required',
            "poto" => 'required',
        ]);

        // Upload Gambar
        $file = $request->file('poto');

        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'testimoni';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/testimoni', $nameFile, 'public');
            $photo = 'storage/section/testimoni/' . $nameFile;
        }

        Testimoni::create([
            "nama" => $request->nama,
            "order" => $request->order,
            "profesi" => $request->profesi,
            "testimoni" => $request->testimoni,
            "poto" => $photo,

        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function show(Testimoni $testimoni)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimoni $testimoni)
    {
        return $testimoni;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Testimoni $testimoni)
    {
        $request->validate([
            "nama" => 'required',
            "order" => 'required|numeric',

            "profesi" => 'required',
            "testimoni" => 'required',

        ]);

        // Upload Gambar
        $file = $request->file('poto');
        $photo = $testimoni->poto;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'testimoni';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/testimoni', $nameFile, 'public');
            $photo = 'storage/section/testimoni/' . $nameFile;
            if ($testimoni->poto != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $testimoni->poto));
            }
        }

        $testimoni->update([
            "nama" => $request->nama,
            "order" => $request->order,
            "profesi" => $request->profesi,
            "testimoni" => $request->testimoni,
            "poto" => $photo,

        ]);

        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Testimoni  $testimoni
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
