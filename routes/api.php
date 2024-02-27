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

Route::get('get_arsip_umum', [SuratController::class, 'get_arsip_umum'])->name('get_arsip_umum');
Route::get('get_arsip_penting', [SuratController::class, 'get_arsip_penting'])->name('get_arsip_penting');
Route::get('cari_data', [SuratController::class, 'cari_data'])->name('cari_data');
