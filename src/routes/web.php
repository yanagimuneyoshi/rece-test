<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AllController;
use App\Http\Controllers\FavoriteController;

// 登録ページとログインページ
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [AllController::class, 'login'])->name('login');
Route::post('/login', [AllController::class, 'processLogin']);

// 全ユーザーに公開するルート
Route::get('/', [AllController::class, 'shop_all']);
Route::post('/search', [AllController::class, 'shop_all']);
Route::get('/shops', [AllController::class, 'shop_all'])->name('shops.index');
Route::get('/detail/{shop_id}', [AllController::class, 'shop_detail'])->name('shop.detail');

// メール認証が必要なルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my_page', [AllController::class, 'my_page'])->name('my_page');
    Route::get('/thanks', [AllController::class, 'thanks'])->name('thanks');
    Route::get('/menu1', [AllController::class, 'menu1']);
    Route::get('/menu2', [AllController::class, 'menu2']);
    Route::post('/favorite/toggle/{shopId}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
    Route::get('/done', [AllController::class, 'done'])->name('done');
    Route::post('/reserve', [AllController::class, 'storeReserve'])->name('reserve.store');
    Route::post('/logout', [AllController::class, 'logout'])->name('logout');
    Route::delete('/delete-reservation/{id}', [AllController::class, 'deleteReservation'])->name('reservation.delete');
});

// メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('thanks'); // 認証後にdone画面にリダイレクト
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('resent', true);
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
