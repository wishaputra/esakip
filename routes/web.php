<?php

use App\Http\Controllers\TreeController;
use App\Models\OrganizationChartModel;
use App\Http\Controllers\OrganizationChartController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CategoryBusinessController;
use App\Http\Controllers\Section\DownloadController;
use App\Http\Controllers\TreeviewController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\Cascading\VisiController;
use App\Http\Controllers\Cascading\MisiController;
use App\Http\Controllers\Cascading\TujuanController;
use App\Http\Controllers\Cascading\TujuanIndikatorController;
use App\Http\Controllers\Cascading\TujuanNilaiController;
use App\Http\Controllers\Cascading\SasaranController;
use App\Http\Controllers\Cascading\SasaranIndikatorController;
use App\Http\Controllers\Cascading\SasaranNilaiController;
use App\Http\Controllers\Cascading\PerangkatDaerahController;
use App\Http\Controllers\Cascading\TujuanRenstraController;
use App\Http\Controllers\Cascading\TujuanRenstraIndikatorController;
use App\Http\Controllers\Cascading\TujuanRenstraNilaiController;
use App\Http\Controllers\Cascading\SasaranRenstraController;
use App\Http\Controllers\Cascading\SasaranRenstraIndikatorController;
use App\Http\Controllers\Cascading\SasaranRenstraNilaiController;
use App\Http\Controllers\Cascading\ProgramController;
use App\Http\Controllers\Cascading\ProgramIndikatorController;
use App\Http\Controllers\Cascading\ProgramNilaiController;
use App\Http\Controllers\Cascading\KegiatanController;
use App\Http\Controllers\Cascading\KegiatanIndikatorController;
use App\Http\Controllers\Cascading\KegiatanNilaiController;
use App\Http\Controllers\Cascading\SubKegiatanController;
use App\Http\Controllers\Cascading\SubKegiatanIndikatorController;
use App\Http\Controllers\Cascading\SubKegiatanNilaiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\Section\ClientController;
use App\Http\Controllers\Section\ContactController;
use App\Http\Controllers\Section\IntroController;
use App\Http\Controllers\Section\PricingController;
use App\Http\Controllers\Section\ServiceController;
use App\Http\Controllers\Section\VideoController;
use App\Http\Controllers\Section\SliderController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\Section\TestimoniController;
use App\Http\Controllers\Section\TeamController;
use App\Http\Controllers\SubMenu2Controller;
use App\Http\Controllers\TextContentController;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use App\Models\TreeNode;
use App\Models\ChildNode;
use App\Models\Frontend;
use App\Models\Section\Pricing;
use App\Models\TextContent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Models\Cascading\Model_Tujuan_Indikator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

//---------------- CASCADING START ---------------- //

Route::get('/getMisiByTahun/{id}', [TujuanController::class, 'getMisiByTahun'])->name('getMisiByTahun');
Route::get('/get-tujuan-by-tahun/{id}', [SasaranController::class, 'getTujuanByTahun'])->name('getTujuanByTahun');
Route::get('/get-sasaran-by-tahun/{id}', [TujuanRenstraController::class,'getSasaranByTahun'])->name('getSasaranByTahun');
Route::get('/getTujuanRenstraByTahun/{id}', [SasaranRenstraController::class,'getTujuanRenstraByTahun'])->name('getTujuanRenstraByTahun');
Route::get('/get-sasaran-renstra-by-tahun/{id}', [ProgramController::class,'getSasaranRenstraByTahun'])->name('getSasaranRenstraByTahun');
Route::get('/get-program-by-tahun/{id}', [KegiatanController::class,'getProgramByTahun'])->name('getProgramByTahun');
Route::get('/get-kegiatan-by-tahun/{id}', [SubKegiatanController::class,'getKegiatanByTahun'])->name('getKegiatanByTahun');
Route::get('tujuan-nilai/{id}/edit', [TujuanNilaiController::class, 'edit'])->name('tujuan-nilai.edit');



Route::get('/visi', function () {
    return view('cascading.visi.index');
})->name('visi');

Route::get('/misi', function () {
    return view('cascading.misi.index');
})->name('misi');

Route::get('/tujuan', function () {
    return view('cascading.tujuan.index');
})->name('tujuan');

Route::get('/tujuan_indikator', function () {
    return view('cascading.tujuan_indikator.index');
})->name('tujuan_indikator');

