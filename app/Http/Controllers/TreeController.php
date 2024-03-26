<?php

namespace App\Http\Controllers;

use App\Models\TreeNode;
use Illuminate\Http\Request;

class TreeController extends Controller
{
    public function index()
    {
        $treeNodes = TreeNode::all();
        return view('tree.index', compact('treeNodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'node_key' => 'required',
            'parent_key' => 'nullable',
        ]);

        TreeNode::create([
            'node_key' => $request->node_key,
            'parent_key' => $request->parent_key,
        ]);

        return redirect()->route('tree.index')->with('success', 'Node created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'node_key' => 'required',
            'parent_key' => 'nullable',
        ]);

        $node = TreeNode::findOrFail($id);
        $node->update([
            'node_key' => $request->node_key,
            'parent_key' => $request->parent_key,
        ]);

        return redirect()->route('tree.index')->with('success', 'Node updated successfully.');
    }

    public function destroy($id)
    {
        $node = TreeNode::findOrFail($id);
        $node->delete();

        return redirect()->route('tree.index')->with('success', 'Node deleted successfully.');
    }
}
