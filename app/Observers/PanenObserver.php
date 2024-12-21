<?php

namespace App\Observers;

use App\Models\Panen;
use App\Models\Stok;

class PanenObserver
{
    public function created(Panen $panen)
    {
        
        Stok::create([
            'jenisPerubahan' => 'panen',
            'jumlahPerubahan' => $panen->jumlahPanen,
            'tanggalBerubah' => $panen->tanggalPanen,
        ]);    }

    public function deleted(Panen $panen)
    {
        $this->hapusStok($panen->jumlahPanen, $panen->tanggalPanen);
    }

    public function updated(Panen $panen)
    {
        $originalTanggal = $panen->getOriginal('tanggalPanen');
        $originalJumlah = $panen->getOriginal('jumlahPanen');

        // Jika tanggal atau jumlah panen berubah
        if ($panen->isDirty('tanggalPanen') || $panen->isDirty('jumlahPanen')) {
            // Hapus stok dengan data lama
            $this->hapusStok($originalJumlah, $originalTanggal);

            // Tambahkan atau perbarui stok dengan data baru
            $this->updateStok($panen->jumlahPanen, 'panen', $panen->tanggalPanen);
        }
    }

    private function updateStok($jumlahPanen, $jenis, $tanggal)
    {
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
                'jumlahPerubahan' => $jumlahPanen,
                'tanggalBerubah' => $tanggal,
            ]);
        }
    }

    private function hapusStok($jumlahPanen, $tanggal)
    {
        $stokRecord = Stok::where('jenisPerubahan', 'panen')
                          ->where('jumlahPerubahan', $jumlahPanen)
                          ->where('tanggalBerubah', $tanggal)
                          ->latest('id')
                          ->first();

        if ($stokRecord) {
            $stokRecord->delete();
        }
    }
}
