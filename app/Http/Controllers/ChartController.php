<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;

class ChartController extends Controller
{
    

    public function loadChart()
{
    // Fetch data from the Model_Visi
    $visiNodes = Model_Visi::all()->map(function($visi) {
        return [
            'key' => $visi->id,
            'visi' => $visi->visi,
            'tahun_awal' => $visi->tahun_awal,
            'tahun_akhir' => $visi->tahun_akhir,
            // Add other necessary fields here
        ];
    });

    // Example response structure expected by GoJS
    $response = [
        'nodeDataArray' => $visiNodes->toArray(),
        'linkDataArray' => [] // Assuming you handle links separately
    ];

    return response()->json($response);
}
    
    public function loadVisi() {
        $visiData = Model_Visi::all()->toArray();
        return response()->json($visiData);
    }
    
    public function loadMisi() {
        $misiData = Model_Misi::all()->toArray();
        return response()->json($misiData);
    }
    
    public function loadTujuan() {
        $tujuanData = Model_Tujuan::all()->toArray();
        return response()->json($tujuanData);
    }
    
    
}
