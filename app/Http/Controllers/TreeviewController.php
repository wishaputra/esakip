<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cascading\Model_Visi;
use App\Models\Cascading\Model_Misi;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;

class TreeviewController extends Controller
{
    private $modelMapping = [
        'visi' => Model_Visi::class,
        'misi' => Model_Misi::class,
        'tujuan' => Model_Tujuan::class,
        'sasaran' => Model_Sasaran::class,
    ];

    public function getTreeviewElementDescription(Request $request, $type, $elementId)
    {
        $model = $this->getModel($type);
        $element = $model::find($elementId);

        if (!$element) {
            throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
        }

        return response()->json([
            'title' => $element->title,
            'description' => $element->description,
            'content' => $element->content,
        ]);
    }

    private function getModel($type)
    {
        if (!isset($this->modelMapping[$type])) {
            throw new \InvalidArgumentException("Invalid element type");
        }

        return $this->modelMapping[$type];
    }

    
}