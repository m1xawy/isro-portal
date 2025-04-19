<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DownloadController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin2')->name('admin.')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('home');

        //Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
        Route::post('/settings/clear-cache', [SettingController::class, 'clear_cache'])->name('settings.clear-cache');

        //Users
        Route::get('/users', [UsersController::class, 'index'])->name('users.index');
        Route::get('/users/{user}/view', [UsersController::class, 'view'])->name('users.view');
        Route::put('/users/{user}', [UsersController::class, 'update'])->name('users.update');

        //News
        Route::get('/news', [NewsController::class, 'index'])->name('news.index');
        Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/news', [NewsController::class, 'store'])->name('news.store');
        Route::get('/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::put('/news/{news}', [NewsController::class, 'update'])->name('news.update');
        Route::get('/news/{news}/delete', [NewsController::class, 'delete'])->name('news.delete');
        Route::delete('/news/{news}', [NewsController::class, 'destroy'])->name('news.destroy');

        //Downloads
        Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
        Route::get('/download/create', [DownloadController::class, 'create'])->name('download.create');
        Route::post('/download', [DownloadController::class, 'store'])->name('download.store');
        Route::get('/download/{download}/edit', [DownloadController::class, 'edit'])->name('download.edit');
        Route::put('/download/{download}', [DownloadController::class, 'update'])->name('download.update');
        Route::get('/download/{download}/delete', [DownloadController::class, 'delete'])->name('download.delete');
        Route::delete('/download/{download}', [DownloadController::class, 'destroy'])->name('download.destroy');

        //Pages
        Route::get('/pages', [PagesController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [PagesController::class, 'create'])->name('pages.create');
        Route::post('/pages', [PagesController::class, 'store'])->name('pages.store');
        Route::get('/pages/{pages}/edit', [PagesController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{pages}', [PagesController::class, 'update'])->name('pages.update');
        Route::get('/pages/{pages}/delete', [PagesController::class, 'delete'])->name('pages.delete');
        Route::delete('/pages/{pages}', [PagesController::class, 'destroy'])->name('pages.destroy');
    });
});
