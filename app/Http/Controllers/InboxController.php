<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Str;

class InboxController extends Controller
{
    public function api()
    {
        $menu = Contact::orderBy('status', 'ASC')->orderBy('id', 'ASC')->get();
        return DataTables::of($menu)

            ->editColumn('status', function ($p) {
                $status = $p->status == 1 ? "Read" : "Unread";
                return $status;
            })
            ->editColumn('message', function ($p) {
                // $status = Str::words(trim(strip_tags()), 40, ' ...');
                return $p->message;
            })
            ->editColumn('created_at', function ($p) {
                // $status = Str::words(trim(strip_tags()), 40, ' ...');
                return $p->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($p) {
                return "
                    <a  href='#' onclick='show(" . $p->id . ")' title='Lihat'><i class='icon-eye mr-1'></i></a>";
                // <a href='#' onclick='remove(".$p->id.")' class='text-danger' title='Hapus Menu'><i class='icon-remove'></i></a>";
            })
            ->rawColumns(['action', 'status', 'created_at'])
            ->toJson();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Inbox";
        // dd('a');
        return view('inbox.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $inbox)
    {
        $inbox->update([
            "status" => 1
        ]);
        return $inbox;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $inbox)
    {
        return $inbox;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        //
    }

    public function countI()
    {
        return Contact::where('status', 0)->count();
    }
}
