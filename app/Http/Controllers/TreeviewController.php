<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;

class TreeviewController extends Controller
{
    public function getTreeviewElementDescription(Request $request, $type)
    {
        $elementId = $request->input('element_id');

        switch ($type) {
            case 'visi':
                $element = Model_Visi::find($elementId);
                break;
            case 'misi':
                $element = Model_Misi::find($elementId);
                break;
            case 'tujuan':
                $element = Model_Tujuan::find($elementId);
                break;
            case 'sasaran':
                $element = Model_Sasaran::find($elementId);
                break;
            default:
                return response()->json(['error' => 'Invalid element type']);
        }

        if ($element) {
            return response()->json([
                'title' => $element->title,
                'description' => $element->description,
                'content' => $element->content,
            ]);
        } else {
            return response()->json(['error' => 'Element not found']);
        }
    }
}