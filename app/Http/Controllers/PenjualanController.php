<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Stok;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    public function ambilSemuaPenjualan($perPage = 5)
    {
        return Penjualan::orderBy('tanggalPenjualan', 'desc')->paginate($perPage);
    }
    

    public function ambilPenjualan($id)
    {
        return Penjualan::findOrFail($id);
    }

    public function tampilPenjualan()
    {
        $penjualans = $this->ambilSemuaPenjualan();
        return view('dashboard.karyawan.penjualan.tampil', compact('penjualans'));
    }
    

    public function tambahPenjualan()
    {
        return view('dashboard.karyawan.penjualan.tambah');
    }

    public function simpanDataPenjualan(Request $request)
    {
        $request->validate([
            'jumlahTerjual' => 'required|integer|min:1',
            'totalHarga' => 'required|numeric|min:0',
            'tanggalPenjualan' => 'required|date|before_or_equal:today',
        ], [
            'jumlahTerjual.required' => 'Jumlah terjual harus diisi.',
            'jumlahTerjual.integer' => 'Jumlah terjual harus berupa angka.',
            'jumlahTerjual.min' => 'Jumlah terjual minimal 1.',
            'totalHarga.required' => 'Total harga harus diisi.',
            'totalHarga.numeric' => 'Total harga harus berupa angka.',
            'totalHarga.min' => 'Total harga tidak boleh negatif.',
            'tanggalPenjualan.required' => 'Tanggal penjualan harus diisi.',
            'tanggalPenjualan.date' => 'Tanggal penjualan tidak valid.',
            'tanggalPenjualan.before_or_equal' => 'Tanggal penjualan tidak boleh di masa depan.',
        ]);
    
        // Validasi jika ada tanggal yang sama
        $penjualanExists = Penjualan::where('tanggalPenjualan', $request->tanggalPenjualan)->first();
        if ($penjualanExists) {
            return redirect()->back()->withErrors([
                'tanggalPenjualan' => 'Tanggal penjualan sudah ada. Harap gunakan tanggal lain. Data penjualan: ' . $penjualanExists->jumlahTerjual . ' kg',
            ])->withInput();
        }
    
        // Ambil semua perubahan stok dan tambahkan data baru untuk simulasi
        $perubahanStok = Stok::orderBy('tanggalBerubah', 'asc')->get();
    
        // Tambahkan data baru sebagai simulasi
        $perubahanStok->push((object)[
            'tanggalBerubah' => $request->tanggalPenjualan,
            'jumlahPerubahan' => -$request->jumlahTerjual,
        ]);
    
        // Urutkan kembali dengan tanggal perubahan
        $perubahanStok = $perubahanStok->sortBy('tanggalBerubah');
    
        // Hitung stok kumulatif dan validasi
        $stokKumulatif = 0;
        foreach ($perubahanStok as $stok) {
            $stokKumulatif += $stok->jumlahPerubahan;
        
            // Konversi tanggalBerubah menjadi format d-m-Y
            $tanggalFormat = \Carbon\Carbon::parse($stok->tanggalBerubah)->format('d-m-Y');
        
            if ($stokKumulatif < 0) {
                return redirect()->back()->withErrors([
                    'jumlahTerjual' => 'Penjualan ini menyebabkan stok menjadi negatif pada tanggal ' . $tanggalFormat . '. Stok tersedia: ' . ($stokKumulatif + $request->jumlahTerjual) . ' kg',
                ])->withInput();
            }
        }
        
    
        // Simpan data penjualan
        Penjualan::create([
            'jumlahTerjual' => $request->jumlahTerjual,
            'totalHarga' => $request->totalHarga,
            'tanggalPenjualan' => $request->tanggalPenjualan,
        ]);
    
        return redirect()->route('dashboard.karyawan.penjualan')->with('berhasilDibuat', 'Laporan penjualan berhasil disimpan!');
    }
    

    public function ubahPenjualan($id)
    {
        $penjualan = $this->ambilPenjualan($id);
        return view('dashboard.karyawan.penjualan.ubah', compact('penjualan'));
    }

    public function perbaruiDataPenjualan(Request $request, $id)
    {
        $request->validate([
            'jumlahTerjual' => 'required|integer|min:1',
            'totalHarga' => 'required|numeric|min:0',
            'tanggalPenjualan' => 'required|date|before_or_equal:today',
        ], [
            'jumlahTerjual.required' => 'Jumlah terjual harus diisi.',
            'jumlahTerjual.integer' => 'Jumlah terjual harus berupa angka.',
            'jumlahTerjual.min' => 'Jumlah terjual minimal 1.',
            'totalHarga.required' => 'Total harga harus diisi.',
            'totalHarga.numeric' => 'Total harga harus berupa angka.',
            'totalHarga.min' => 'Total harga tidak boleh negatif.',
            'tanggalPenjualan.required' => 'Tanggal penjualan harus diisi.',
            'tanggalPenjualan.date' => 'Tanggal penjualan tidak valid.',
            'tanggalPenjualan.before_or_equal' => 'Tanggal penjualan tidak boleh di masa depan.',
        ]);
    
        // Validasi jika ada tanggal yang sama (abaikan data yang sedang diubah)
        $penjualanExists = Penjualan::where('tanggalPenjualan', $request->tanggalPenjualan)
                                    ->where('id', '!=', $id)
                                    ->first();
        if ($penjualanExists) {
            return redirect()->back()->withErrors([
                'tanggalPenjualan' => 'Tanggal penjualan sudah ada. Harap gunakan tanggal lain. Data penjualan: ' . $penjualanExists->jumlahTerjual . ' ton',
            ])->withInput();
        }
    
        // Validasi stok kumulatif hingga tanggal penjualan
        $stokKumulatif = 0;
        $stokPerubahan = Stok::where('tanggalBerubah', '<=', $request->tanggalPenjualan)
                             ->orderBy('tanggalBerubah', 'asc')
                             ->get();
    
        foreach ($stokPerubahan as $stok) {
            $stokKumulatif += $stok->jumlahPerubahan;
    
            // Konversi tanggalBerubah menjadi format d-m-Y
            $tanggalFormat = \Carbon\Carbon::parse($stok->tanggalBerubah)->format('d-m-Y');
    
            if ($stokKumulatif < 0) {
                return redirect()->back()->withErrors([
                    'jumlahTerjual' => 'Penjualan ini menyebabkan stok menjadi negatif pada tanggal ' . $tanggalFormat . '. Stok tersedia: ' . ($stokKumulatif + $request->jumlahTerjual) . ' kg',
                ])->withInput();
            }
        }
    
        // Validasi stok hingga tanggal penjualan
        $stokHinggaTanggal = Stok::where('tanggalBerubah', '<=', $request->tanggalPenjualan)
                                 ->sum('jumlahPerubahan');
    
        if ($request->jumlahTerjual > $stokHinggaTanggal) {
            return redirect()->back()->withErrors([
                'jumlahTerjual' => 'Jumlah terjual melebihi stok yang tersedia hingga tanggal tersebut. Stok tersedia: ' . $stokHinggaTanggal . ' ton',
            ])->withInput();
        }
    
        $penjualan = $this->ambilPenjualan($id);
        $penjualan->jumlahTerjual = $request->jumlahTerjual;
        $penjualan->totalHarga = $request->totalHarga;
        $penjualan->tanggalPenjualan = $request->tanggalPenjualan;
        $penjualan->save();
    
        return redirect()->route('dashboard.karyawan.penjualan')->with('berhasilDibuat', 'Laporan penjualan berhasil diperbarui!');
    }
    

    public function hapusPenjualan($id)
    {
        $penjualan = $this->ambilPenjualan($id);
        $penjualan->delete();

        return redirect()->route('dashboard.karyawan.penjualan')->with('berhasilDihapus', 'Laporan penjualan berhasil dihapus');
    }
}
