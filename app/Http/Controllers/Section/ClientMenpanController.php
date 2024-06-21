<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Client;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class ClientMenpanController extends Controller
{
    protected $route  = "setup.section.client.";
    public function api_client_menpan()
    {
        $client = Client::orderBy('order', 'ASC')->get();

        return DataTables::of($client)

            ->editColumn('image', function ($p) {
                return "<img src='" . $p->getImage() . "' width='100px' > ";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['image', 'action'])
            ->toJson();
    }
    
    public function index()
    {
        $title = "Client";
        $route = $this->route;
        $txt = TextContent::whereid(1)->first();

        return view('section.client_menpan.index', compact('title', 'route', 'txt'));
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
            "image" => 'required',
        ]);

        // Upload Gambar
        $file = $request->file('image');

        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'client';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/client', $nameFile, 'public');
            $photo = 'storage/section/client/' . $nameFile;
        }

        Client::create([
            "nama" => $request->nama,
            "order" => $request->order,
            "image" => $photo,
        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    
    public function show(Client $client)
    {
    }

    
    public function edit(Client $client)
    {
        return $client;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            "nama" => 'required',
            "order" => 'required|numeric',

        ]);

        // Upload Gambar
        $file = $request->file('image');
        $photo = $client->image;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'client';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/client', $nameFile, 'public');
            $photo = 'storage/section/client/' . $nameFile;
            if ($client->image != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $client->image));
            }
        }

        $client->update([
            "nama" => $request->nama,
            "order" => $request->order,
            "image" => $photo,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if ($client->image != null) {
            Storage::disk('public')->delete(str_replace("storage/", "", $client->image));
        }
        $client->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
