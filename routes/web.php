<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PagaleveController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect('checkout');
});

/**
 * Checkout
 */
Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder']);

Route::get('/checkout/checkout-complete', [CheckoutController::class, 'CheckoutComplete']);
Route::post('/checkout/checkout-complete', [CheckoutController::class, 'CheckoutComplete']);

Route::get('/checkout/checkout-cancel', [CheckoutController::class, 'CheckoutCancel']);
Route::post('/checkout/checkout-cancel', [CheckoutController::class, 'CheckoutCancel']);

Route::get('/checkout/checkout-approve', [CheckoutController::class, 'CheckoutApprove']);
Route::post('/checkout/checkout-approve', [CheckoutController::class, 'CheckoutApprove']);

Route::get('/checkout/success', [CheckoutController::class, 'success']);

/**
 * Pagaleve
 */
Route::get('/pagaleve/pay-with-pagaleve', [PagaleveController::class, 'payWithPagaleve']);
Route::post('/pagaleve/pay-with-pagaleve', [PagaleveController::class, 'payWithPagaleve']);

Route::get('/pagaleve/process-payment', [PagaleveController::class, 'processPayment']);
Route::post('/pagaleve/process-payment', [PagaleveController::class, 'processPayment']);