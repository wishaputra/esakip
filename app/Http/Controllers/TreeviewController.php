<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    
}
