<?php

namespace App\Observers;

use App\Models\Penjualan;
use App\Models\Stok;

class PenjualanObserver
{
    public function created(Penjualan $penjualan)
    {
        Stok::create([
            'jenisPerubahan' => 'penjualan',
            'jumlahPerubahan' => -$penjualan->jumlahTerjual,
            'tanggalBerubah' => $penjualan->tanggalPenjualan,
        ]);   
    }

        public function deleted(Penjualan $penjualan)
        {
            $this->hapusStok($penjualan->jumlahTerjual, $penjualan->tanggalPenjualan);
        }
        

    public function updated(Penjualan $penjualan)
    {
        $originalTanggal = $penjualan->getOriginal('tanggalPenjualan');
        $originalJumlah = $penjualan->getOriginal('jumlahTerjual');
    
        // Jika tanggal atau jumlah terjual berubah
        if ($penjualan->isDirty('tanggalPenjualan') || $penjualan->isDirty('jumlahTerjual')) {
            // Hapus stok dengan data lama
            $this->hapusStok($originalJumlah, $originalTanggal);
    
            // Tambahkan atau perbarui stok dengan data baru
            $this->updateStok(-$penjualan->jumlahTerjual, 'penjualan', $penjualan->tanggalPenjualan);
        }
    }
    

    private function updateStok($jumlahPanen, $jenis, $tanggal)
    {
        // Cari record stok terkait dengan penjualan
        $stokRecord = Stok::where('jenisPerubahan', $jenis)
                          ->where('tanggalBerubah', $tanggal)
                          ->first();
    
        if ($stokRecord) {
            // Update record stok jika sudah ada
            $stokRecord->update([
                'jumlahPerubahan' => $jumlahPanen,
            ]);
        } else {
            // Tambahkan record stok baru jika belum ada
            Stok::create([
                'jenisPerubahan' => $jenis,
                'jumlahPerubahan' => $jumlahPanen, // Placeholder, akan dihitung ulang nanti
                'tanggalBerubah' => $tanggal,
            ]);
        }
    
       
    }

 

    private function hapusStok($jumlahTerjual, $tanggal)
    {
        // Cari record stok terkait dengan penjualan berdasarkan jumlah dan tanggal lama
        $stokRecord = Stok::where('jenisPerubahan', 'penjualan')
                          ->where('jumlahPerubahan', -$jumlahTerjual) // Negatif karena penjualan
                          ->where('tanggalBerubah', $tanggal)
                          ->latest('id')
                          ->first();
    
        if ($stokRecord) {
            $stokRecord->delete(); // Hapus record stok terkait
        }
    }
    

    

    
}