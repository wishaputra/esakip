<?php

use App\Http\Controllers\TreeController;
use App\Models\OrganizationChartModel;
use App\Http\Controllers\OrganizationChartController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\NodeController;
use App\Http\Controllers\DiagramController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Blog2Controller;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\BusinessMenpanController;
use App\Http\Controllers\CategoryBusinessController;
use App\Http\Controllers\CategoryBusinessMenpanController;
use App\Http\Controllers\Section\DownloadController;
use App\Http\Controllers\Section\DownloadMenpanController;
use App\Http\Controllers\TreeviewController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FooterMenpanController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\FrontMenpanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\LogoMenpanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserMenpanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MenuMenpanController;
use App\Http\Controllers\Cascading\VisiController;
use App\Http\Controllers\Cascading\VisiMenpanController;
use App\Http\Controllers\Cascading\MisiController;
use App\Http\Controllers\Cascading\MisiMenpanController;
use App\Http\Controllers\Cascading\TujuanController;
use App\Http\Controllers\Cascading\TujuanMenpanController;
use App\Http\Controllers\Cascading\TujuanIndikatorController;
use App\Http\Controllers\Cascading\TujuanMenpanIndikatorController;
use App\Http\Controllers\Cascading\TujuanNilaiController;
use App\Http\Controllers\Cascading\TujuanMenpanNilaiController;
use App\Http\Controllers\Cascading\SasaranController;
use App\Http\Controllers\Cascading\SasaranMenpanController;
use App\Http\Controllers\Cascading\SasaranIndikatorController;
use App\Http\Controllers\Cascading\SasaranMenpanIndikatorController;
use App\Http\Controllers\Cascading\SasaranNilaiController;
use App\Http\Controllers\Cascading\SasaranMenpanNilaiController;
use App\Http\Controllers\Cascading\UrusanController;
use App\Http\Controllers\Cascading\UrusanOpdController;
use App\Http\Controllers\Cascading\UrusanMenpanController;
use App\Http\Controllers\Cascading\UrusanOpdIndikatorController;
use App\Http\Controllers\Cascading\UrusanMenpanIndikatorController;
use App\Http\Controllers\Cascading\UrusanOpdNilaiController;
use App\Http\Controllers\Cascading\UrusanMenpanNilaiController;
use App\Http\Controllers\Cascading\UrusanIndikatorController;
use App\Http\Controllers\Cascading\UrusanNilaiController;
use App\Http\Controllers\Cascading\PerangkatDaerahController;
use App\Http\Controllers\Cascading\PerangkatDaerahMenpanController;
use App\Http\Controllers\Cascading\TujuanRenstraController;
use App\Http\Controllers\Cascading\TujuanRenstraMenpanController;
use App\Http\Controllers\Cascading\TujuanRenstraIndikatorController;
use App\Http\Controllers\Cascading\TujuanRenstraMenpanIndikatorController;
use App\Http\Controllers\Cascading\TujuanRenstraNilaiController;
use App\Http\Controllers\Cascading\TujuanRenstraMenpanNilaiController;
use App\Http\Controllers\Cascading\SasaranRenstraController;
use App\Http\Controllers\Cascading\SasaranRenstraMenpanController;
use App\Http\Controllers\Cascading\SasaranRenstraIndikatorController;
use App\Http\Controllers\Cascading\SasaranRenstraMenpanIndikatorController;
use App\Http\Controllers\Cascading\SasaranRenstraNilaiController;
use App\Http\Controllers\Cascading\SasaranRenstraMenpanNilaiController;
use App\Http\Controllers\Cascading\ProgramController;
use App\Http\Controllers\Cascading\ProgramMenpanController;
use App\Http\Controllers\Cascading\ProgramIndikatorController;
use App\Http\Controllers\Cascading\ProgramMenpanIndikatorController;
use App\Http\Controllers\Cascading\ProgramNilaiController;
use App\Http\Controllers\Cascading\ProgramMenpanNilaiController;
use App\Http\Controllers\Cascading\KegiatanController;
use App\Http\Controllers\Cascading\KegiatanMenpanController;
use App\Http\Controllers\Cascading\KegiatanIndikatorController;
use App\Http\Controllers\Cascading\KegiatanMenpanIndikatorController;
use App\Http\Controllers\Cascading\KegiatanNilaiController;
use App\Http\Controllers\Cascading\KegiatanMenpanNilaiController;
use App\Http\Controllers\Cascading\SubKegiatanController;
use App\Http\Controllers\Cascading\SubKegiatanMenpanController;
use App\Http\Controllers\Cascading\SubKegiatanIndikatorController;
use App\Http\Controllers\Cascading\SubKegiatanMenpanIndikatorController;
use App\Http\Controllers\Cascading\SubKegiatanNilaiController;
use App\Http\Controllers\Cascading\SubKegiatanMenpanNilaiController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostMenpanController;
use App\Http\Controllers\Section\ClientController;
use App\Http\Controllers\Section\ClientMenpanController;
use App\Http\Controllers\Section\ContactController;
use App\Http\Controllers\Section\ContactMenpanController;
use App\Http\Controllers\Section\IntroController;
use App\Http\Controllers\Section\IntroMenpanController;
use App\Http\Controllers\Section\PricingController;
use App\Http\Controllers\Section\PricingMenpanController;
use App\Http\Controllers\Section\ServiceController;
use App\Http\Controllers\Section\ServiceMenpanController;
use App\Http\Controllers\Section\VideoController;
use App\Http\Controllers\Section\VideoMenpanController;
use App\Http\Controllers\Section\SliderController;
use App\Http\Controllers\Section\SliderMenpanController;
use App\Http\Controllers\SubMenuController;
use App\Http\Controllers\SubMenuMenpanController;
use App\Http\Controllers\Section\TestimoniController;
use App\Http\Controllers\Section\TestimoniMenpanController;
use App\Http\Controllers\Section\TeamController;
use App\Http\Controllers\Section\TeamMenpanController;
use App\Http\Controllers\SubMenu2Controller;
use App\Http\Controllers\SubMenu2MenpanController;
use App\Http\Controllers\TextContentController;
use App\Models\Cascading\Model_Tujuan;
use App\Models\Cascading\Model_Sasaran;
use App\Models\Cascading\Model_Urusan;
use App\Models\TreeNode;
use App\Models\ChildNode;
use App\Models\Frontend;
use App\Models\Section\Pricing;
use App\Models\TextContent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\structurecontroller;
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
Route::get('/get-sasaran-by-tahun/{id}', [UrusanController::class,'getSasaranByTahun'])->name('getSasaranByTahun');
Route::get('/get-urusan-by-tahun/{id}', [TujuanRenstraController::class,'getUrusanByTahun'])->name('getUrusanByTahun');
Route::get('/getTujuanRenstraByTahun/{id}', [SasaranRenstraController::class,'getTujuanRenstraByTahun'])->name('getTujuanRenstraByTahun');
Route::get('/get-sasaran-renstra-by-tahun/{id}', [ProgramController::class,'getSasaranRenstraByTahun'])->name('getSasaranRenstraByTahun');
Route::get('/get-program-by-tahun/{id}', [KegiatanController::class,'getProgramByTahun'])->name('getProgramByTahun');
Route::get('/get-kegiatan-by-tahun/{id}', [SubKegiatanController::class,'getKegiatanByTahun'])->name('getKegiatanByTahun');
Route::get('tujuan-nilai/{id}/edit', [TujuanNilaiController::class, 'edit'])->name('tujuan-nilai.edit');



