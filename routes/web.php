<?php

use App\Http\Controllers\AkunController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PanenController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StokController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('HalamanLogin');
});
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/errors/403', function () {
    return view('errors.403');
});

Route::get('/lockscreen', [LoginController::class, 'lockScreen'])->middleware('auth')->name('lockscreen');
Route::post('/lockscreen/submit', [LoginController::class, 'unlockScreen'])->name('lockscreen.submit');'lockscreen';

Route::get('/go-back', [loginController::class, 'goBack'])->name('go-back');



Route::middleware(['auth', 'role:pemilik', 'lockscreen.protected', 'log.activity'])->group(function () {

    Route::get('/dashboard/pemilik/index', [DashboardController::class, 'tampilDashboardPemilik'])->name('dashboard.pemilik.index');
    Route::get('/dashboard/pemilik/akun', [AkunController::class, 'tampilAkun'])->name('dashboard.pemilik.akun');
    Route::get ('/dashboard/pemilik/akun/tambah', [AkunController::class, 'tambahAkun'])->name('dashboard.pemilik.akun.tambah');
    Route::post ('/dashboard/pemilik/akun/tambah/submit', [AkunController::class, 'simpanDataAkun'])->name('dashboard.pemilik.akun.tambah.submit');
    Route::get('/dashboard/pemilik/akun/hapus/{id}', [AkunController::class, 'hapusAkun'])->name('dashboard.pemilik.akun.hapus');
    Route::get ('/dashboard/pemilik/akun/ubah/{id}', [AkunController::class, 'ubahAkun'])->name('dashboard.pemilik.akun.ubah');
    Route::post ('/dashboard/pemilik/akun/ubah/submit/{id}', [AkunController::class, 'perbaruiDataAkun'])->name('dashboard.pemilik.akun.ubah.submit');
    Route::get('/dashboard/pemilik/log', [LogController::class, 'tampilLog'])->name('dashboard.pemilik.log');
    Route::get('/dashboard/pemilik/laporan', [LaporanController::class, 'tampilLaporanPemilik'])->name('dashboard.pemilik.laporan');
    Route::get('/dashboard/pemilik/laporan/unduh', [LaporanController::class, 'unduhLaporanPemilik'])->name('dashboard.pemilik.laporan.unduh');
    Route::get('/dashboard/pemilik/laporan/preview', [LaporanController::class, 'previewLaporanPemilik'])->name('dashboard.pemilik.laporan.preview');
       
});

Route::middleware(['auth', 'role:karyawan', 'lockscreen.protected', 'log.activity'])->group(function () {
    Route::get('/dashboard/karyawan/index', [DashboardController::class, 'tampilDashboardKaryawan'])->name('dashboard.karyawan.index');

    Route::get('/dashboard/karyawan/panen', [PanenController::class, 'tampilPanen'])->name('dashboard.karyawan.panen');
    Route::get ('/dashboard/karyawan/panen/tambah', [PanenController::class, 'tambahPanen'])->name('dashboard.karyawan.panen.tambah');
    Route::post ('/dashboard/karyawan/panen/tambah/submit', [PanenController::class, 'simpanDatapanen'])->name('dashboard.karyawan.panen.tambah.submit');
    Route::get('/dashboard/karyawan/panen/hapus/{id}', [PanenController::class, 'hapusPanen'])->name('dashboard.karyawan.panen.hapus');
    Route::get ('/dashboard/karyawan/panen/ubah/{id}', [PanenController::class, 'ubahPanen'])->name('dashboard.karyawan.panen.ubah');
    Route::post ('/dashboard/karyawan/panen/ubah/submit/{id}', [PanenController::class, 'perbaruiDataPanen'])->name('dashboard.karyawan.panen.ubah.submit');


    Route::get('/dashboard/karyawan/penjualan', [PenjualanController::class, 'tampilPenjualan'])->name('dashboard.karyawan.penjualan');
    Route::get ('/dashboard/karyawan/penjualan/tambah', [PenjualanController::class, 'tambahpenjualan'])->name('dashboard.karyawan.penjualan.tambah');
    Route::post ('/dashboard/karyawan/penjualan/tambah/submit', [PenjualanController::class, 'simpanDataPenjualan'])->name('dashboard.karyawan.penjualan.tambah.submit');
    Route::get('/dashboard/karyawan/penjualan/hapus/{id}', [PenjualanController::class, 'hapuspenjualan'])->name('dashboard.karyawan.penjualan.hapus');
    Route::get ('/dashboard/karyawan/penjualan/ubah/{id}', [PenjualanController::class, 'ubahpenjualan'])->name('dashboard.karyawan.penjualan.ubah');
    Route::post ('/dashboard/karyawan/penjualan/ubah/submit/{id}', [PenjualanController::class, 'perbaruiDataPenjualan'])->name('dashboard.karyawan.penjualan.ubah.submit');


    Route::get('/dashboard/karyawan/stok', [StokController::class, 'tampilStok'])->name('dashboard.karyawan.stok');

    Route::get('/dashboard/karyawan/jadwal', [JadwalController::class, 'tampilJadwal'])->name('dashboard.karyawan.jadwal');
    Route::get ('/dashboard/karyawan/jadwal/tambah', [JadwalController::class, 'tambahjadwal'])->name('dashboard.karyawan.jadwal.tambah');
    Route::post ('/dashboard/karyawan/jadwal/tambah/submit', [JadwalController::class, 'simpanDataJadwal'])->name('dashboard.karyawan.jadwal.tambah.submit');
    Route::get('/dashboard/karyawan/jadwal/hapus/{id}', [JadwalController::class, 'hapusjadwal'])->name('dashboard.karyawan.jadwal.hapus');
    Route::get ('/dashboard/karyawan/jadwal/ubah/{id}', [JadwalController::class, 'ubahjadwal'])->name('dashboard.karyawan.jadwal.ubah');
    Route::post ('/dashboard/karyawan/jadwal/ubah/submit/{id}', [JadwalController::class, 'perbaruiDataJadwal'])->name('dashboard.karyawan.jadwal.ubah.submit');

    Route::get('/dashboard/karyawan/laporan', [LaporanController::class, 'tampilLaporanKaryawan'])->name('dashboard.karyawan.laporan');
    Route::get('/dashboard/karyawan/laporan/unduh', [LaporanController::class, 'unduhLaporanKaryawan'])->name('dashboard.karyawan.laporan.unduh');
    Route::get('/dashboard/karyawan/laporan/preview', [LaporanController::class, 'previewLaporanKaryawan'])->name('dashboard.karyawan.laporan.preview');



});





Route::post('/login/submit', [LoginController::class, 'validasiAkun'])->name('submit.login');