Route::get('/tujuan_nilai', function () {
    return view('cascading.tujuan_nilai.index');
})->name('tujuan_nilai');

Route::get('/sasaran', function () {
    return view('cascading.sasaran.index');
})->name('sasaran');

Route::get('/sasaran_indikator', function () {
    return view('cascading.sasaran_indikator.index');
})->name('sasaran_indikator');

Route::get('/sasaran_nilai', function () {
    return view('cascading.sasaran_nilai.index');
})->name('sasaran_nilai');

Route::get('/perangkat_daerah', function () {
    return view('cascading.perangkat_daerah.index');
})->name('perangkat_daerah');

Route::get('/tujuan_renstra', function () {
    return view('cascading.tujuan_renstra.index');
})->name('tujuan_renstra');

Route::get('/tujuan_renstra_indikator', function () {
    return view('cascading.tujuan_renstra_indikator.index');
})->name('tujuan_renstra_indikator');

Route::get('/tujuan_renstra_nilai', function () {
    return view('cascading.tujuan_renstra_nilai.index');
})->name('tujuan_renstra_nilai');

Route::get('/tujuan-nodes', function () {
    $tujuanNodes = Model_Tujuan::all();
    return response()->json($tujuanNodes);
});

Route::get('/sasaran_renstra', function () {
    return view('cascading.sasaran_renstra.index');
})->name('sasaran_renstra');

Route::get('/sasaran_renstra_indikator', function () {
    return view('cascading.sasaran_renstra_indikator.index');
})->name('sasaran_renstra_indikator');

Route::get('/sasaran_renstra_nilai', function () {
    return view('cascading.sasaran_renstra_nilai.index');
})->name('sasaran_renstra_nilai');

Route::get('/sasaran-nodes', function () {
    $sasaran = Model_Sasaran::all();
    return response()->json($sasaran);
});

Route::get('/program', function () {
    return view('cascading.program.index');
})->name('program');

Route::get('/program_indikator', function () {
    return view('cascading.program_indikator.index');
})->name('program_indikator');

Route::get('/program_nilai', function () {
    return view('cascading.program_nilai.index');
})->name('program_nilai');

Route::get('/kegiatan', function () {
    return view('cascading.kegiatan.index');
})->name('kegiatan');

Route::get('/kegiatan_indikator', function () {
    return view('cascading.kegiatan_indikator.index');
})->name('kegiatan_indikator');

Route::get('/kegiatan_nilai', function () {
    return view('cascading.kegiatan_nilai.index');
})->name('kegiatan_nilai');

Route::get('/subkegiatan', function () {
    return view('cascading.subkegiatan.index');
})->name('subkegiatan');

Route::get('/subkegiatan_indikator', function () {
    return view('cascading.subkegiatan_indikator.index');
})->name('subkegiatan_indikator');

Route::get('/subkegiatan_nilai', function () {
    return view('cascading.subkegiatan_nilai.index');
})->name('subkegiatan_nilai');

//treeview
Route::get('/tree-data', function () {
    $nodes = TreeNode::all();
    return response()->json($nodes);
});
Route::get('/child-nodes', function () {
    $childNodes = ChildNode::all();
    return response()->json($childNodes);
});

//---------------- CASCADING END ---------------- //



Route::get('tree-view', function () {
    return view('tree-view');
})->name('tree-view');

Route::get('/org-chart', function () {
    return view('org-chart');
});


// Route to render the organization chart view
Route::get('/organization-chart', [OrganizationChartController::class, 'index'])->name('organization-chart.index');

// Route to save chart data

Route::get('/load-chart/{tahun_awal}/{tahun_akhir}', [ChartController::class, 'loadChart'])->name('loadChart');

Route::get('/get-periods', function() {
    return App\Models\Cascading\Model_Visi::select('tahun_awal', 'tahun_akhir')->distinct()->get();
});
Route::get('/load-chart', [ChartController::class, 'loadChart']);
Route::get('/load-visi', [ChartController::class,'loadvisi']);
Route::get('/load-misi', [ChartController::class,'loadmisi']);
Route::get('/load-tujuan', [ChartController::class,'loadtujuan']);
Route::get('/struktur', [ChartController::class, 'getperiods']);
Route::post('/api/load-chart', [ChartController::class, 'loadChart']);




//treview
Route::get('/getTujuanIndikator/{id}', [TreeViewController::class, 'getTujuanIndikator']);
Route::get('/getTujuanNilai/{id}', [TreeViewController::class, 'getTujuanNilai']);

