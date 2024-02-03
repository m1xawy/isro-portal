<?php

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

    Route::any('/ranking/player', [RankingController::class, 'player'])->name('ranking.player');
    Route::any('/ranking/guild', [RankingController::class, 'guild'])->name('ranking.guild');
    Route::any('/ranking/unique', [RankingController::class, 'unique'])->name('ranking.unique');
    Route::any('/ranking/fortress/player', [RankingController::class, 'fortress_player'])->name('ranking.fortress.player');
    Route::any('/ranking/fortress/guild', [RankingController::class, 'fortress_guild'])->name('ranking.fortress.guild');

    //TODO: simple way to switch middleware if email confirmation is enabled, i need to make custom middleware to handle it better
    Route::middleware(['auth', isEmailConfirmation()])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/edit', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/profile/donate', [ProfileController::class, 'donate'])->name('profile.donate');
        Route::get('/profile/donate/history', [ProfileController::class, 'donate_history'])->name('profile.donate.history');
    });

    require __DIR__.'/auth.php';
});
