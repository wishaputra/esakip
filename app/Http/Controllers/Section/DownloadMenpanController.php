<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Download;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class DownloadMenpanController extends Controller
{
    protected $route  = "setup.section.download.";
    protected $file_ex = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'doc', 'docx', 'pdf', 'xls', 'xlsx'];
    public function api_download_menpan()
    {
        $download = Download::orderBy('order', 'ASC')->get();

        return DataTables::of($download)

            ->editColumn('file', function ($p) {
                return "<a href='" . $p->getUrl() . "'  >File </a> ";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['file', 'action'])
            ->toJson();
    }
    
    public function index()
    {
        $title = "File Download";
        $route = $this->route;


        return view('section.download_menpan.index', compact('title', 'route'));
    }

    
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
            "file" => 'required',
        ]);

        // Upload Gambar
        $file = $request->file('file');

        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), $this->file_ex)) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'download';
            $nameFile   = rand(1, 10) . '_' . $file->getClientOriginalName();
            $file->storeAs('section/download', $nameFile, 'public');
            $file = 'storage/section/download/' . $nameFile;
        }

        Download::create([
            "nama" => $request->nama,
            "order" => $request->order,
            "file" => $file,
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    
    public function show(Download $download)
    {
        //
    }

    
    public function edit(Download $download)
    {
        return $download;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Download $download)
    {
        $request->validate([
            "nama" => 'required',
            "order" => 'required|numeric',

        ]);


        // Upload Gambar
        $file = $request->file('file');
        $file_path = $download->file;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), $this->file_ex)) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'download';
            $nameFile   = rand(1, 10) . '_' . $file->getClientOriginalName();
            $file->storeAs('section/download', $nameFile, 'public');
            $file_path = 'storage/section/download/' . $nameFile;
            if ($download->file != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $download->file));
            }
        }

        $download->update([
            "nama" => $request->nama,
            "order" => $request->order,
            "file" => $file_path,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function destroy(Download $download)
    {
        if ($download->file != null) {
            Storage::disk('public')->delete(str_replace("storage/", "", $download->file));
        }
        $download->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
