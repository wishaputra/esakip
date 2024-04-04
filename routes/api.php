<?php



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route::middleware(['api'])->prefix('auth')->group(function () {
//     Route::post('login', [AuthController::class,'login']);
//     Route::post('logout', [AuthController::class,'logout']);
//     Route::post('refresh', [AuthController::class,'refresh']);
//     Route::post('me', [AuthController::class,'me']);
//     Route::post('register', [AuthController::class,'register'])->name('register');
// });

// Route::middleware(['jwt.verify'])->group(function () {
//     Route::prefix('setup')->group(function () {
//         Route::get('cakupan', [App\Http\Controllers\Api\CakupanController::class, 'index']);
//         Route::get('jenisfaskes', [App\Http\Controllers\Api\JenisFaskesController::class, 'index']);
//         Route::get('jeniskb', [App\Http\Controllers\Api\JenisKbController::class, 'index']);
//         Route::get('pekerjaan', [App\Http\Controllers\Api\PekerjaanController::class, 'index']);
//         Route::get('pendidikan', [App\Http\Controllers\Api\PendidikanController::class, 'index']);
//         Route::get('riwayathaid', [App\Http\Controllers\Api\RiwayatHaidController::class, 'index']);
//         Route::get('riwayatpenyakit', [App\Http\Controllers\Api\RiwayatPenyakitController::class, 'index']);
//     });
    
    
//     Route::resource('faskes', FaskesController::class)->except([
//         'create', 'edit'
//         ]);
        
        
//     Route::get('peserta/kesreproduksi', [PesertaController::class, 'kesReproduksi']);
//     Route::get('peserta/riwayatkb', [PesertaController::class, 'riwayatKb']);
//     Route::resource('peserta', PesertaController::class)->except([
//         'create', 'edit',
//     ]);
//     Route::resource('faq', FaqController::class)->except([
//         'create', 'edit',
//     ]);
// });