Route::get('/visi', function () {
    return view('cascading.visi.index');
})->name('visi');

Route::get('/visi_menpan', function () {
    return view('cascading.visi_menpan.index');
})->name('visi_menpan');

Route::get('/misi', function () {
    return view('cascading.misi.index');
})->name('misi');

Route::get('/misi_menpan', function () {
    return view('cascading.misi_menpan.index');
})->name('misi_menpan');


Route::get('/tujuan', function () {
    return view('cascading.tujuan.index');
})->name('tujuan');

Route::get('/tujuan_menpan', function () {
    return view('cascading.tujuan_menpan.index');
})->name('tujuan_menpan');

Route::get('/tujuan_indikator', function () {
    return view('cascading.tujuan_indikator.index');
})->name('tujuan_indikator');

Route::get('/tujuan_menpan_indikator', function () {
    return view('cascading.tujuan_menpan_indikator.index');
})->name('tujuan_menpan_indikator');

Route::get('/tujuan_nilai', function () {
    return view('cascading.tujuan_nilai.index');
})->name('tujuan_menpan_nilai');

Route::get('/tujuan_menpan_nilai', function () {
    return view('cascading.tujuan_menpan_nilai.index');
})->name('tujuan_menpan_nilai');

Route::get('/sasaran', function () {
    return view('cascading.sasaran.index');
})->name('sasaran');

Route::get('/sasaran_menpan', function () {
    return view('cascading.sasaran_menpan.index');
})->name('sasaran_menpan');

Route::get('/sasaran_indikator', function () {
    return view('cascading.sasaran_indikator.index');
})->name('sasaran_indikator');

Route::get('/sasaran_menpan_indikator', function () {
    return view('cascading.sasaran_menpan_indikator.index');
})->name('sasaran_menpan_indikator');

