<?php

namespace App\Http\Controllers\Cascading;

use App\Http\Controllers\Controller;
use App\Models\Cascading\Model_Kegiatan_Nilai;
use App\Models\Cascading\Model_program_Nilai;
use Illuminate\Support\Facades\Auth;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Kegiatan;
use App\Models\Cascading\Model_Kegiatan_Indikator;
use Illuminate\Http\Request;
use yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class KegiatanNilaiController extends Controller
{
    public function api(Request $request)
    {
        $kegiatan_nilai = Model_Kegiatan_Nilai::whereid_indikator_kegiatan($request->id_indikator_kegiatan)->get();
    
        return DataTables::of($kegiatan_nilai)
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
        $id_indikator_kegiatan = $request->id_indikator_kegiatan;
        if (!$id_indikator_kegiatan || !Model_Kegiatan_Indikator::whereid($id_indikator_kegiatan)->first()) {
            return redirect()->route('setup.kegiatan_indikator.index');
        }

      
        $indikator = Model_Kegiatan_Indikator::whereid($id_indikator_kegiatan)->get();
        $tahun  = Model_Visi::all();


        // return view('cascading.kegiatan_indikator.index', compact('title', 'id_visi', 'visi'));
        return view('cascading.kegiatan_nilai.index', compact('indikator','id_indikator_kegiatan','tahun'));
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
        "id_indikator_kegiatan" => 'required',
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    // Store the new Kegiatan Nilai
    $kegiatanNilai = Model_Kegiatan_Nilai::create([
        "id_indikator_kegiatan" => $request->id_indikator_kegiatan,
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    // Update the pagu for the associated Kegiatan
    $this->updatePaguKegiatan($request->id_indikator_kegiatan);

    // Calculate the total pagu for the program
    $id_program = Model_Kegiatan_Indikator::find($request->id_indikator_kegiatan)
        ->kegiatan
        ->id_program;

    $totalPaguProgram = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function ($query) use ($id_program) {
        $query->whereHas('kegiatan', function ($query) use ($id_program) {
            $query->where('id_program', $id_program);
        });
    })->sum('pagu');

    $programNilai = Model_Program_Nilai::whereHas('program_indikator', function ($query) use ($id_program) {
        $query->where('id_program', $id_program);
    })->first();

    if ($programNilai) {
        $programNilai->update(['pagu' => $totalPaguProgram]);
    } else {
        // Optionally, handle the case where no `Model_Program_Nilai` exists for this program
    }

    return response()->json(["message" => "Berhasil menambahkan data!"], 200);
}




   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        return Model_Kegiatan_nilai::find($id);
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
    $kegiatanNilai = Model_Kegiatan_Nilai::find($id);
    if (!$kegiatanNilai) {
        return response()->json(["message" => "Data tidak ditemukan!"], 404);
    }

    $request->validate([
        "satuan" => 'required',
        "tahun" => 'required',
        "triwulan" => 'required',
        "pagu" => 'required',
        "target" => 'required',
        "capaian" => 'required',
    ]);

    $oldPagu = $kegiatanNilai->pagu;

    $kegiatanNilai->update([
        "satuan" => $request->satuan,
        "tahun" => $request->tahun,
        "triwulan" => $request->triwulan,
        "pagu" => $request->pagu,
        "target" => $request->target,
        "capaian" => $request->capaian,
        "creator" => Auth::user()->id,
    ]);

    $this->updatePaguKegiatan($kegiatanNilai->id_indikator_kegiatan);

    $id_program = $kegiatanNilai->kegiatan_indikator->kegiatan->id_program;

    $totalPaguProgram = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function ($query) use ($id_program) {
        $query->whereHas('kegiatan', function ($query) use ($id_program) {
            $query->where('id_program', $id_program);
        });
    })->sum('pagu');

    $programNilai = Model_Program_Nilai::whereHas('program_indikator', function ($query) use ($id_program) {
        $query->where('id_program', $id_program);
    })->first();

    if ($programNilai) {
        $programNilai->update(['pagu' => $totalPaguProgram - $oldPagu + $request->pagu]);
    }

    return response()->json(["message" => "Berhasil merubah data!"], 200);
}




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $kegiatanNilai = Model_Kegiatan_Nilai::find($id);
    if (!$kegiatanNilai) {
        return response()->json(["message" => "Data tidak ditemukan!"], 404);
    }

    $id_indikator_kegiatan = $kegiatanNilai->id_indikator_kegiatan;
    $oldPagu = $kegiatanNilai->pagu;

    $kegiatanNilai->delete();

    $this->updatePaguKegiatan($id_indikator_kegiatan);

    $id_program = $kegiatanNilai->kegiatan_indikator->kegiatan->id_program;

    $totalPaguProgram = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function ($query) use ($id_program) {
        $query->whereHas('kegiatan', function ($query) use ($id_program) {
            $query->where('id_program', $id_program);
        });
    })->sum('pagu');

    $programNilai = Model_Program_Nilai::whereHas('program_indikator', function ($query) use ($id_program) {
        $query->where('id_program', $id_program);
    })->first();

    if ($programNilai) {
        $programNilai->update(['pagu' => $totalPaguProgram - $oldPagu]);
    }

    return response()->json(["message" => "Berhasil menghapus data!"], 200);
}



private function updatePaguKegiatan($id_indikator_kegiatan)
    {
        $kegiatanIndikator = Model_Kegiatan_Indikator::find($id_indikator_kegiatan);
        if ($kegiatanIndikator) {
            $id_kegiatan = $kegiatanIndikator->id_kegiatan;

            // Sum pagu from all related kegiatan_nilai
            $totalPagu = Model_Kegiatan_Nilai::where('id_indikator_kegiatan', $id_indikator_kegiatan)->sum('pagu');

            // Find the related kegiatan_nilai and update its pagu
            $kegiatanNilai = Model_Kegiatan_Nilai::where('id_indikator_kegiatan', $id_indikator_kegiatan)->first();
            if ($kegiatanNilai) {
                $kegiatanNilai->update(['pagu' => $totalPagu]);
            }

            // Also update the related program_nilai
            $id_program = $kegiatanIndikator->kegiatan->id_program;
            $totalPaguProgram = Model_Kegiatan_Nilai::whereHas('kegiatan_indikator', function ($query) use ($id_program) {
                $query->whereHas('kegiatan', function ($query) use ($id_program) {
                    $query->where('id_program', $id_program);
                });
            })->sum('pagu');

            $programNilai = Model_Program_Nilai::where('id_indikator_program', $id_program)->first();
            if ($programNilai) {
                $programNilai->update(['pagu' => $totalPaguProgram]);
            }
        }
    }


}
