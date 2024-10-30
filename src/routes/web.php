<?php

// routes/web.php

// routes/web.php

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
use App\Http\Controllers\Admin\StoreRepresentativeController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\StoreRepresentativeLoginController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\ReviewController;


// 登録ページとログインページ
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);

// 全ユーザーに公開するルート
Route::get('/', [ShopController::class, 'shop_all']);
// Route::post('/search', [ShopController::class, 'shop_all']);
Route::get('/shops', [ShopController::class, 'shop_all'])->name('shops.index');
Route::get('/detail/{shop_id}', [ShopController::class, 'shop_detail'])->name('shop.detail');

Route::get('/search', [ShopController::class, 'shop_all'])->name('search'); // GETメソッドを許可
Route::post('/search', [ShopController::class, 'shop_all']); // POSTメソッドも許可

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

    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');

    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    Route::get('/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
    Route::post('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::put('reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');

    
});





// 管理者専用のルート
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('store-representatives', [StoreRepresentativeController::class, 'index'])->name('store-representatives.index');
    Route::get('store-representatives/create', [StoreRepresentativeController::class, 'create'])->name('store-representatives.create');
    Route::post('store-representatives', [StoreRepresentativeController::class, 'store'])->name('store-representatives.store');
    Route::get('store-representatives/success', [StoreRepresentativeController::class, 'success'])->name('store-representatives.success');
    Route::get('notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
});


// 店舗代表者専用のルート
Route::middleware(['auth', 'isStoreRepresentative'])->prefix('store')->name('stores.')->group(function () {
    Route::get('/dashboard', [StoreController::class, 'index'])->name('dashboard');
    Route::post('/update', [StoreController::class, 'update'])->name('update');
    Route::get('/reservations', [StoreController::class, 'reservations'])->name('reservations');
});


// 店舗代表者ログイン
Route::get('store-representative/login', [StoreRepresentativeLoginController::class, 'showLoginForm'])->name('store_representative.login');
Route::post('store-representative/login', [StoreRepresentativeLoginController::class, 'login'])->name('store_representative.login.submit');
Route::post('store-representative/logout', [StoreRepresentativeLoginController::class, 'logout'])->name('store_representative.logout');

// メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('thanks');
})->middleware(['auth', 'signed'])->name('verification.verify');


Route::post('/update-reservation/{id}', [ReserveController::class, 'updateReservation'])->name('reservation.update');
Route::post('/rate-reservation/{id}', [ReserveController::class, 'rateReservation']);

Route::get('upload', [ImageUploadController::class, 'showUploadForm'])->name('upload.form');
Route::post('upload', [ImageUploadController::class, 'uploadImage'])->name('upload.image');

Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);

Route::get('/generate-qr-code/{reservationId}', [QRCodeController::class, 'generate']);
Route::post('/verify-qr-code', [QRCodeController::class, 'verifyQRCode']);

Route::get('upload', function () {
    return view('upload');
});
Route::post('upload', function (Request $request) {
    $path = $request->file('file')->store('uploads', 's3');
    return 'File uploaded to S3: ' . $path;
});

// 現在のユーザーを取得するルート（デバッグ用）
Route::middleware(['auth'])->get('/current-user', function () {
    return Auth::user();
});
