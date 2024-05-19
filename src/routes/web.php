<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AllController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AllController::class, 'shop_all']);
Route::post('/search', [AllController::class, 'shop_all']);

Route::get('/menu1', [AllController::class, 'menu1']);

Route::get('/menu2', [AllController::class, 'menu2']);

Route::get('/register', [AllController::class, 'register'])->name('register');
Route::post('/register', [AllController::class, 'processRegister']);

Route::get('/thanks', [AllController::class, 'thanks'])->name('thanks');

Route::get('/login', [AllController::class, 'login'])->name('login');
Route::post('/login', [AllController::class, 'processLogin']);

Route::get('/my_page', [AllController::class, 'my_page']);

Route::get('/detail/{shop_id}', [AllController::class, 'shop_detail']);

Route::get('/done', [AllController::class, 'done']);

Route::get('/shop_detail', [AllController::class, 'shop_detail']);

Route::middleware(['auth'])->group(function () {
    Route::get('/shops', [AllController::class, 'shop_all'])->name('shops.index');
    Route::get('/my_page', [AllController::class, 'my_page']);
});