<?php

use Illuminate\Support\Facades\Route;

Route::resource('akun', \App\Http\Controllers\AkunController::class);
Route::resource('akun', \App\Http\Controllers\Api\AkunController::class);
Route::resource('faktur-pembelian-api', \App\Http\Controllers\Api\FakturPembelianApiController::class);
Route::resource('mata-uang-api', \App\Http\Controllers\Api\MataUangApiController::class);
Route::resource('pelanggan', \App\Http\Controllers\Api\PelangganController::class);
Route::resource('penerimaan-piutang', \App\Http\Controllers\Api\PenerimaanPiutangController::class);
Route::resource('pengguna', \App\Http\Controllers\Api\PenggunaController::class);
Route::resource('periode', \App\Http\Controllers\API\PeriodeController::class);
Route::resource('perusahaan', \App\Http\Controllers\Api\PerusahaanController::class);
Route::resource('supplier', \App\Http\Controllers\Api\SupplierController::class);
Route::resource('dashboard', \App\Http\Controllers\DashboardController::class);
Route::resource('faktur-pembelian', \App\Http\Controllers\FakturPembelianController::class);
Route::resource('faktur-penjualan', \App\Http\Controllers\FakturPenjualanController::class);
Route::resource('jurnal', \App\Http\Controllers\JurnalController::class);
Route::resource('jurnal-detail', \App\Http\Controllers\JurnalDetailController::class);
Route::resource('laporan', \App\Http\Controllers\LaporanController::class);
Route::resource('login', \App\Http\Controllers\LoginController::class);
Route::resource('mata-uang', \App\Http\Controllers\MataUangController::class);
Route::resource('pelanggan', \App\Http\Controllers\PelangganController::class);
Route::resource('penerimaan-piutang', \App\Http\Controllers\PenerimaanPiutangController::class);
Route::resource('pengguna', \App\Http\Controllers\PenggunaController::class);
Route::resource('periode', \App\Http\Controllers\PeriodeController::class);
Route::resource('perusahaan', \App\Http\Controllers\PerusahaanController::class);
Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
