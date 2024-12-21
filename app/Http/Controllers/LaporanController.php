<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Panen;
use App\Models\Penjualan;
use App\Models\Stok;

class LaporanController extends Controller
{
    public function tampilLaporanPemilik()
    {
        return view('dashboard.pemilik.laporan.tampil');
    }

    public function tampilLaporanKaryawan()
    {
        return view('dashboard.karyawan.laporan.tampil');
    }

    public function previewLaporanPemilik(Request $request)
    {
        $jenisLaporan = $request->get('jenis_laporan');
        $bulanLaporan = $request->get('bulan_laporan');
        $tahunLaporan = $request->get('tahun_laporan');
        $data = [];
        $totalStok = 0;

        switch ($jenisLaporan) {
            case 'panen':
                $data = Panen::whereMonth('tanggalPanen', $bulanLaporan)
                             ->whereYear('tanggalPanen', $tahunLaporan)
                             ->orderBy('tanggalPanen', 'desc')
                             ->get();
                $viewPath = "dashboard.pemilik.laporan.panen";
                break;
            case 'stok':
                $data = Stok::whereMonth('tanggalBerubah', $bulanLaporan)
                            ->whereYear('tanggalBerubah', $tahunLaporan)
                            ->orderBy('tanggalBerubah', 'desc')
                            ->get();
                $viewPath = "dashboard.pemilik.laporan.stok";
                break;
            case 'penjualan':
                $data = Penjualan::whereMonth('tanggalPenjualan', $bulanLaporan)
                                 ->whereYear('tanggalPenjualan', $tahunLaporan)
                                 ->orderBy('tanggalPenjualan', 'desc')
                                 ->get();
                $viewPath = "dashboard.pemilik.laporan.penjualan";
                break;
            case 'seluruh_laporan':
                $data = [
                    'panen' => Panen::whereMonth('tanggalPanen', $bulanLaporan)
                                    ->whereYear('tanggalPanen', $tahunLaporan)
                                    ->orderBy('tanggalPanen', 'desc')
                                    ->get(),
                    'stok' => Stok::whereMonth('tanggalBerubah', $bulanLaporan)
                                  ->whereYear('tanggalBerubah', $tahunLaporan)
                                  ->orderBy('tanggalBerubah', 'desc')
                                  ->get(),
                    'penjualan' => Penjualan::whereMonth('tanggalPenjualan', $bulanLaporan)
                                            ->whereYear('tanggalPenjualan', $tahunLaporan)
                                            ->orderBy('tanggalPenjualan', 'desc')
                                            ->get(),
                ];

                $totalStok = $data['stok']->sum('jumlahPerubahan');
                $viewPath = "dashboard.pemilik.laporan.seluruh";
                break;
            default:
                abort(404, 'Jenis laporan tidak ditemukan.');
        }

        $pdf = Pdf::loadView($viewPath, compact('data', 'bulanLaporan', 'tahunLaporan', 'totalStok'));

        return $pdf->stream('preview.pdf');
    }

    public function unduhLaporanPemilik(Request $request)
    {
        $jenisLaporan = $request->get('jenis_laporan');
        $bulanLaporan = $request->get('bulan_laporan');
        $tahunLaporan = $request->get('tahun_laporan');
        $data = [];
        $totalStok = 0;
        $filename = '';

        switch ($jenisLaporan) {
            case 'panen':
                $data = Panen::whereMonth('tanggalPanen', $bulanLaporan)
                             ->whereYear('tanggalPanen', $tahunLaporan)
                             ->orderBy('tanggalPanen', 'desc')
                             ->get();
                $filename = "Laporan_Panen_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.panen";
                break;
            case 'stok':
                $data = Stok::whereMonth('tanggalBerubah', $bulanLaporan)
                            ->whereYear('tanggalBerubah', $tahunLaporan)
                            ->orderBy('tanggalBerubah', 'desc')
                            ->get();
                $filename = "Laporan_Stok_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.stok";
                break;
            case 'penjualan':
                $data = Penjualan::whereMonth('tanggalPenjualan', $bulanLaporan)
                                 ->whereYear('tanggalPenjualan', $tahunLaporan)
                                 ->orderBy('tanggalPenjualan', 'desc')
                                 ->get();
                $filename = "Laporan_Penjualan_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.penjualan";
                break;
            case 'seluruh_laporan':
                $data = [
                    'panen' => Panen::whereMonth('tanggalPanen', $bulanLaporan)
                                    ->whereYear('tanggalPanen', $tahunLaporan)
                                    ->orderBy('tanggalPanen', 'desc')
                                    ->get(),
                    'stok' => Stok::whereMonth('tanggalBerubah', $bulanLaporan)
                                  ->whereYear('tanggalBerubah', $tahunLaporan)
                                  ->orderBy('tanggalBerubah', 'desc')
                                  ->get(),
                    'penjualan' => Penjualan::whereMonth('tanggalPenjualan', $bulanLaporan)
                                            ->whereYear('tanggalPenjualan', $tahunLaporan)
                                            ->orderBy('tanggalPenjualan', 'desc')
                                            ->get(),
                ];

                $totalStok = $data['stok']->sum('jumlahPerubahan');
                $filename = "Laporan_Seluruh_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.seluruh";
                break;
            default:
                abort(404, 'Jenis laporan tidak ditemukan.');
        }

        $pdf = Pdf::loadView($viewPath, compact('data', 'bulanLaporan', 'tahunLaporan', 'totalStok'));

        return $pdf->download($filename);
    }

