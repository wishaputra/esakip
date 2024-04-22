<?php

namespace App\Http\Controllers;

use App\Models\Section\Tree;
use App\Models\Business;
use App\Models\Cascading\Model_Visi;
use App\Models\Chart;
use App\Models\Category;
use App\Models\CategoryBusiness;
use App\Models\Contact;
use App\Models\Menu;
use App\Models\Post;
use App\Models\Section\Download;
use App\Models\Section\Team;
use App\Models\Sub_menu;
use App\Models\TextContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
  	 public function download2()
    {
        $filePath = public_path('files/usermanual.pdf');
        return response()->download($filePath, 'usermanual.pdf');
    }

    public function displaypdf3()
{
    $filePath = public_path('files/usermanual.pdf');
    return response()->file($filePath, ['Content-Type' => 'application/pdf']);
}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth')->except(['publik','getLayer']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Dashboard";

        return view('home', compact('title'));
    }

    public function getLayer($id)
    {
        $sub_menu = Sub_menu::whereid($id)->first();
        return response()->json($sub_menu);
    }

    public function front()
    {
        $blogs = Post::orderBy('id', 'DESC')->where(['type' => 'blog', 'status' => 'Publish'])->limit(3)->get();
        $teams = Team::orderBy('order', 'asc')->get();
        $cat_business = CategoryBusiness::orderBy('order', 'asc')->limit(11)->get();
        // dd($cat_business);
        return view('front.index', compact('blogs', 'teams', 'cat_business'));
        // if ($user = Auth::user()) {
        //     return redirect()->route('home');
        // }
    }
    public function team()
    {
        $title = TextContent::whereid(5)->first()->title;

        $breadcrumbs = [$title];
        $teams = Team::orderBy('order', 'asc')->get();
        return view('front.custom.team', compact('teams', 'title', 'breadcrumbs'));
        // if ($user = Auth::user()) {
        //     return redirect()->route('home');
        // }
    }

    public function page($slug)
    {
        $post = Post::where('slug', $slug)->where('type', 'page')->first();
        $breadcrumbs = ['Page', $post->title];
        if (!$post || $post->status == "Draft") {
            return abort(404);
        }
        return view('front.custom_page.page', compact('post', 'breadcrumbs'));
    }

    public function blog($slug)
    {
        $post = Post::where('slug', $slug)->where('type', 'blog')->first();
        $breadcrumbs = ['Blog', $post->title];
        if (!$post || $post->status == "Draft") {
            return abort(404);
        }
        return view('front.blog.details', compact('post', 'breadcrumbs'));
    }
    public function blog_all()
    {
        $title = "All Posts";
        $posts = Post::orderBy('id', 'DESC')->where(['type' => 'blog', 'status' => 'Publish'])->with(['category'])->paginate(5);
        // dd($posts);
        $breadcrumbs = ['Blog'];
        return view('front.blog.all', compact('posts', 'breadcrumbs', 'title'));
    }
    public function blog_category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            return abort(404);
        }
        $title = "Category Blog " . $category->nama;
        $posts = Post::orderBy('id', 'DESC')->where(['type' => 'blog', 'status' => 'Publish', 'post_category_id' => $category->id])->with(['category'])->paginate(5);
        // dd($posts);
        $breadcrumbs = ['Blog', 'Category ' . $category->nama];
        return view('front.blog.all', compact('posts', 'breadcrumbs', 'title'));
    }

    public function business($slug)
    {
        $business = Business::where('slug', $slug)->where('type', 'business')->first();
        if (!$business || $business->status == "Draft") {
            return abort(404);
        }
        $breadcrumbs = ['Business', $business->title];
        return view('front.business.details', compact('business', 'breadcrumbs'));
    }
    public function business_all()
    {
        $title = "All Business";
        $businesses = Business::orderBy('id', 'DESC')->where(['type' => 'business', 'status' => 'Publish'])->with(['category'])->paginate(5);
        // dd($businesses);
        $breadcrumbs = ['Business'];
        return view('front.business.all', compact('businesses', 'breadcrumbs', 'title'));
    }
    public function business_category($slug)
    {
        $category = CategoryBusiness::where('slug', $slug)->first();
        if (!$category) {
            return abort(404);
        }
        $title = "Category Business " . $category->name;
        $businesses = Business::orderBy('id', 'DESC')->where(['type' => 'business', 'status' => 'Publish', 'business_category_id' => $category->id])->with(['category'])->paginate(5);
        // dd($businesses);
        $breadcrumbs = ['Business', 'Category ' . $category->name];
        return view('front.business.all', compact('businesses', 'breadcrumbs', 'title'));
    }
    public function contact_store(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "email" => 'required|email',
            "phone" => 'required|numeric',
            "message" => 'required',
        ]);

        Contact::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "message" => $request->message,
            "status" => 0
        ]);
        return response()->json(["message" => "Success!"], 200);
    }

    public function download()
    {
        $files = Download::orderBy('order')->get();
        $breadcrumbs = ['Download'];
        $title = 'File Download';

        return view('front.custom_page.download', compact('breadcrumbs', 'files', 'title'));
    }
    
    public function treeview()
    {
        $breadcrumbs = ['treeview'];
        $title = "Cascading Tree";
        $visi   = Model_Visi::all();
        // Make sure 'section.treeview.index' is the correct path to your view file.
        return view('front.custom_page.treeview', compact('title','visi'));
    
    }
    public function Chart()
    {
        $breadcrumbs = ['chart'];
        $title = "Cascading Struktur";
        $visi   = Model_Visi::all();
        // Make sure 'section.treeview.index' is the correct path to your view file.
        return view('front.custom_page.struktur', compact('title','visi'));
    
    }

    public function search(Request $request)
    {
        $hasil  = Post::where('title','like','%'.$request->search.'%')->orWhere('content','like','%'.$request->search.'%')->get();
        $cari   = $request->search;

        return view('front.custom_page.search', compact('hasil','cari'));
    }
}