Route::get('/getSasaranIndikator/{id}', [TreeViewController::class, 'getSasaranIndikator']);
Route::get('/getSasaranNilai/{id}', [TreeViewController::class, 'getSasaranNilai']);

route::get('/getTujuanRenstraIndikator/{id}', [TreeViewController::class, 'getTujuanRenstraIndikator']);
route::get('/getTujuanRenstraNilai/{id}', [TreeViewController::class, 'getTujuanRenstraNilai']);

route::get('/getSasaranRenstraIndikator/{id}', [TreeViewController::class, 'getSasaranRenstraIndikator']);
route::get('/getSasaranRenstraNilai/{id}', [TreeViewController::class, 'getSasaranRenstraNilai']);

route::get('/getProgramIndikator/{id}', [TreeViewController::class, 'getProgramIndikator']);
route::get('/getProgramNilai/{id}', [TreeViewController::class, 'getProgramNilai']);

route::get('/getKegiatanIndikator/{id}', [TreeViewController::class, 'getKegiatanIndikator']);
route::get('/getKegiatanNilai/{id}', [TreeViewController::class, 'getKegiatanNilai']);

Route::get('/getSubKegiatanIndikator/{id}', [TreeViewController::class, 'getSubKegiatanIndikator']);
Route::get('/getSubKegiatanNilai/{id}', [TreeViewController::class, 'getSubKegiatanNilai']);






Route::get('download2', [HomeController::class, 'download2'])->name('main.download');
Route::get('displaypdf3', [HomeController::class, 'displaypdf3'])->name('main.displaypdf');
Route::get('/', [App\Http\Controllers\HomeController::class, 'front'])->name('front');
Route::post('/contact', [App\Http\Controllers\HomeController::class, 'contact_store'])->name('front.contact_store');
Route::get('/page/s/{slug}', [HomeController::class, 'page'])->name('main.page');
Route::get('/page/team', [HomeController::class, 'team'])->name('main.team');

Route::get('/download', [HomeController::class, 'download'])->name('main.download');
Route::get('/treeview', [HomeController::class, 'treeview'])->name('main.treeview');
Route::post('/search', [HomeController::class, 'search'])->name('search');

Route::get('/blog/s/{slug}', [HomeController::class, 'blog'])->name('main.page.blog');
Route::get('/blog/c/{slug}', [HomeController::class, 'blog_category'])->name('main.page.category');
Route::get('/blog/all', [HomeController::class, 'blog_all'])->name('main.page.blog_all');

Route::get('/business/s/{slug}', [HomeController::class, 'business'])->name('main.page.business');
Route::get('/business/c/{slug}', [HomeController::class, 'business_category'])->name('main.page.category_business');
Route::get('/business/all', [HomeController::class, 'business_all'])->name('main.page.business_all');

Route::get('/admin', [App\Http\Controllers\HomeController::class, 'index'])->name('admin')->middleware('auth');
Route::post('/home/chart', [App\Http\Controllers\HomeController::class, 'get_chart'])->name('get_chart')->middleware('auth');
Route::post('/getLayer/{id}', [HomeController::class, 'getLayer'])->name('getLayer');

