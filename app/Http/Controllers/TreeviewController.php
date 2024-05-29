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

    
}
