<?php

use App\Http\Controllers\Donate\DonationsController;
use App\Http\Controllers\Donate\DonationsMaxiCardController;
use App\Http\Controllers\Donate\DonationsPaypalController;
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

    Route::group(['prefix' => 'maxicard'], static function () {
        Route::get('/buy', [DonationsMaxiCardController::class, 'buy'])->name('donate-maxicard-buy');
        Route::post('/buy', [DonationsMaxiCardController::class, 'store'])->name('donate-maxicard-buy-post');
    });
});
