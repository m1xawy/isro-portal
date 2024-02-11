<?php

use App\Http\Controllers\Donate\DonationsCoinbaseController;
use App\Http\Controllers\Donate\DonationsPayOpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/payop/pingback', [DonationsPayOpController::class, 'handleAPICallback'])->name('api-payop-get-pingback');
Route::post('/coinbase/pingback', [DonationsCoinbaseController::class, 'handleCallback'])->name('api-coinbase-get-pingback');
