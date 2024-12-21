<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Panen;
use App\Models\Penjualan;
use App\Models\Stok;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function tampilDashboardPemilik()
    {
        // Jadwal Mendatang
        $jadwalMendatang = Jadwal::where('status', 'Pending')
            ->orderBy('tanggal', 'asc')
            ->first();

        // Total Stok
        $totalStok = Stok::sum('jumlahPerubahan');

        // Jumlah Panen Terakhir
        $jumlahPanenTerakhir = Panen::latest('tanggalPanen')->value('jumlahPanen') ?? 0;

        // Jumlah Penjualan Terakhir
        $jumlahPenjualanTerakhir = Penjualan::latest('tanggalPenjualan')->value('jumlahTerjual') ?? 0;

        // Kirim data ke view
        return view('dashboard.pemilik.index', compact(
            'jadwalMendatang',
            'totalStok',
            'jumlahPanenTerakhir',
            'jumlahPenjualanTerakhir'
        ));
    }

    public function tampilDashboardKaryawan()
    {
        // Jadwal Mendatang
        $jadwalMendatang = Jadwal::where('status', 'Pending')
            ->orderBy('tanggal', 'asc')
            ->first();

        // Total Stok
        $totalStok = Stok::sum('jumlahPerubahan');

        // Jumlah Panen Terakhir
        $jumlahPanenTerakhir = Panen::latest('tanggalPanen')->value('jumlahPanen') ?? 0;

        // Jumlah Penjualan Terakhir
        $jumlahPenjualanTerakhir = Penjualan::latest('tanggalPenjualan')->value('jumlahTerjual') ?? 0;

        // Kirim data ke view
        return view('dashboard.karyawan.index', compact(
            'jadwalMendatang',
            'totalStok',
            'jumlahPanenTerakhir',
            'jumlahPenjualanTerakhir'
        ));
    }
}