Route::middleware('auth')->prefix('account')->name('account.')->group(function () {
    Route::get('profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('profile/updateFoto', [AccountController::class, 'updateFoto'])->name('updateFoto');

    Route::get('password', [AccountController::class, 'password'])->name('password');
    Route::patch('password', [AccountController::class, 'updatePassword'])->name('Uppassword');
});

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::post('posts/api', [PostController::class, 'api'])->name('posts.api');
    Route::resource('posts', PostController::class);

    Route::post('inbox/api', [InboxController::class, 'api'])->name('inbox.api');
    Route::get('inbox/count', [InboxController::class, 'countI'])->name('inbox.count');
    Route::resource('inbox', InboxController::class);

    Route::post('blog/api', [BlogController::class, 'api'])->name('blog.api');
    Route::resource('blog', BlogController::class)->parameters([
        'blog' => 'post'
    ]);

    Route::prefix('business')->name('business.')->group(function () {
        Route::post('category/api', [CategoryBusinessController::class, 'api'])->name('category.api');
        Route::resource('category', CategoryBusinessController::class);

        Route::post('list/api', [BusinessController::class, 'api'])->name('list.api');
        Route::resource('list', BusinessController::class);
    });

    Route::middleware('auth')->prefix('setup')->name('setup.')->group(function () {
         // Route::prefix('cascading')->name('cascading.')->group(function () {
            Route::post('visi/api', [VisiController::class, 'api'])->name('visi.api');
            Route::resource('visi', VisiController::class);

            Route::post('misi/api', [MisiController::class, 'api'])->name('misi.api');
            Route::resource('misi', MisiController::class);

            Route::post('tujuan/api', [TujuanController::class, 'api'])->name('tujuan.api');
            Route::resource('tujuan', TujuanController::class);
            Route::post('tujuan_indikator/api', [TujuanIndikatorController::class, 'api'])->name('tujuan_indikator.api');
            Route::resource('tujuan_indikator', TujuanIndikatorController::class);
            Route::post('tujuan_nilai/api', [TujuanNilaiController::class, 'api'])->name('tujuan_nilai.api');
            Route::resource('tujuan_nilai', TujuanNilaiController::class);

            Route::post('sasaran/api', [SasaranController::class, 'api'])->name('sasaran.api');
            Route::resource('sasaran', SasaranController::class);
            Route::post('sasaran_indikator/api', [SasaranIndikatorController::class, 'api'])->name('sasaran_indikator.api');
            Route::resource('sasaran_indikator', SasaranIndikatorController::class);
            Route::post('sasaran_nilai/api', [SasaranNilaiController::class, 'api'])->name('sasaran_nilai.api');
            Route::resource('sasaran_nilai', SasaranNilaiController::class);

            Route::post('perangkat_daerah/api', [PerangkatDaerahController::class, 'api'])->name('perangkat_daerah.api');
            Route::resource('perangkat_daerah', PerangkatDaerahController::class);

            Route::post('tujuan_renstra/api', [TujuanRenstraController::class, 'api'])->name('tujuan_renstra.api');
            Route::resource('tujuan_renstra', TujuanRenstraController::class);
            Route::post('tujuan_renstra_indikator/api', [TujuanRenstraIndikatorController::class, 'api'])->name('tujuan_renstra_indikator.api');
            Route::resource('tujuan_renstra_indikator', TujuanRenstraIndikatorController::class);
            Route::post('tujuan_renstra_nilai/api', [TujuanRenstraNilaiController::class, 'api'])->name('tujuan_renstra_nilai.api');
            Route::resource('tujuan_renstra_nilai', TujuanRenstraNilaiController::class);

            Route::post('sasaran_renstra/api', [SasaranRenstraController::class, 'api'])->name('sasaran_renstra.api');
            Route::resource('sasaran_renstra', SasaranRenstraController::class);
            Route::post('sasaran_renstra_indikator/api', [SasaranRenstraIndikatorController::class, 'api'])->name('sasaran_renstra_indikator.api');
            Route::resource('sasaran_renstra_indikator', SasaranRenstraIndikatorController::class);
            Route::post('sasaran_renstra_nilai/api', [SasaranRenstraNilaiController::class, 'api'])->name('sasaran_renstra_nilai.api');
            Route::resource('sasaran_renstra_nilai', SasaranRenstraNilaiController::class);

            Route::post('program/api', [ProgramController::class, 'api'])->name('program.api');
            Route::resource('program', ProgramController::class);
            Route::post('program_indikator/api', [ProgramIndikatorController::class, 'api'])->name('program_indikator.api');
            Route::resource('program_indikator', ProgramIndikatorController::class);
            Route::post('program_nilai/api', [ProgramNilaiController::class, 'api'])->name('program_nilai.api');
            Route::resource('program_nilai', ProgramNilaiController::class);

            Route::post('kegiatan/api', [KegiatanController::class, 'api'])->name('kegiatan.api');
            Route::resource('kegiatan', KegiatanController::class);
            Route::post('kegiatan_indikator/api', [KegiatanIndikatorController::class, 'api'])->name('kegiatan_indikator.api');
            Route::resource('kegiatan_indikator', KegiatanIndikatorController::class);
            Route::post('kegiatan_nilai/api', [KegiatanNilaiController::class, 'api'])->name('kegiatan_nilai.api');
            Route::resource('kegiatan_nilai', KegiatanNilaiController::class);

            Route::post('sub_kegiatan/api', [SubKegiatanController::class, 'api'])->name('sub_kegiatan.api');
            Route::resource('sub_kegiatan', SubKegiatanController::class);
            Route::post('sub_kegiatan_indikator/api', [SubKegiatanIndikatorController::class, 'api'])->name('sub_kegiatan_indikator.api');
            Route::resource('sub_kegiatan_indikator', SubKegiatanIndikatorController::class);
            Route::post('sub_kegiatan_nilai/api', [SubKegiatanNilaiController::class, 'api'])->name('sub_kegiatan_nilai.api');
            Route::resource('sub_kegiatan_nilai', SubKegiatanNilaiController::class);
        // });

        Route::post('menu/api', [MenuController::class, 'api'])->name('menu.api');
        Route::resource('menu', MenuController::class);

        Route::post('submenu/api', [SubMenuController::class, 'api'])->name('submenu.api');
        Route::resource('submenu', SubMenuController::class);
        Route::post('submenu2/api', [SubMenu2Controller::class, 'api'])->name('submenu2.api');
        Route::resource('submenu2', SubMenu2Controller::class);

        Route::prefix('section')->name('section.')->group(function () {
            Route::get('intro', [IntroController::class, 'index'])->name('intro.index');
            Route::patch('intro/{intro}', [IntroController::class, 'update'])->name('intro.update');

            Route::post('client/api', [ClientController::class, 'api'])->name('client.api');
            Route::resource('client', ClientController::class);

            Route::post('service/api', [ServiceController::class, 'api'])->name('service.api');
            Route::resource('service', ServiceController::class)->parameters([
                'service' => 'service'
            ]);
            Route::post('video/api', [VideoController::class, 'api'])->name('video.api');
            Route::resource('video', VideoController::class)->parameters([
                'video' => 'video'
            ]);
            Route::post('pricing/api', [PricingController::class, 'api'])->name('pricing.api');
            Route::resource('pricing', PricingController::class);

            Route::post('testimoni/api', [TestimoniController::class, 'api'])->name('testimoni.api');
            Route::resource('testimoni', TestimoniController::class);

            Route::post('team/api', [TeamController::class, 'api'])->name('team.api');
            Route::resource('team', TeamController::class);

            Route::resource('contact', ContactController::class);

            Route::resource('textcontent', TextContentController::class)->parameters([
                'textcontent' => 'textcontent'
            ]);
            Route::post('slider/api', [SliderController::class, 'api'])->name('slider.api');
            Route::resource('slider', SliderController::class);

            Route::post('download/api', [DownloadController::class, 'api'])->name('download.api');
            Route::resource('download', DownloadController::class);
            
            Route::get('/treeview', [TreeviewController::class, 'index'])->name('treeview.index');
            Route::get('/treeview', [TreeviewController::class, 'index'])->name('treeview');
            Route::resource('tree', TreeviewController::class);
            // Place this in routes/web.php or routes/api.php
            Route::get('/section/tree/api', [App\Http\Controllers\Section\TreeviewController::class, 'api'])->name('setup.section.tree.api');

        });


        Route::post('footer/api_link', [FooterController::class, 'api_link'])->name('footer.api_link');
        Route::post('footer/link', [FooterController::class, 'link_store'])->name('footer.link_store');
        Route::get('footer/{id}/link', [FooterController::class, 'link_edit'])->name('footer.link_edit');
        Route::patch('footer/link/{id}', [FooterController::class, 'link_patch'])->name('footer.link_patch');
        Route::delete('footer/link/{id}', [FooterController::class, 'link_destroy'])->name('footer.link_destroy');

        Route::post('footer/api_social', [FooterController::class, 'api_social'])->name('footer.api_social');
        Route::post('footer/social', [FooterController::class, 'social_store'])->name('footer.social_store');
        Route::get('footer/{id}/social', [FooterController::class, 'social_edit'])->name('footer.social_edit');
        Route::patch('footer/social/{id}', [FooterController::class, 'social_patch'])->name('footer.social_patch');
        Route::delete('footer/social/{id}', [FooterController::class, 'social_destroy'])->name('footer.social_destroy');


        Route::resource('footer', FooterController::class);


        Route::post('front/api', [FrontController::class, 'api'])->name('front.api');
        Route::resource('front', FrontController::class);

        Route::resource('logo', LogoController::class);

        Route::post('user/api', [UserController::class, 'api'])->name('user.api');
        Route::resource('user', UserController::class);
    });
});

//  Route::middleware('auth')->prefix('setup')->name('setup.')->group(function () {
// });
