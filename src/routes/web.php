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
use App\Http\Controllers\StoreController;
use App\Http\Controllers\Auth\StoreRepresentativeLoginController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminRegisterController;


Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin']);


Route::get('/', [ShopController::class, 'shop_all']);
Route::get('/shops', [ShopController::class, 'shop_all'])->name('shops.index');
Route::get('/detail/{shop_id}', [ShopController::class, 'shop_detail'])->name('shop.detail');

Route::get('/search', [ShopController::class, 'shop_all'])->name('search');
Route::post('/search', [ShopController::class, 'shop_all']);

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


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::delete('/admin/reviews/delete-all', [AdminController::class, 'deleteAllReviews'])->name('admin.reviews.deleteAll');
    Route::delete('/admin/reviews/{id}', [AdminController::class, 'deleteReview'])->name('admin.reviews.delete');
    Route::post('/admin/shops/import', [AdminController::class, 'importShops'])->name('admin.shops.import');
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

});

Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register']);

Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login']);



Route::middleware(['auth', 'isStoreRepresentative'])->prefix('store')->name('stores.')->group(function () {
    Route::get('/dashboard', [StoreController::class, 'index'])->name('dashboard');
    Route::post('/update', [StoreController::class, 'update'])->name('update');
    Route::get('/reservations', [StoreController::class, 'reservations'])->name('reservations');
});


Route::get('store-representative/login', [StoreRepresentativeLoginController::class, 'showLoginForm'])->name('store_representative.login');
Route::post('store-representative/login', [StoreRepresentativeLoginController::class, 'login'])->name('store_representative.login.submit');
Route::post('store-representative/logout', [StoreRepresentativeLoginController::class, 'logout'])->name('store_representative.logout');


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

Route::middleware(['auth'])->get('/current-user', function () {
    return Auth::user();
});