Route::get('/sasaran_nilai', function () {
    return view('cascading.sasaran_nilai.index');
})->name('sasaran_nilai');

Route::get('/sasaran_menpan_nilai', function () {
    return view('cascading.sasaran_menpan_nilai.index');
})->name('sasaran_menpan_nilai');

Route::get('/urusan', function () {
    return view('cascading.urusan.index');
})->name('urusan');

Route::get('/urusan_opd', function () {
    return view('cascading.urusan_opd.index');
})->name('urusan_opd');

Route::get('/urusan_menpan', function () {
    return view('cascading.urusan_menpan.index');
})->name('urusan_menpan');


Route::get('/urusan_opd_indikator', function () {
    return view('cascading.urusan_opd_indikator.index');
})->name('urusan_opd_indikator');

Route::get('/urusan_menpan_indikator', function () {
    return view('cascading.urusan_menpan_indikator.index');
})->name('urusan_menpan_indikator');

Route::get('/urusan_opd_nilai', function () {
    return view('cascading.urusan_opd_nilai.index');
})->name('urusan_opd_nilai');

Route::get('/urusan_menpan_nilai', function () {
    return view('cascading.urusan_menpan_nilai.index');
})->name('urusan_menpan_nilai');

Route::get('/urusan_indikator', function () {
    return view('cascading.urusan_indikator.index');
})->name('urusan_indikator');

Route::get('/urusan_nilai', function () {
    return view('cascading.urusan_nilai.index');
})->name('urusan_nilai');

Route::get('/perangkat_daerah', function () {
    return view('cascading.perangkat_daerah.index');
})->name('perangkat_daerah');

Route::get('/perangkat_daerah_menpan', function () {
    return view('cascading.perangkat_daerah_menpan.index');
})->name('perangkat_daerah_menpan');

Route::get('/tujuan_renstra', function () {
    return view('cascading.tujuan_renstra.index');
})->name('tujuan_renstra');

Route::get('/tujuan_renstra_menpan', function () {
    return view('cascading.tujuan_renstra_menpan.index');
})->name('tujuan_renstra_menpan');

Route::get('/tujuan_renstra_indikator', function () {
    return view('cascading.tujuan_renstra_indikator.index');
})->name('tujuan_renstra_indikator');

Route::get('/tujuan_renstra_menpan_indikator', function () {
    return view('cascading.tujuan_renstra_menpan_indikator.index');
})->name('tujuan_renstra_menpan_indikator');

Route::get('/tujuan_renstra_nilai', function () {
    return view('cascading.tujuan_renstra_nilai.index');
})->name('tujuan_renstra_nilai');

Route::get('/tujuan_renstra_menpan_nilai', function () {
    return view('cascading.tujuan_renstra_menpan_nilai.index');
})->name('tujuan_renstra_menpan_nilai');

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

Route::get('/load-chart/{tahun_awal}/{tahun_akhir}', [structurecontroller::class, 'loadChart'])->name('loadChart');

Route::get('/get-periods', function() {
    return App\Models\Cascading\Model_Visi::select('tahun_awal', 'tahun_akhir')->distinct()->get();
});
Route::get('/public/load-chart', [structurecontroller::class, 'loadChart']);
Route::get('/load-visi', [structurecontroller::class,'loadvisi']);
Route::get('/load-misi', [structurecontroller::class,'loadmisi']);
Route::get('/load-tujuan', [structurecontroller::class,'loadtujuan']);
Route::get('/struktur', [structurecontroller::class, 'getperiods']);
Route::post('/api/load-chart', [structurecontroller::class, 'loadChart']);




//treview
Route::get('/public/getTujuanIndikator/{id}', [TreeViewController::class, 'getTujuanIndikator']);
Route::get('/public/getTujuanNilai/{id}', [TreeViewController::class, 'getTujuanNilai']);

Route::get('/public/getSasaranIndikator/{id}', [TreeViewController::class, 'getSasaranIndikator']);
Route::get('/public/getSasaranNilai/{id}', [TreeViewController::class, 'getSasaranNilai']);

Route::get('/public/getUrusanIndikator/{id}', [TreeViewController::class, 'getUrusanIndikator']);
Route::get('/public/getUrusanNilai/{id}', [TreeViewController::class, 'getUrusanNilai']);

route::get('/public/getTujuanRenstraIndikator/{id}', [TreeViewController::class, 'getTujuanRenstraIndikator']);
route::get('/public/getTujuanRenstraNilai/{id}', [TreeViewController::class, 'getTujuanRenstraNilai']);

