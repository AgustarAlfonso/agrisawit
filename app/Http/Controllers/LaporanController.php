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
        return view('dashboard.pemilik.laporan.HalamanLaporanPemilik');
    }

    public function tampilLaporanKaryawan()
    {
        return view('dashboard.karyawan.laporan.HalamanLaporanKaryawan');
    }

    private function ambilDataPanen($bulan, $tahun)
    {
        return Panen::whereMonth('tanggalPanen', $bulan)
                    ->whereYear('tanggalPanen', $tahun)
                    ->orderBy('tanggalPanen', 'desc')
                    ->get();
    }

    private function ambilDataStok($bulan, $tahun)
    {
        return Stok::whereMonth('tanggalBerubah', $bulan)
                   ->whereYear('tanggalBerubah', $tahun)
                   ->orderBy('tanggalBerubah', 'desc')
                   ->get();
    }

    private function ambilDataPenjualan($bulan, $tahun)
    {
        return Penjualan::whereMonth('tanggalPenjualan', $bulan)
                        ->whereYear('tanggalPenjualan', $tahun)
                        ->orderBy('tanggalPenjualan', 'desc')
                        ->get();
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
                $data = $this->ambilDataPanen($bulanLaporan, $tahunLaporan);
                $viewPath = "dashboard.pemilik.laporan.panen";
                break;
            case 'stok':
                $data = $this->ambilDataStok($bulanLaporan, $tahunLaporan);
                $viewPath = "dashboard.pemilik.laporan.stok";
                break;
            case 'penjualan':
                $data = $this->ambilDataPenjualan($bulanLaporan, $tahunLaporan);
                $viewPath = "dashboard.pemilik.laporan.penjualan";
                break;
            case 'seluruh_laporan':
                $data = [
                    'panen' => $this->ambilDataPanen($bulanLaporan, $tahunLaporan),
                    'stok' => $this->ambilDataStok($bulanLaporan, $tahunLaporan),
                    'penjualan' => $this->ambilDataPenjualan($bulanLaporan, $tahunLaporan),
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
                $data = $this->ambilDataPanen($bulanLaporan, $tahunLaporan);
                $filename = "Laporan_Panen_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.panen";
                break;
            case 'stok':
                $data = $this->ambilDataStok($bulanLaporan, $tahunLaporan);
                $filename = "Laporan_Stok_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.stok";
                break;
            case 'penjualan':
                $data = $this->ambilDataPenjualan($bulanLaporan, $tahunLaporan);
                $filename = "Laporan_Penjualan_{$tahunLaporan}_{$bulanLaporan}.pdf";
                $viewPath = "dashboard.pemilik.laporan.penjualan";
                break;
            case 'seluruh_laporan':
                $data = [
                    'panen' => $this->ambilDataPanen($bulanLaporan, $tahunLaporan),
                    'stok' => $this->ambilDataStok($bulanLaporan, $tahunLaporan),
                    'penjualan' => $this->ambilDataPenjualan($bulanLaporan, $tahunLaporan),
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
                $data = $this->ambilDataPanen($bulanLaporan, $tahunLaporan);
                break;
            case 'stok':
                $data = $this->ambilDataStok($bulanLaporan, $tahunLaporan);
                break;
            case 'penjualan':
                $data = $this->ambilDataPenjualan($bulanLaporan, $tahunLaporan);
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
                $data = $this->ambilDataPanen($bulanLaporan, $tahunLaporan);
                $filename = "Laporan_Panen_{$tahunLaporan}_{$bulanLaporan}.pdf";
                break;
            case 'stok':
                $data = $this->ambilDataStok($bulanLaporan, $tahunLaporan);
                $filename = "Laporan_Stok_{$tahunLaporan}_{$bulanLaporan}.pdf";
                break;
            case 'penjualan':
                $data = $this->ambilDataPenjualan($bulanLaporan, $tahunLaporan);
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
