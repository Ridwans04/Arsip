<?php

use App\Http\Controllers\Arsip_Controller;
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

Route::get('pilih_klasifikasi_surat', [Arsip_Controller::class, 'pilih_klasifikasi_surat'])->name('pilih_klasifikasi_surat');
Route::get('get_data_arsip', [Arsip_Controller::class, 'get_data_arsip'])->name('get_data_arsip');
Route::get('get_arsip_lama', [Arsip_Controller::class, 'get_arsip_lama'])->name('get_arsip_lama');
Route::get('cari_data_umum', [Arsip_Controller::class, 'cari_data_umum'])->name('cari_data_umum');
Route::get('cari_data_penting', [Arsip_Controller::class, 'cari_data_penting'])->name('cari_data_penting');
Route::post('update_arsip', [Arsip_Controller::class, 'update_arsip'])->name('update_arsip');
