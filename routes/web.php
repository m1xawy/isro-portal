<?php

use App\Http\Controllers\Donate\DonationsCoinbaseController;
use App\Http\Controllers\Donate\DonationsController;
use App\Http\Controllers\Donate\DonationsMaxiCardController;
use App\Http\Controllers\Donate\DonationsPayOpController;
use App\Http\Controllers\Donate\DonationsPaypalController;
use App\Http\Controllers\Donate\DonationsStripeController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use App\Models\SRO\Portal\MuhAlteredInfo;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'language'], function () {
    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('post.show');

    Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/timers', [PageController::class, 'timers'])->name('pages.timers');
    Route::get('/download', [DownloadController::class, 'index'])->name('pages.download');

    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    Route::get('/ranking/character/{name}', [RankingController::class, 'character_view'])->name('ranking.character.view');
    Route::get('/ranking/guild/{name}', [RankingController::class, 'guild_view'])->name('ranking.guild.view');
    Route::any('/ranking/guild-crest/{hex}', [RankingController::class, 'guild_crest'])->name('ranking.guild-crest');

    Route::any('/ranking/player', [RankingController::class, 'player'])->name('ranking.player');
    Route::any('/ranking/guild', [RankingController::class, 'guild'])->name('ranking.guild');
    Route::any('/ranking/unique', [RankingController::class, 'unique'])->name('ranking.unique');
    Route::any('/ranking/fortress/player', [RankingController::class, 'fortress_player'])->name('ranking.fortress.player');
    Route::any('/ranking/fortress/guild', [RankingController::class, 'fortress_guild'])->name('ranking.fortress.guild');

    //TODO: simple way to switch middleware if email confirmation is enabled, i need to make custom middleware to handle it better
    Route::middleware(['auth', isEmailConfirmation()])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit-password', [ProfileController::class, 'edit_password'])->name('profile.edit-password');
        Route::get('/profile/edit-email', [ProfileController::class, 'edit_email'])->name('profile.edit-email');
        Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //Route::get('/profile/donate', [ProfileController::class, 'donate'])->name('profile.donate');
        Route::get('/profile/donate/history', [ProfileController::class, 'donate_history'])->name('profile.donate.history');

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
    });

    require __DIR__.'/auth.php';
});
