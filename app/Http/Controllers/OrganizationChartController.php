<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frontend;

class OrganizationChartController extends Controller
{

    // Define an index method to handle requests to /organization-chart
    public function index()
    {

        $frontend = Frontend::all();
        $frontend = Frontend::where('file_section', '_chart')->first();

        return view('organization-chart', [
            'frontend' => $frontend,
        ]);
    }

    // Define a saveChart method to handle saving chart data
    public function saveChart(Request $request)
    {
        $chartData = $request->all();

        // Save the chart data to the database

        return response()->json(['message' => 'Chart data saved successfully'], 200);
    }
}