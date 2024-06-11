<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cascading\Model_Sasaran_Indikator;
use App\Models\Cascading\Model_Sasaran_Nilai;

class TreeViewController extends Controller
{
    public function getTujuanIndikator($id)
    {
        $indikator = DB::table('cascading_tujuan_indikator')->where('id_tujuan', $id)->get();
        return response()->json($indikator);
    }

    public function getTujuanNilai($id)
    {
        $nilai = DB::table('cascading_tujuan_nilai')
                    ->join('cascading_tujuan_indikator', 'cascading_tujuan_nilai.id_indikator_tujuan', '=', 'cascading_tujuan_indikator.id')
                    ->where('cascading_tujuan_indikator.id_tujuan', $id)
                    ->select('cascading_tujuan_nilai.*')
                    ->get();
        return response()->json($nilai);
    }

    public function getSasaranIndikator($id)
    {
        $indikator = DB::table('cascading_sasaran_indikator')->where('id_sasaran', $id)->get();
        return response()->json($indikator);
    }

    public function getSasaranNilai($id)
    {
        $nilai = DB::table('cascading_sasaran_nilai')
                    ->join('cascading_sasaran_indikator', 'cascading_sasaran_nilai.id_indikator_sasaran', '=', 'cascading_sasaran_indikator.id')
                    ->where('cascading_sasaran_indikator.id_sasaran', $id)
                    ->select('cascading_sasaran_nilai.*')
                    ->get();
        return response()->json($nilai);
    }


    public function getUrusanIndikator($id)
    {
        $indikator = DB::table('cascading_urusan_indikator')->where('id_urusan', $id)->get();
        return response()->json($indikator);
    }


    public function getUrusanNilai($id)
    {
        $nilai = DB::table('cascading_urusan_nilai')
                    ->join('cascading_urusan_indikator', 'cascading_urusan_nilai.id_indikator_urusan', '=', 'cascading_urusan_indikator.id')
                    ->where('cascading_urusan_indikator.id_urusan', $id)
                    ->select('cascading_urusan_nilai.*')
                    ->get();
        return response()->json($nilai);
    }


    public function getTujuanRenstraIndikator($id)
    {
        $indikator = DB::table('cascading_tujuan_renstra_indikator')->where('id_tujuan_renstra', $id)->get();
        return response()->json($indikator);
    }

    public function getTujuanRenstraNilai($id)
    {
        $nilai = DB::table('cascading_tujuan_renstra_nilai')
                    ->join('cascading_tujuan_renstra_indikator', 'cascading_tujuan_renstra_nilai.id_indikator_tujuan_renstra', '=', 'cascading_tujuan_renstra_indikator.id')
                    ->where('cascading_tujuan_renstra_indikator.id_tujuan_renstra', $id)
                    ->select('cascading_tujuan_renstra_nilai.*')
                    ->get();
        return response()->json($nilai);
    }

    public function getSasaranRenstraIndikator($id)
    {
        $indikator = DB::table('cascading_sasaran_renstra_indikator')->where('id_sasaran_renstra', $id)->get();
        return response()->json($indikator);
    }

    public function getSasaranRenstraNilai($id)
    {
        $nilai = DB::table('cascading_sasaran_renstra_nilai')
                    ->join('cascading_sasaran_renstra_indikator', 'cascading_sasaran_renstra_nilai.id_indikator_sasaran_renstra', '=', 'cascading_sasaran_renstra_indikator.id')
                    ->where('cascading_sasaran_renstra_indikator.id_sasaran_renstra', $id)
                    ->select('cascading_sasaran_renstra_nilai.*')
                    ->get();
        return response()->json($nilai);
    }

    public function getProgramIndikator($id)
    {
        $indikator = DB::table('cascading_program_indikator')->where('id_program', $id)->get();
        return response()->json($indikator);
    }

    public function getProgramNilai($id)
    {
        $nilai = DB::table('cascading_program_nilai')
                    ->join('cascading_program_indikator', 'cascading_program_nilai.id_indikator_program', '=', 'cascading_program_indikator.id')
                    ->where('cascading_program_indikator.id_program', $id)
                    ->select('cascading_program_nilai.*')
                    ->get();
        return response()->json($nilai);
    }

    public function getKegiatanIndikator($id)
    {
        $indikator = DB::table('cascading_kegiatan_indikator')->where('id_kegiatan', $id)->get();
        return response()->json($indikator);
    }

    public function getKegiatanNilai($id)
    {
        $nilai = DB::table('cascading_kegiatan_nilai')
                    ->join('cascading_kegiatan_indikator', 'cascading_kegiatan_nilai.id_indikator_kegiatan', '=', 'cascading_kegiatan_indikator.id')
                    ->where('cascading_kegiatan_indikator.id_kegiatan', $id)
                    ->select('cascading_kegiatan_nilai.*')
                    ->get();
        return response()->json($nilai);
    }

    public function getSubKegiatanIndikator($id)
{
    $indikator = DB::table('cascading_sub_kegiatan_indikator')->where('id_sub_kegiatan', $id)->get();
    return response()->json($indikator);
}

public function getSubKegiatanNilai($id)
{
    $nilai = DB::table('cascading_sub_kegiatan_nilai')
                ->join('cascading_sub_kegiatan_indikator', 'cascading_sub_kegiatan_nilai.id_indikator_sub_kegiatan', '=', 'cascading_sub_kegiatan_indikator.id')
                ->where('cascading_sub_kegiatan_indikator.id_sub_kegiatan', $id)
                ->select('cascading_sub_kegiatan_nilai.*')
                ->get();
    return response()->json($nilai);
}

}
