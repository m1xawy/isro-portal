<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin2')->name('admin.')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('home');
        Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    });
});
