<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaterkitController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\EkspedisiController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\DisposisiController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

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
Route::get('/', [LoginController::class, 'login_tu'])->name('login_tu');
Route::get('home', [StaterkitController::class, 'home'])->name('home');
// Route Components

// Route for Tabel Surat Masuk dan Keluar
Route::get('surat/suratMasuk', [SuratController::class, 'surat_masuk'])->name('surat_masuk');
Route::post('surat/suratMasuk', [SuratController::class, 'surat_masuk'])->name('surat_masuk');
Route::get('surat/suratKeluar', [SuratController::class, 'surat_keluar'])->name('surat_keluar');
Route::post('surat/suratKeluar', [SuratController::class, 'surat_keluar'])->name('surat_keluar');
Route::get('surat/create/{surat}', [SuratController::class, 'create'])->name('Input Surat');
Route::post('surat/store', [SuratController::class, 'store'])->name('store');
Route::delete('surat/{id}', [SuratController::class, 'destroy'])->name('Hapus data');
Route::get('surat/viewpdf/{id}', [SuratController::class, 'viewPDF'])->name('view pdf Surat');
Route::get('surat/{id}/edit', [SuratController::class, 'edit'])->name('Edit Surat');
Route::put('surat/{id}', [SuratController::class, 'update'])->name('Update Surat');
Route::get('surat/buatSurat', [SuratController::class, 'buat'])->name('Buat Surat');
Route::post('surat/shop', [SuratController::class, 'shop'])->name('shop');

// Route for Tabel Surat Penting
Route::get('penting/index', [SuratController::class, 'indexPenting'])->name('Tabel Surat Penting');


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

//Route Auth
Route::get('/auth/login', [LoginController::class, 'login_tu'])->name('login_tu');
Route::post('/authenticate_tu', [LoginController::class, 'authenticate_tu'])->name('authenticate_tu');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/auth/registrasi', [RegisterController::class, 'registrasi'])->name('registrasi');
Route::post('/registrasi_store', [RegisterController::class, 'registrasi_store'])->name('registrasi_store');

// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap']);
