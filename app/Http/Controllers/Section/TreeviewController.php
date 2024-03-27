<?php

namespace App\Http\Controllers\Section;

use App\Http\Controllers\Controller;
use App\Models\Section\Tree;


class TreeviewController extends Controller
{
    protected $route  = "setup.section.tree.";
    protected $file_ex = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG', 'doc', 'docx', 'pdf', 'xls', 'xlsx'];

    public function api()
    {
        $trees = Tree::orderBy('order', 'ASC')->get();

        return DataTables::of($trees)

            ->editColumn('file', function ($p) {
                return "<a href='" . $p->getUrl() . "'  >File </a> ";
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='edit(" . $p->id . ")' title='Edit Client'><i class='icon-pencil mr-1'></i></a>
                    <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Client'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['file', 'action'])
            ->toJson();
    }

    public function index()
{
    $title = "Treeview";
    $route = $this->route;
    // Make sure 'section.treeview.index' is the correct path to your view file.
    return view('section.treeview.index', compact('title', 'route'));

}


    

}