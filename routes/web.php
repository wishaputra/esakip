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
use App\Http\Controllers\FooterController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InboxController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\VisiController;
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
use App\Models\CategoryBusiness;
use App\Models\Frontend;
use App\Models\Section\Pricing;
use App\Models\TextContent;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;


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

Route::get('/visi', function () {
    return view('visi.index');
})->name('visi');

Route::get('/misi', function () {
    return view('misi.index');
})->name('misi');

Route::get('/tujuan', function () {
    return view('tujuan.index');
})->name('tujuan');

Route::get('/sasaran', function () {
    return view('sasaran.index');
})->name('sasaran');




Route::get('tree-view', function () {
    return view('tree-view');
})->name('tree-view');

Route::get('/org-chart', function () {
    return view('org-chart');
});


// Route to render the organization chart view
Route::get('/organization-chart', [OrganizationChartController::class, 'index'])->name('organization-chart.index');

// Route to save chart data

Route::any('/save-chart', [ChartController::class, 'saveChart']);
Route::get('/load-chart', [ChartController::class, 'loadChart']);

//treview
Route::post('/tree', [TreeController::class, 'store'])->name('tree.store'); 
Route::put('/tree/{id}', [TreeController::class, 'update'])->name('tree.update');
Route::delete('/tree/{id}', [TreeController::class, 'delete'])->name('tree.delete');



Route::get('download2', [HomeController::class, 'download2'])->name('main.download');
Route::get('displaypdf3', [HomeController::class, 'displaypdf3'])->name('main.displaypdf');
Route::get('/', [App\Http\Controllers\HomeController::class, 'front'])->name('front');
Route::post('/contact', [App\Http\Controllers\HomeController::class, 'contact_store'])->name('front.contact_store');
Route::get('/page/s/{slug}', [HomeController::class, 'page'])->name('main.page');
Route::get('/page/team', [HomeController::class, 'team'])->name('main.team');

Route::get('/download', [HomeController::class, 'download'])->name('main.download');
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
        Route::post('menu/api', [MenuController::class, 'api'])->name('menu.api');
        Route::resource('menu', MenuController::class);

        Route::post('visi/api', [VisiController::class, 'api'])->name('visi.api');
        Route::resource('visi', visiController::class);

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
    });
});

//  Route::middleware('auth')->prefix('setup')->name('setup.')->group(function () {
// });
