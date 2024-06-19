<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Tujuan_Indikator;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Urusan;
use App\Models\Cascading\Model_Urusan_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class UrusanMenpanIndikatorController extends Controller
{
    public function api_urusan_menpan_indikator(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $urusan_indikator   = Model_Urusan_Indikator::whereid_urusan($request->id_urusan)->get();
        // $menu = Sub_menu::wheremenu_id($request->menu_id)->orderBy('no_urut', 'ASC')->get();
        return DataTables::of($urusan_indikator)
            ->addColumn('urusan_nilai_count', function ($p) {
                $count = $p->urusan_nilai->count();
                return "<a  href='".route('setup.urusan_menpan_nilai.index')."?id_indikator=".$p->id."'  title='Nilai Urusan'>".$count."</a>";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a href='#' class='text-secondary' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' class='text-secondary' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['urusan_nilai_count', 'action'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_urusan = $request->id_urusan;
        if (!$id_urusan || !Model_Urusan::whereid($id_urusan)->first()) {
            return redirect()->route('setup.urusan.index');
        }

        $urusan = Model_Urusan::whereid($id_urusan)->get();
    

        return view('cascading.urusan_menpan_indikator.index', compact('urusan', 'id_urusan'));
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
        "id_urusan" => 'required',
        "indikator" => 'required',
    ]);

    Model_Urusan_Indikator::create([
        "id_urusan" => $request->id_urusan,
        "indikator" => $request->indikator,
        "creator" => Auth::user()->id,
    ]);

    return response()->json(["message" => "Berhasil menambahkan data!"], 200);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Model_Urusan_Indikator::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $misi  = Model_Urusan_Indikator::find($id);
        $rule = [
            "indikator" => 'required',
        ];

        $request->validate($rule);

        $misi->update([
            "indikator" => $request->indikator,
            "creator" => Auth::user()->id,
        ]);
        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
{
    $urusan  = Model_Urusan_Indikator::find($id);

    if ($urusan && $urusan->indikator && is_iterable($urusan->indikator)) {
        $count = $urusan->indikator->count();
    } else {
        $count = 0;
    }

    if ($count > 0) {
        return response()->json(["message" => "<center>Hapus Urusan terlebih dahulu</center>"], 500);
    }

    $urusan->delete();
    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}
}