route::get('/public/getSasaranRenstraIndikator/{id}', [TreeViewController::class, 'getSasaranRenstraIndikator']);
route::get('/public/getSasaranRenstraNilai/{id}', [TreeViewController::class, 'getSasaranRenstraNilai']);

route::get('/public/getProgramIndikator/{id}', [TreeViewController::class, 'getProgramIndikator']);
route::get('/public/getProgramNilai/{id}', [TreeViewController::class, 'getProgramNilai']);

route::get('/public/getKegiatanIndikator/{id}', [TreeViewController::class, 'getKegiatanIndikator']);
route::get('/public/getKegiatanNilai/{id}', [TreeViewController::class, 'getKegiatanNilai']);

Route::get('/public/getSubKegiatanIndikator/{id}', [TreeViewController::class, 'getSubKegiatanIndikator']);
Route::get('/public/getSubKegiatanNilai/{id}', [TreeViewController::class, 'getSubKegiatanNilai']);






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

    Route::post('posts_menpan/api', [PostMenpanController::class, 'api_post_menpan'])->name('posts_menpan.api');
    Route::resource('posts_menpan', PostMenpanController::class);

    Route::post('inbox/api', [InboxController::class, 'api'])->name('inbox.api');
    Route::get('inbox/count', [InboxController::class, 'countI'])->name('inbox.count');
    Route::resource('inbox', InboxController::class);

    Route::post('blog/api', [BlogController::class, 'api'])->name('blog.api');
    Route::resource('blog', BlogController::class)->parameters([
        'blog' => 'post'
    ]);

    Route::post('blog2/api', [Blog2Controller::class, 'api2'])->name('blog2.api');
    Route::resource('blog2', Blog2Controller::class)->parameters([
        'blog2' => 'posts2'
    ]);

    Route::prefix('business')->name('business.')->group(function () {
        Route::post('category/api', [CategoryBusinessController::class, 'api'])->name('category.api');
        Route::resource('category', CategoryBusinessController::class);

        Route::post('list/api', [BusinessController::class, 'api'])->name('list.api');
        Route::resource('list', BusinessController::class);
    });

    Route::prefix('business_menpan')->name('business_menpan.')->group(function () {
        Route::post('category/api', [CategoryBusinessMenpanController::class, 'api_category_menpan'])->name('category_menpan.api');
        Route::resource('category', CategoryBusinessMenpanController::class);

        Route::post('list/api', [BusinessMenpanController::class, 'api_list_menpan'])->name('list_menpan.api');
        Route::resource('list', BusinessMenpanController::class);
    });

    Route::middleware('auth')->prefix('setup')->name('setup.')->group(function () {
         // Route::prefix('cascading')->name('cascading.')->group(function () {
            Route::post('visi/api', [VisiController::class, 'api'])->name('visi.api');
            Route::resource('visi', VisiController::class);

            Route::post('visi_menpan/api', [VisiMenpanController::class, 'api_visi_menpan'])->name('visi_menpan.api');
            Route::resource('visi_menpan', VisiMenpanController::class);

            Route::post('misi/api', [MisiController::class, 'api'])->name('misi.api');
            Route::resource('misi', MisiController::class);

            Route::post('misi_menpan/api', [MisiMenpanController::class, 'api_misi_menpan'])->name('misi_menpan.api');
            Route::resource('misi_menpan', MisiMenpanController::class);

            Route::post('tujuan/api', [TujuanController::class, 'api'])->name('tujuan.api');
            Route::resource('tujuan', TujuanController::class);

            Route::post('tujuan_menpan/api', [TujuanMenpanController::class, 'api_tujuan_menpan'])->name('tujuan_menpan.api');
            Route::resource('tujuan_menpan', TujuanMenpanController::class);

            Route::post('tujuan_indikator/api', [TujuanIndikatorController::class, 'api'])->name('tujuan_indikator.api');
            Route::resource('tujuan_indikator', TujuanIndikatorController::class);

            Route::post('tujuan_menpan_indikator/api', [TujuanMenpanIndikatorController::class, 'api_tujuan_menpan_indikator'])->name('tujuan_menpan_indikator.api');
            Route::resource('tujuan_menpan_indikator', TujuanMenpanIndikatorController::class);

            Route::post('tujuan_nilai/api', [TujuanNilaiController::class, 'api'])->name('tujuan_nilai.api');
            Route::resource('tujuan_nilai', TujuanNilaiController::class);


            Route::post('tujuan_menpan_nilai/api', [TujuanMenpanNilaiController::class, 'api_tujuan_menpan_nilai'])->name('tujuan_menpan_nilai.api');
            Route::resource('tujuan_menpan_nilai', TujuanMenpanNilaiController::class);

            Route::post('sasaran/api', [SasaranController::class, 'api'])->name('sasaran.api');
            Route::resource('sasaran', SasaranController::class);

            Route::post('sasaran_menpan/api', [SasaranMenpanController::class, 'api_sasaran_menpan'])->name('sasaran_menpan.api');
            Route::resource('sasaran_menpan', SasaranMenpanController::class);

            Route::post('sasaran_indikator/api', [SasaranIndikatorController::class, 'api'])->name('sasaran_indikator.api');
            Route::resource('sasaran_indikator', SasaranIndikatorController::class);

            Route::post('sasaran_menpan_indikator/api', [SasaranMenpanIndikatorController::class, 'api_sasaran_menpan_indikator'])->name('sasaran_menpan_indikator.api');
            Route::resource('sasaran_menpan_indikator', SasaranMenpanIndikatorController::class);

            Route::post('sasaran_nilai/api', [SasaranNilaiController::class, 'api'])->name('sasaran_nilai.api');
            Route::resource('sasaran_nilai', SasaranNilaiController::class);

            Route::post('sasaran_menpan_nilai/api', [SasaranMenpanNilaiController::class, 'api_sasaran_menpan_nilai'])->name('sasaran_menpan_nilai.api');
            Route::resource('sasaran_menpan_nilai', SasaranMenpanNilaiController::class);

            Route::post('urusan/api', [UrusanController::class, 'api'])->name('urusan.api');
            Route::resource('urusan', UrusanController::class);
            Route::post('urusan_opd/api', [UrusanOpdController::class, 'api_opd'])->name('urusan_opd.api');
            Route::resource('urusan_opd', UrusanOpdController::class);

            Route::post('urusan_menpan/api', [UrusanMenpanController::class, 'api_urusan_menpan'])->name('urusan_menpan.api');
            Route::resource('urusan_menpan', UrusanMenpanController::class);

            Route::post('urusan_opd_indikator/api', [UrusanOpdIndikatorController::class, 'api_opd_indikator'])->name('urusan_opd_indikator.api');
            Route::resource('urusan_opd_indikator', UrusanOpdIndikatorController::class);

            Route::post('urusan_menpan_indikator/api', [UrusanMenpanIndikatorController::class, 'api_urusan_menpan_indikator'])->name('urusan_menpan_indikator.api');
            Route::resource('urusan_menpan_indikator', UrusanMenpanIndikatorController::class);

            Route::post('urusan_opd_nilai/api', [UrusanOpdNilaiController::class, 'api_opd_nilai'])->name('urusan_opd_nilai.api');
            Route::resource('urusan_opd_nilai', UrusanOpdNilaiController::class);

            Route::post('urusan_menpan_nilai/api', [UrusanMenpanNilaiController::class, 'api_urusan_menpan_nilai'])->name('urusan_menpan_nilai.api');
            Route::resource('urusan_menpan_nilai', UrusanMenpanNilaiController::class);

            Route::post('urusan_indikator/api', [UrusanIndikatorController::class, 'api'])->name('urusan_indikator.api');
            Route::resource('urusan_indikator', UrusanIndikatorController::class);
            Route::post('urusan_nilai/api', [UrusanNilaiController::class, 'api'])->name('urusan_nilai.api');
            Route::resource('urusan_nilai', UrusanNilaiController::class);

            Route::post('perangkat_daerah/api', [PerangkatDaerahController::class, 'api'])->name('perangkat_daerah.api');
            Route::resource('perangkat_daerah', PerangkatDaerahController::class);

            Route::post('perangkat_daerah_menpan/api', [PerangkatDaerahMenpanController::class, 'api_perangkat_daerah_menpan'])->name('perangkat_daerah_menpan.api');
            Route::resource('perangkat_daerah_menpan', PerangkatDaerahMenpanController::class);

            Route::post('tujuan_renstra/api', [TujuanRenstraController::class, 'api'])->name('tujuan_renstra.api');
            Route::resource('tujuan_renstra', TujuanRenstraController::class);

            Route::post('tujuan_renstra_menpan/api', [TujuanRenstraMenpanController::class, 'api_tujuan_renstra_menpan'])->name('tujuan_renstra_menpan.api');
            Route::resource('tujuan_renstra_menpan', TujuanRenstraMenpanController::class);

            Route::post('tujuan_renstra_indikator/api', [TujuanRenstraIndikatorController::class, 'api'])->name('tujuan_renstra_indikator.api');
            Route::resource('tujuan_renstra_indikator', TujuanRenstraIndikatorController::class);

            Route::post('tujuan_renstra_menpan_indikator/api', [TujuanRenstraMenpanIndikatorController::class, 'api_tujuan_renstra_menpan_indikator'])->name('tujuan_renstra_menpan_indikator.api');
            Route::resource('tujuan_renstra_menpan_indikator', TujuanRenstraMenpanIndikatorController::class);
            
            Route::post('tujuan_renstra_nilai/api', [TujuanRenstraNilaiController::class, 'api'])->name('tujuan_renstra_nilai.api');
            Route::resource('tujuan_renstra_nilai', TujuanRenstraNilaiController::class);

            Route::post('tujuan_renstra_menpan_nilai/api', [TujuanRenstraMenpanNilaiController::class, 'api_tujuan_renstra_menpan_nilai'])->name('tujuan_renstra_menpan_nilai.api');
            Route::resource('tujuan_renstra_menpan_nilai', TujuanRenstraMenpanNilaiController::class);

            Route::post('sasaran_renstra/api', [SasaranRenstraController::class, 'api'])->name('sasaran_renstra.api');
            Route::resource('sasaran_renstra', SasaranRenstraController::class);

            Route::post('sasaran_renstra_menpan/api', [SasaranRenstraMenpanController::class, 'api_sasaran_renstra_menpan'])->name('sasaran_renstra_menpan.api');
            Route::resource('sasaran_renstra_menpan', SasaranRenstraMenpanController::class);

            Route::post('sasaran_renstra_indikator/api', [SasaranRenstraIndikatorController::class, 'api'])->name('sasaran_renstra_indikator.api');
            Route::resource('sasaran_renstra_indikator', SasaranRenstraIndikatorController::class);

            Route::post('sasaran_renstra_menpan_indikator/api', [SasaranRenstraMenpanIndikatorController::class, 'api_sasaran_renstra_menpan_indikator'])->name('sasaran_renstra_menpan_indikator.api');
            Route::resource('sasaran_renstra_menpan_indikator', SasaranRenstraMenpanIndikatorController::class);

            Route::post('sasaran_renstra_nilai/api', [SasaranRenstraNilaiController::class, 'api'])->name('sasaran_renstra_nilai.api');
            Route::resource('sasaran_renstra_nilai', SasaranRenstraNilaiController::class);

            Route::post('sasaran_renstra_menpan_nilai/api', [SasaranRenstraMenpanNilaiController::class, 'api_sasaran_renstra_menpan_nilai'])->name('sasaran_renstra_menpan_nilai.api');
            Route::resource('sasaran_renstra_menpan_nilai', SasaranRenstraMenpanNilaiController::class);

            Route::post('program/api', [ProgramController::class, 'api'])->name('program.api');
            Route::resource('program', ProgramController::class);

            Route::post('program_menpan/api', [ProgramMenpanController::class, 'api_program_menpan'])->name('program_menpan.api');
            Route::resource('program_menpan', ProgramMenpanController::class);

            Route::post('program_indikator/api', [ProgramIndikatorController::class, 'api'])->name('program_indikator.api');
            Route::resource('program_indikator', ProgramIndikatorController::class);

            Route::post('program_menpan_indikator/api', [ProgramMenpanIndikatorController::class, 'api_program_menpan_indikator'])->name('program_menpan_indikator.api');
            Route::resource('program_menpan_indikator', ProgramMenpanIndikatorController::class);
            
            Route::post('program_nilai/api', [ProgramNilaiController::class, 'api'])->name('program_nilai.api');
            Route::resource('program_nilai', ProgramNilaiController::class);

            Route::post('program_menpan_nilai/api', [ProgramMenpanNilaiController::class, 'api_program_menpan_nilai'])->name('program_menpan_nilai.api');
            Route::resource('program_menpan_nilai', ProgramMenpanNilaiController::class);

            Route::post('kegiatan/api', [KegiatanController::class, 'api'])->name('kegiatan.api');
            Route::resource('kegiatan', KegiatanController::class);

            Route::post('kegiatan_menpan/api', [KegiatanMenpanController::class, 'api_kegiatan_menpan'])->name('kegiatan_menpan.api');
            Route::resource('kegiatan_menpan', KegiatanMenpanController::class);

            Route::post('kegiatan_indikator/api', [KegiatanIndikatorController::class, 'api'])->name('kegiatan_indikator.api');
            Route::resource('kegiatan_indikator', KegiatanIndikatorController::class);

            Route::post('kegiatan_menpan_indikator/api', [KegiatanMenpanIndikatorController::class, 'api_kegiatan_menpan_indikator'])->name('kegiatan_menpan_indikator.api');
            Route::resource('kegiatan_menpan_indikator', KegiatanMenpanIndikatorController::class);

            Route::post('kegiatan_nilai/api', [KegiatanNilaiController::class, 'api'])->name('kegiatan_nilai.api');
            Route::resource('kegiatan_nilai', KegiatanNilaiController::class);
            Route::get('update-pagu', [KegiatanNilaiController::class, 'updatePagu']);


            Route::post('kegiatan_menpan_nilai/api', [KegiatanMenpanNilaiController::class, 'api_kegiatan_menpan_nilai'])->name('kegiatan_menpan_nilai.api');
            Route::resource('kegiatan_menpan_nilai', KegiatanMenpanNilaiController::class);

            Route::post('sub_kegiatan/api', [SubKegiatanController::class, 'api'])->name('sub_kegiatan.api');
            Route::resource('sub_kegiatan', SubKegiatanController::class);

            Route::post('sub_kegiatan_menpan/api', [SubKegiatanMenpanController::class, 'api_subkegiatan_menpan'])->name('sub_kegiatan_menpan.api');
            Route::resource('sub_kegiatan_menpan', SubKegiatanMenpanController::class);

            Route::post('sub_kegiatan_indikator/api', [SubKegiatanIndikatorController::class, 'api'])->name('sub_kegiatan_indikator.api');
            Route::resource('sub_kegiatan_indikator', SubKegiatanIndikatorController::class);

            Route::post('sub_kegiatan_menpan_indikator/api', [SubKegiatanMenpanIndikatorController::class, 'api_subkegiatan_menpan_indikator'])->name('sub_kegiatan_menpan_indikator.api');
            Route::resource('sub_kegiatan_menpan_indikator', SubKegiatanMenpanIndikatorController::class);

            Route::post('sub_kegiatan_nilai/api', [SubKegiatanNilaiController::class, 'api'])->name('sub_kegiatan_nilai.api');
            Route::resource('sub_kegiatan_nilai', SubKegiatanNilaiController::class);

            Route::post('sub_kegiatan_menpan_nilai/api', [SubKegiatanMenpanNilaiController::class, 'api_subkegiatan_menpan_nilai'])->name('sub_kegiatan_menpan_nilai.api');
            Route::resource('sub_kegiatan_menpan_nilai', SubKegiatanMenpanNilaiController::class);
        // });

        Route::post('menu/api', [MenuController::class, 'api'])->name('menu.api');
        Route::resource('menu', MenuController::class);

        Route::post('menu_menpan/api', [MenuMenpanController::class, 'api_menu_menpan'])->name('menu_menpan.api');
        Route::resource('menu_menpan', MenuMenpanController::class);
        
        Route::post('submenu/api', [SubMenuController::class, 'api'])->name('submenu.api');
        Route::resource('submenu', SubMenuController::class);

        Route::post('submenu_menpan/api', [SubMenuMenpanController::class, 'api_submenu_menpan'])->name('submenu_menpan.api');
        Route::resource('submenu_menpan', SubMenuMenpanController::class);

        Route::post('submenu2/api', [SubMenu2Controller::class, 'api'])->name('submenu2.api');
        Route::resource('submenu2', SubMenu2Controller::class);

        Route::post('submenu2_menpan/api', [SubMenu2MenpanController::class, 'api_submenu2_menpan'])->name('submenu2_menpan.api');
        Route::resource('submenu2_menpan', SubMenu2MenpanController::class);
        
        Route::prefix('section')->name('section.')->group(function () {
            Route::get('intro', [IntroController::class, 'index'])->name('intro.index');
            Route::patch('intro/{intro}', [IntroController::class, 'update'])->name('intro.update');
            
            Route::get('intro_menpan', [IntroMenpanController::class, 'index_menpan'])->name('intro_menpan.index');
            Route::patch('intro_menpan/{intro}', [IntroMenpanController::class, 'update'])->name('intro.update');

            Route::post('client/api', [ClientController::class, 'api'])->name('client.api');
            Route::resource('client', ClientController::class);

            Route::post('client_menpan/api', [ClientMenpanController::class, 'api_client_menpan'])->name('client_menpan.api');
            Route::resource('client_menpan', ClientMenpanController::class);

            Route::post('service/api', [ServiceController::class, 'api'])->name('service.api');
            Route::resource('service', ServiceController::class)->parameters([
                'service' => 'service'
            ]);
            Route::post('service_menpan/api', [ServiceMenpanController::class, 'api_service_menpan'])->name('service_menpan.api');
            Route::resource('service_menpan', ServiceMenpanController::class)->parameters([
                'service' => 'service'
            ]);
            Route::post('video/api', [VideoController::class, 'api'])->name('video.api');
            Route::resource('video', VideoController::class)->parameters([
                'video' => 'video'
            ]);
            Route::post('video_menpan/api', [VideoMenpanController::class, 'api_video_menpan'])->name('video_menpan.api');
            Route::resource('video_menpan', VideoMenpanController::class)->parameters([
                'video' => 'video'
            ]);
            Route::post('pricing/api', [PricingController::class, 'api'])->name('pricing.api');
            Route::resource('pricing', PricingController::class);

            Route::post('pricing_menpan/api', [PricingMenpanController::class, 'api_pricing_menpan'])->name('pricing_menpan.api');
            Route::resource('pricing_menpan', PricingMenpanController::class);

            Route::post('testimoni/api', [TestimoniController::class, 'api'])->name('testimoni.api');
            Route::resource('testimoni', TestimoniController::class);

            Route::post('testimoni_menpan/api', [TestimoniMenpanController::class, 'api_testimoni_menpan'])->name('testimoni_menpan.api');
            Route::resource('testimoni_menpan', TestimoniMenpanController::class);

            Route::post('team/api', [TeamController::class, 'api'])->name('team.api');
            Route::resource('team', TeamController::class);

            Route::post('team_menpan/api', [TeamMenpanController::class, 'api_team_menpan'])->name('team_menpan.api');
            Route::resource('team_menpan', TeamMenpanController::class);

            Route::resource('contact', ContactController::class);

            Route::resource('contact_menpan', ContactMenpanController::class);

            Route::resource('textcontent', TextContentController::class)->parameters([
                'textcontent' => 'textcontent'
            ]);
            Route::post('slider/api', [SliderController::class, 'api'])->name('slider.api');
            Route::resource('slider', SliderController::class);

            Route::post('slider_menpan/api', [SliderMenpanController::class, 'api_slider_menpan'])->name('slider_menpan.api');
            Route::resource('slider_menpan', SliderMenpanController::class);

            Route::post('download/api', [DownloadController::class, 'api'])->name('download.api');
            Route::resource('download', DownloadController::class);

            Route::post('download_menpan/api', [DownloadMenpanController::class, 'api_download_menpan'])->name('download_menpan.api');
            Route::resource('download_menpan', DownloadMenpanController::class);
            
            Route::get('/treeview', [TreeviewController::class, 'index'])->name('treeview.index');
            Route::get('/treeview', [TreeviewController::class, 'index'])->name('treeview');
            Route::resource('tree', TreeviewController::class);
            // Place this in routes/web.php or routes/api.php
            Route::get('/section/tree/api', [App\Http\Controllers\Section\TreeviewController::class, 'api'])->name('setup.section.tree.api');

        });


        Route::post('footer/api_link', [FooterController::class, 'api_link'])->name('footer.api_link');

        Route::post('footer_menpan/api_link_menpan', [FooterMenpanController::class, 'api_link_menpan'])->name('footer.api_link_menpan');

        Route::post('footer/link', [FooterController::class, 'link_store'])->name('footer.link_store');
        Route::get('footer/{id}/link', [FooterController::class, 'link_edit'])->name('footer.link_edit');
        Route::patch('footer/link/{id}', [FooterController::class, 'link_patch'])->name('footer.link_patch');
        Route::delete('footer/link/{id}', [FooterController::class, 'link_destroy'])->name('footer.link_destroy');

        Route::post('footer/api_social', [FooterController::class, 'api_social'])->name('footer.api_social');

        Route::post('footer_menpan/api_social_menpan', [FooterMenpanController::class, 'api_social_menpan'])->name('footer.api_social_menpan');

        Route::post('footer/social', [FooterController::class, 'social_store'])->name('footer.social_store');
        Route::get('footer/{id}/social', [FooterController::class, 'social_edit'])->name('footer.social_edit');
        Route::patch('footer/social/{id}', [FooterController::class, 'social_patch'])->name('footer.social_patch');
        Route::delete('footer/social/{id}', [FooterController::class, 'social_destroy'])->name('footer.social_destroy');


        Route::resource('footer', FooterController::class);

        Route::resource('footer_menpan', FooterMenpanController::class);


        Route::post('front/api', [FrontController::class, 'api'])->name('front.api');
        Route::resource('front', FrontController::class);

        Route::post('front_menpan/api', [FrontMenpanController::class, 'api_front_menpan'])->name('front_menpan.api');
        Route::resource('front_menpan', FrontMenpanController::class);

        Route::resource('logo', LogoController::class);

        Route::resource('logo_menpan', LogoMenpanController::class);

        Route::post('user/api', [UserController::class, 'api'])->name('user.api');
        Route::resource('user', UserController::class);

        Route::post('user_menpan/api', [UserMenpanController::class, 'api_user_menpan'])->name('user_menpan.api');
        Route::resource('user_menpan', UserMenpanController::class);
    });
});

//  Route::middleware('auth')->prefix('setup')->name('setup.')->group(function () {
// });
