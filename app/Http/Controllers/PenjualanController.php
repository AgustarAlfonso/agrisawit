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

    private function berhasilPopUp($pesan)
    {
        session()->flash('berhasil', $pesan);
    }
    
    private function gagalPopUp($errors)
    {
        session()->flash('gagal', $errors);
    }

    public function tampilPenjualan()
    {
        $penjualans = $this->ambilSemuaPenjualan();
        return view('dashboard.karyawan.penjualan.HalamanMengelolaPenjualan', compact('penjualans'));
    }
    

    public function tambahPenjualan()
    {
        return view('dashboard.karyawan.penjualan.HalamanTambahPenjualan');
    }

    public function simpanDataPenjualan(Request $request)
    {
        try {
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
            // $penjualanExists = Penjualan::where('tanggalPenjualan', $request->tanggalPenjualan)->first();
            // if ($penjualanExists) {
            //     // Call gagalPopUp() to flash error message for popup
            //     $this->gagalPopUp([
            //         'Tanggal penjualan sudah ada. Harap gunakan tanggal lain. Data penjualan: ' . $penjualanExists->jumlahTerjual . ' kg',
            //     ]);
            //     return redirect()->back()->withInput();
            // }
    
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
                    // Call gagalPopUp() to flash error message for popup
                    $this->gagalPopUp([
                        'Penjualan ini menyebabkan stok menjadi negatif pada tanggal ' . $tanggalFormat . '. Stok tersedia: ' . ($stokKumulatif + $request->jumlahTerjual) . ' kg',
                    ]);
                    return redirect()->back()->withInput();
                }
            }
    
            // Simpan data penjualan
            Penjualan::create([
                'jumlahTerjual' => $request->jumlahTerjual,
                'totalHarga' => $request->totalHarga,
                'tanggalPenjualan' => $request->tanggalPenjualan,
            ]);
    
            $this->berhasilPopUp('Penjualan berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Call gagalPopUp() to flash validation error messages for popup
            $this->gagalPopUp($e->validator->errors()->all());
            return redirect()->back()->withInput();
        }
    
        return redirect()->route('dashboard.karyawan.penjualan');
    }
    

    public function ubahPenjualan($id)
    {
        $penjualan = $this->ambilPenjualan($id);
        return view('dashboard.karyawan.penjualan.HalamanUbahPenjualan', compact('penjualan'));
    }
    public function perbaruiDataPenjualan(Request $request, $id)
    {
        try {
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
        
            // Ambil data penjualan berdasarkan ID
            $penjualan = $this->ambilPenjualan($id);
        
            // Validasi stok kumulatif
            $stokKumulatif = 0;
        
            // Ambil perubahan stok tanpa memperhitungkan data yang sedang diubah
            $stokPerubahan = Stok::where('tanggalBerubah', '<=', $request->tanggalPenjualan)
                                 ->where('id', '!=', $penjualan->stok->id)
                                 ->orderBy('tanggalBerubah', 'asc')
                                 ->get();
        
            // Tambahkan perubahan stok baru ke dalam perhitungan stok sementara
            $stokPerubahan->push((object)[
                'tanggalBerubah' => $request->tanggalPenjualan,
                'jumlahPerubahan' => -$request->jumlahTerjual,
            ]);
        
            // Periksa stok kumulatif
            foreach ($stokPerubahan->sortBy('tanggalBerubah') as $stok) {
                $stokKumulatif += $stok->jumlahPerubahan;
        
                // Format tanggal untuk pesan error
                $tanggalFormat = Carbon::parse($stok->tanggalBerubah)->format('d-m-Y');
                if ($stokKumulatif < 0) {
                    // Error ketika stok negatif
                    $this->gagalPopUp([
                        'Penjualan ini menyebabkan stok menjadi negatif pada tanggal ' . $tanggalFormat . '. Stok tersedia: ' . ($stokKumulatif + $request->jumlahTerjual) . ' kg',
                    ]);
                    return redirect()->back()->withInput();
                }
            }
        
            // Perbarui data penjualan
            $penjualan->jumlahTerjual = $request->jumlahTerjual;
            $penjualan->totalHarga = $request->totalHarga;
            $penjualan->tanggalPenjualan = $request->tanggalPenjualan;
            $penjualan->save();
        
            // Perbarui data stok terkait
            $penjualan->stok->update([
                'jenisPerubahan' => 'Penjualan',
                'jumlahPerubahan' => -$request->jumlahTerjual,
                'tanggalBerubah' => $request->tanggalPenjualan,
            ]);
            
            // Jika berhasil, tampilkan pop-up sukses
            $this->berhasilPopUp('Penjualan berhasil diperbarui!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Jika ada validasi yang gagal, tampilkan pop-up gagal
            $this->gagalPopUp($e->validator->errors()->all());
            return redirect()->back()->withInput();
        }
    
        return redirect()->route('dashboard.karyawan.penjualan');
    }
    
    

    public function hapusPenjualan($id)
    {
        $penjualan = $this->ambilPenjualan($id);
        $penjualan->delete();

        return redirect()->route('dashboard.karyawan.penjualan')->with('berhasilDihapus', 'Laporan penjualan berhasil dihapus');
    }
}
