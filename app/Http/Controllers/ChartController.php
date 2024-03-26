<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chart;

class ChartController extends Controller
{
    public function saveChart(Request $request) {
        try {
            $chartData = $request->input('chartData');
            \Log::info('Chart data received:', ['chartData' => $chartData]); // Log the received data
    
            // Save $chartData to the database using the Chart model
            $chart = new Chart;
            $chart->data = json_encode($chartData); // Ensure your column can store JSON/string data
            $saveStatus = $chart->save();
    
            if ($saveStatus) {
                return response()->json(['success' => true, 'message' => 'Chart data saved successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Failed to save chart data']);
            }
        } catch (\Exception $e) {
            \Log::error('Error saving chart data: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save chart data', 'error' => $e->getMessage()]);
        }
    }
    

    public function loadChart() {
        $chartData = Chart::latest()->first(); // Assuming you have a model called ChartModel
        if ($chartData) {
            // Assuming your JSON is stored in a column named 'data'
            $decodedData = json_decode($chartData->data, true);
            return response()->json($decodedData);
        } else {
            return response()->json(['error' => 'No chart data found'], 404);
        }
    }
    
    
}
