<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Tujuan_Indikator;
use App\Models\Cascading\Model_Tujuan_Nilai;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class TujuanNilaiController extends Controller
{
    public function api(Request $request)
    {
        // $visi   = Model_Visi::find($request->id_visi)->misi;
        $tujuan_nilai   = Model_Tujuan_Nilai::whereid_indikator_tujuan($request->id_indikator_tujuan)->get();
        return DataTables::of($tujuan_nilai)
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function index(Request $request)
    {
        $id_indikator_tujuan = $request->id_indikator_tujuan;
        if (!$id_indikator_tujuan || !Model_Tujuan_Indikator::whereid($id_indikator_tujuan)->first()) {
            return redirect()->route('setup.tujuan_indikator.index');
        }


        $indikator = Model_Tujuan_Nilai::whereid_indikator_tujuan($id_indikator_tujuan)->get(); 
           // return view('cascading.tujuan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.tujuan_nilai.index', compact('indikator', 'id_indikator_tujuan'));

    }
    public function create()
    {
        // implement create logic or remove this method if not needed
    }

    public function store(Request $request)
    {
        $request->validate([
            "id_indikator_tujuan" => 'required',
            "satuan" => 'required',
            "tahun" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ]);

        Model_Tujuan_Nilai::create([
            "id_indikator_tujuan" => $request->id_indikator_tujuan,
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "target" => $request->target,
            "capaian" => $request->capaian,
            "creator" => Auth::user()->id,
        ]);

        return response()->json(["message" => "Berhasil menambahkan data!"], 200);
    }

    public function show(Model_Tujuan_Nilai $tujuannilai)
    {
        // implement show logic or remove this method if not needed
    }

   public function edit($id)
{
    $tujuanNilai = Model_Tujuan_Nilai::find($id);
    if (!$tujuanNilai) {
        abort(404, 'Model not found');
    }
    return response()->json($tujuanNilai);
}
    public function update(Request $request, Model_Tujuan_Nilai $tujuanNilai)
    {
        $rule = [
            "satuan" => 'required',
            "tahun" => 'required',
            "target" => 'required',
            "capaian" => 'required',
        ];

        $request->validate($rule);

        $tujuanNilai->update([
            "satuan" => $request->satuan,
            "tahun" => $request->tahun,
            "target" => $request->target,
            "capaian" => $request->capaian,
            "creator" => Auth::user()->id,
        ]);

        return response()->json(["message" => "Berhasil merubah data!"], 200);
    }

    public function destroy(Request $request, $id)
{
    $misi  = Model_Tujuan_nilai::find($id);

    if ($misi && $misi->tujuan && is_iterable($misi->tujuan)) {
        $count = $misi->tujuan->count();
    } else {
        $count = 0;
    }

    if ($count > 0) {
        return response()->json(["message" => "<center>Hapus Submenu terlebih dahulu</center>"], 500);
    }

    $misi->delete();
    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}
}