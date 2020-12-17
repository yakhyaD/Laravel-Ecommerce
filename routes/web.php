<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\CouponController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SaveForLater;
use App\Http\Controllers\ShopController;

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

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');

// Route::view('/products', 'products');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');

// Route::view('/product', 'product');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

// Route::view('/cart', 'cart');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');

Route::post('/cart/switchToSaveForLater/{product}', [CartController::class, 'SwitchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}', [SaveForLater::class, 'destroy'])->name('saveForLater.destroy');
Route::post('/saveForLater/{product}', [SaveForLater::class, 'SwitchToCart'])->name('saveForLater.switchToCart');

// Route::view('/checkout', 'checkout');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Route::view('/thankyou', 'thankyou');
Route::get('/thankyou', [ConfirmationController::class, 'index'])->name('confirmation.index');

//coupon routes
Route::post('/coupon', [CouponController::class, 'store'])->name('coupon.store');
Route::delete('/coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');

Route::get('/seesion', function () {
    session()->destroy();
    return 'done';
});