    public function previewLaporanKaryawan(Request $request)
    {
        $jenisLaporan = $request->get('jenis_laporan');
        $bulanLaporan = $request->get('bulan_laporan');
        $tahunLaporan = $request->get('tahun_laporan');
        $data = [];

        switch ($jenisLaporan) {
            case 'panen':
                $data = Panen::whereMonth('tanggalPanen', $bulanLaporan)
                             ->whereYear('tanggalPanen', $tahunLaporan)
                             ->orderBy('tanggalPanen', 'desc')
                             ->get();
                break;
            case 'stok':
                $data = Stok::whereMonth('tanggalBerubah', $bulanLaporan)
                            ->whereYear('tanggalBerubah', $tahunLaporan)
                            ->orderBy('tanggalBerubah', 'desc')
                            ->get();
                break;
            case 'penjualan':
                $data = Penjualan::whereMonth('tanggalPenjualan', $bulanLaporan)
                                 ->whereYear('tanggalPenjualan', $tahunLaporan)
                                 ->orderBy('tanggalPenjualan', 'desc')
                                 ->get();
                break;
            default:
                abort(404, 'Jenis laporan tidak ditemukan.');
        }

        $viewPath = "dashboard.karyawan.laporan.$jenisLaporan";
        $pdf = Pdf::loadView($viewPath, compact('data', 'bulanLaporan', 'tahunLaporan'));

        return $pdf->stream('preview.pdf');
    }

    public function unduhLaporanKaryawan(Request $request)
    {
        $jenisLaporan = $request->get('jenis_laporan');
        $bulanLaporan = $request->get('bulan_laporan');
        $tahunLaporan = $request->get('tahun_laporan');
        $data = [];

        switch ($jenisLaporan) {
            case 'panen':
                $data = Panen::whereMonth('tanggalPanen', $bulanLaporan)
                             ->whereYear('tanggalPanen', $tahunLaporan)
                             ->orderBy('tanggalPanen', 'desc')
                             ->get();
                $filename = "Laporan_Panen_{$tahunLaporan}_{$bulanLaporan}.pdf";
                break;
            case 'stok':
                $data = Stok::whereMonth('tanggalBerubah', $bulanLaporan)
                            ->whereYear('tanggalBerubah', $tahunLaporan)
                            ->orderBy('tanggalBerubah', 'desc')
                            ->get();
                $filename = "Laporan_Stok_{$tahunLaporan}_{$bulanLaporan}.pdf";
                break;
            case 'penjualan':
                $data = Penjualan::whereMonth('tanggalPenjualan', $bulanLaporan)
                                 ->whereYear('tanggalPenjualan', $tahunLaporan)
                                 ->orderBy('tanggalPenjualan', 'desc')
                                 ->get();
                $filename = "Laporan_Penjualan_{$tahunLaporan}_{$bulanLaporan}.pdf";
                break;
            default:
                abort(404, 'Jenis laporan tidak ditemukan.');
        }

        $viewPath = "dashboard.karyawan.laporan.$jenisLaporan";
        $pdf = Pdf::loadView($viewPath, compact('data', 'bulanLaporan', 'tahunLaporan'));

        return $pdf->download($filename);
    }
}
