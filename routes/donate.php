<?php

use App\Http\Controllers\Donate\DonationsCoinbaseController;
use App\Http\Controllers\Donate\DonationsController;
use App\Http\Controllers\Donate\DonationsMaxiCardController;
use App\Http\Controllers\Donate\DonationsPayOpController;
use App\Http\Controllers\Donate\DonationsPaypalController;
use App\Http\Controllers\Donate\DonationsStripeController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/profile/donate'], static function () {
    Route::get('/', [DonationsController::class, 'index'])->name('profile.donate');
    Route::get('/{method?}', [DonationsController::class, 'showMethod'])->name('donations-method-index');

    Route::group(['prefix' => 'paypal'], static function () {
        Route::get('/buy/{id}', [DonationsPaypalController::class, 'buy'])->where('id', '[0-9]+')->name('donate-paypal');
        Route::get('/complete', [DonationsPaypalController::class, 'complete'])->name('donate-paypal-complete');
        Route::get('/invoice-closed', [DonationsPaypalController::class, 'invoiceClosed'])->name('donate-paypal-invoice-closed');
        Route::get('/success', [DonationsPaypalController::class, 'success'])->name('donate-paypal-success');
        Route::get('/notify', [DonationsPaypalController::class, 'notify'])->name('donate-paypal-notify');
        Route::get('/error/{id}', [DonationsPaypalController::class, 'error'])->name('donate-paypal-error');
    });

    Route::group(['prefix' => 'coinbase'], static function () {
        Route::get('/buy/{id}', [DonationsCoinbaseController::class, 'buy'])->name('donate-coinbase-buy');
    });
    // Payop
    Route::group(['prefix' => 'payop'], static function () {
        Route::get('/buy/{id}', [DonationsPayOpController::class, 'buy'])->where('id', '[0-9]+')->name('donate-payop');
        Route::get('/success', [DonationsPayOpController::class, 'handleSuccessCallback'])->name('donate-payop-success');
        Route::get('/error', [DonationsPayOpController::class, 'handleErrorCallback'])->name('donate-payop-error');
    });

    Route::group(['prefix' => 'maxicard'], static function () {
        Route::get('/buy', [DonationsMaxiCardController::class, 'buy'])->name('donate-maxicard-buy');
        Route::post('/buy', [DonationsMaxiCardController::class, 'store'])->name('donate-maxicard-buy-post');
    });

    Route::group(['prefix' => 'stripe'], static function () {
        Route::get('/buy/{id}', [DonationsStripeController::class, 'buy'])->where('id', '[0-9]+')->name('donate-stripe');
        Route::post('/buy/{id}', [DonationsStripeController::class, 'buyPost'])->where('id', '[0-9]+')->name('donate-stripe-post');
        Route::post('/confirm', [DonationsStripeController::class, 'confirm'])->name('donate-stripe-confirm');
        Route::get('/success', [DonationsStripeController::class, 'success'])->name('donate-stripe-success');
        Route::get('/error', [DonationsStripeController::class, 'error'])->name('donate-stripe-error');
    });
});
