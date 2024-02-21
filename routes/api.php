<?php

use App\Http\Controllers\SuratController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get_data_arsip', [SuratController::class, 'get_data_arsip'])->name('get_data_arsip');
Route::get('cari_data', [SuratController::class, 'cari_data'])->name('cari_data');
