<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\KamarController;
use App\Http\Controllers\Api\PasienController;

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

Route::prefix('kamar')->group(function () {
    Route::get('/', [KamarController::class, 'index']);
    Route::post('/clear-cache', [KamarController::class, 'clearCache'])->middleware('auth:sanctum'); // protect
});
//Route::post('/pasien', [PasienController::class, 'store']);
