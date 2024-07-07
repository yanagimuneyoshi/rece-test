<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\QRCodeController;


// 登録ページとログインページ
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);

// 全ユーザーに公開するルート
Route::get('/', [ShopController::class, 'shop_all']);
Route::post('/search', [ShopController::class, 'shop_all']);
Route::get('/shops', [ShopController::class, 'shop_all'])->name('shops.index');
Route::get('/detail/{shop_id}', [ShopController::class, 'shop_detail'])->name('shop.detail');

// メール認証が必要なルート
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/my_page', [PageController::class, 'my_page'])->name('my_page');
    Route::get('/thanks', [PageController::class, 'thanks'])->name('thanks');
    Route::get('/menu1', [PageController::class, 'menu1']);
    Route::get('/menu2', [PageController::class, 'menu2']);
    Route::post('/favorite/toggle/{shopId}', [FavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
    Route::get('/done', [PageController::class, 'done'])->name('done');
    Route::post('/reserve', [ReserveController::class, 'storeReserve'])->name('reserve.store');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::delete('/delete-reservation/{id}', [ReserveController::class, 'deleteReservation'])->name('reservation.delete');
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

Route::post('/update-reservation/{id}', [ReserveController::class, 'updateReservation'])->name('reservation.update');
Route::post('/rate-reservation/{id}', [ReserveController::class, 'rateReservation']);


Route::get('upload', [ImageUploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('upload', [ImageUploadController::class, 'uploadImage'])->name('upload.image');

Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);


Route::get('/generate-qr-code/{reservationId}', [QRCodeController::class, 'generate']);
Route::post('/verify-qr-code', [QRCodeController::class, 'verifyQRCode']);