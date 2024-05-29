<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllController;
use App\Http\Controllers\FavoriteController;

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

// 認証が不要なルート
Route::get('/register', [AllController::class, 'register'])->name('register');
Route::post('/register', [AllController::class, 'processRegister']);
Route::get('/login', [AllController::class, 'login'])->name('login');
Route::post('/login', [AllController::class, 'processLogin']);

// 認証が必要なルート
Route::middleware(['auth'])->group(function () {
    Route::get('/', [AllController::class, 'shop_all']);
    Route::post('/search', [AllController::class, 'shop_all']);
    Route::get('/shops', [AllController::class, 'shop_all'])->name('shops.index');
    // Route::get('/my_page', [AllController::class, 'my_page']);
    Route::get('/my_page', [AllController::class, 'my_page'])->name('my_page');
    Route::get('/thanks', [AllController::class, 'thanks'])->name('thanks');
    Route::get('/menu1', [AllController::class, 'menu1']);
    Route::get('/menu2', [AllController::class, 'menu2']);
    Route::post('/favorite/toggle/{shopId}', [FavoriteController::class, 'toggleFavorite']);
    Route::get('/done', [AllController::class, 'done']);
    Route::get('/detail/{shop_id}', [AllController::class, 'shop_detail'])->name('shop.detail');
    Route::get('/shop_detail', [AllController::class, 'shop_detail']);
    // 予約保存のルート
    Route::post('/reserve', [AllController::class, 'storeReserve'])->name('reserve.store');

    // 予約完了ページのルート
    Route::get('/done', [AllController::class, 'done'])->name('done');
});
