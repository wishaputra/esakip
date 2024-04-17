<?php

namespace App\Http\Controllers;

use App\Models\Cascading\Model_Visi;
use Illuminate\Http\Request;

class NodeController extends Controller
{
    public function getNodes()
    {
        $nodes = Model_Visi::with('misi')->get();

        return response()->json($nodes);
    }
}