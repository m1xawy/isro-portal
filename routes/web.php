<?php

use App\Http\Controllers\DownloadController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RankingController;
use Illuminate\Support\Facades\Route;

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
    Route::get('/home', function () {
        return view('welcome');
    });

    Route::get('/', [PostController::class, 'index'])->name('home');
    Route::get('/posts/{slug}', [PostController::class, 'show'])->name('post.show');

    Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
    Route::get('/download', [DownloadController::class, 'index'])->name('pages.download');

    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking.index');
    Route::get('/ranking/character/{name}', [RankingController::class, 'character_view'])->name('ranking.character.view');
    Route::get('/ranking/guild/{name}', [RankingController::class, 'guild_view'])->name('ranking.guild.view');

    Route::get('/ranking/player', [RankingController::class, 'player'])->name('ranking.player');
    Route::get('/ranking/guild', [RankingController::class, 'guild'])->name('ranking.guild');
    Route::get('/ranking/unique', [RankingController::class, 'unique'])->name('ranking.unique');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__.'/auth.php';
});
