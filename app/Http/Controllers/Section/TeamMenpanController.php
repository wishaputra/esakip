<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Team;
use App\Models\TextContent;
use Illuminate\Http\Request;
use Storage;
use Yajra\DataTables\DataTables;

class TeamMenpanController extends Controller
{
    protected $route  = "setup.section.team.";
    public function api_team_menpan()
    {
        $teams = Team::orderBy('order', 'ASC')->get();

        return DataTables::of($teams)

            ->editColumn('poto', function ($p) {
                return "<img src='" . asset($p->poto) . "' width='100' />";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action', 'poto'])
            ->toJson();
    }
    

    public function index()
    {
        $title = "About Team";
        $route = $this->route;
        $txt = TextContent::whereid(5)->first();

        return view('section.team_menpan.index', compact('title', 'route', 'txt'));
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

            "jabatan" => 'required',

            "poto" => 'required',
        ]);

        // Upload Gambar
        $file = $request->file('poto');

        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'team';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/team', $nameFile, 'public');
            $photo = 'storage/section/team/' . $nameFile;
        }

        Team::create([
            "nama" => $request->nama,
            "order" => $request->order,
            "jabatan" => $request->jabatan,
            "facebook_link" => $request->facebook_link,
            "twitter_link" => $request->twitter_link,
            "poto" => $photo,

        ]);
        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    

    public function show(Team $team)
    {
    }

    
    public function edit(Team $team)
    {
        return $team;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        $request->validate([
            "nama" => 'required',
            "order" => 'required|numeric',

            "jabatan" => 'required',



        ]);

        // Upload Gambar
        $file = $request->file('poto');
        $photo = $team->poto;
        if ($file) {
            if (!in_array($file->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'])) {
                return response()->json(['message' => "Terdapat kesalahan saat menyimpan data.<br/>Error Allow Extension."], 422);
            }

            $user_id    = 'team';
            $nameFile   = $user_id . '_' . date('YmdHis') . '_' . rand() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('section/team', $nameFile, 'public');
            $photo = 'storage/section/team/' . $nameFile;
            if ($team->poto != null) {
                Storage::disk('public')->delete(str_replace("storage/", "", $team->poto));
            }
        }

        $team->update([
            "nama" => $request->nama,
            "order" => $request->order,
            "jabatan" => $request->jabatan,
            "facebook_link" => $request->facebook_link,
            "twitter_link" => $request->twitter_link,
            "poto" => $photo,

        ]);

        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return response()->json(["message" => "Berhasil menghapus data!"], 200);
    }
}
