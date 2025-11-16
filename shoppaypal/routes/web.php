<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\PayPalController;
use App\Http\Controllers\momoController;

// Route::get('paypal', [PayPalController::class, 'index'])->name('paypal');
// Route::get('paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
// Route::get('paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
// Route::get('paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment/cancel');

Route::get('/', [PayPalController::class, 'index'])->name('paypal');
Route::get('/payment/{id}', [PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('/paypal-success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
Route::get('/paypal-cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment.cancel');

Route::post('/momo_payment/{id}', [momoController::class, 'momo_payment'])->name('momo.payment');


