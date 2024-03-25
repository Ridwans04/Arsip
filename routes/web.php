<?php

use App\Http\Controllers\Arsip_Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\Auth\Auth_Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Models\Dokumen;
use App\Models\Surat;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ROUTE HOME
Route::view('/', 'auth/login')->name('login_tu');
Route::view('home', 'home')->name('home');

// ROUTE AUTH
Route::view('/auth/login', 'auth/login')->name('login_tu');
Route::post('/authenticate_tu', [Auth_Controller::class, 'authenticate_tu'])->name('authenticate_tu');
Route::get('/logout', [Auth_Controller::class, 'logout'])->name('logout');
Route::view('/auth/registrasi', 'auth/registrasi')->name('registrasi');
Route::post('/registrasi_store', [Auth_Controller::class, 'registrasi_store'])->name('registrasi_store');

// ROUTE SURAT MASUK
Route::prefix('arsip')->group(function () {
    // ROUTE SURAT KELUAR
    Route::view('arsip_lama', 'arsip_lama.data')->name('arsip_lama');
    Route::view('arsip_umum', 'arsip.arsip_umum')->name('arsip_umum');
    Route::view('arsip_penting', 'arsip.arsip_penting', [
        'list_surat' => Dokumen::where('klasifikasi', 'Penting')->get()
    ])->name('arsip_penting');
    Route::get('lihat_arsip/{id}', function($id){
        $surat = Surat::find($id);
        return view('arsip_lama.lihat_arsip', compact('surat'));
    })->name('lihat_arsip');
    Route::delete('{id}', [Arsip_Controller::class, 'destroy'])->name('Hapus data');
    Route::get('{id}/edit', [Arsip_Controller::class, 'edit'])->name('Edit Surat');
    Route::put('{id}', [Arsip_Controller::class, 'update'])->name('Update Surat');

});

// Route for Tabel Surat Penting
Route::get('penting/index', [Arsip_Controller::class, 'indexPenting'])->name('Tabel Surat Penting');

// Route for lembar disposisi
Route::get('disposisi/index', [DisposisiController::class, 'index'])->name('Data Lembar Disposisi');
Route::get('disposisi/create', [DisposisiController::class, 'create'])->name('form Lembar Disposisi');
Route::get('disposisi/{id}/suratDisposisi', [DisposisiController::class, 'buat'])->name('form Lembar Disposisi');
Route::post('disposisi/store', [DisposisiController::class, 'store'])->name('Input Data Lembar Disposisi');
Route::post('disposisi/shop', [DisposisiController::class, 'shop'])->name('Input Data Lembar Disposisi');
Route::get('disposisi/{id}/edit', [DisposisiController::class, 'edit'])->name('Edit Data Lembar Disposisi');
Route::put('disposisi/{id}', [DisposisiController::class, 'update'])->name('Update Lembar Disposisi');
Route::delete('disposisi/{id}', [DisposisiController::class, 'destroy'])->name('Hapus Lembar Disposisi');

// Route for Daftar Arsip
Route::post('arsip/cari_arsip', [ArsipController::class, 'cari_arsip'])->name('cari_arsip');
Route::get('arsip/index', [ArsipController::class, 'index'])->name('Daftar Arsip');
Route::post('arsip/index', [ArsipController::class, 'index'])->name('Daftar Arsip');
Route::get('arsip/create', [ArsipController::class, 'create'])->name('input data Arsip');
Route::post('arsip/store', [ArsipController::class, 'store'])->name('simpan data Arsip');
Route::get('arsip/{id}/suratArsip', [ArsipController::class, 'buat'])->name('buat data Arsip');
Route::post('arsip/shop', [ArsipController::class, 'shop'])->name('simpan data Arsip');
Route::get('arsip/{id}/edit', [ArsipController::class, 'edit'])->name('edit data Arsip');
Route::put('arsip/{id}', [ArsipController::class, 'update'])->name('update data Arsip');
Route::delete('arsip/{id}', [ArsipController::class, 'destroy'])->name('Hapus data Arsip');

//Route for Rekap Ekspedisi
Route::get('ekspedisi/index', [EkspedisiController::class, 'index'])->name('Rekap ekspedisi');
Route::post('ekspedisi/index', [EkspedisiController::class, 'index'])->name('Rekap ekspedisi');
Route::get('ekspedisi/create', [EkspedisiController::class, 'create'])->name('Tambah Data Ekspedisi');
Route::post('ekspedisi/store', [EkspedisiController::class, 'store'])->name('Tambah Data ');
Route::get('ekspedisi/{id}/suratEkspedisi', [EkspedisiController::class, 'buat'])->name('Tambah Data Ekspedisi');
Route::post('ekspedisi/shop', [EkspedisiController::class, 'shop'])->name('Tambah Data ');
Route::get('ekspedisi/{id}/edit', [EkspedisiController::class, 'edit'])->name('Edit Data Ekspedisi');
Route::put('ekspedisi/{id}', [EkspedisiController::class, 'update'])->name('Update Data Ekspedisi');
Route::delete('ekspedisi/{id}', [EkspedisiController::class, 'destroy'])->name('Hapus Data Ekspedisi');

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
