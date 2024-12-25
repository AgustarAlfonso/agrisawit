<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PanenController extends Controller
{
  

    public function ambilPanen($id)
    {
        return Panen::findOrFail($id);
    }

    private function berhasilPopUp($pesan)
    {
        session()->flash('berhasil', $pesan);
    }
    
    private function gagalPopUp($errors)
    {
        // Menyimpan pesan error ke session untuk ditampilkan di popup
        session()->flash('gagal', $errors);
    }

    public function ambilSemuaPanen()
    {
        return Panen::orderBy('tanggalPanen', 'desc')->paginate(5);
    }
    

    public function tampilPanen()
    {
        $panens = $this->ambilSemuaPanen();
        return view('dashboard.karyawan.panen.HalamanDataPanen', compact('panens'));
    }

    public function tambahPanen()
    {
        return view('dashboard.karyawan.panen.HalamanTambahPanen');
    }
    public function simpanDatapanen(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'jumlahPanen' => 'required|integer|min:0',
                'tanggalPanen' => 'required|date|before_or_equal:today',
            ], [
                'jumlahPanen.required' => 'Jumlah panen wajib diisi.',
                'jumlahPanen.integer' => 'Jumlah panen harus berupa angka.',
                'jumlahPanen.min' => 'Jumlah panen tidak boleh bernilai negatif.',
                'tanggalPanen.required' => 'Tanggal panen wajib diisi.',
                'tanggalPanen.date' => 'Tanggal panen harus berupa tanggal yang valid.',
                'tanggalPanen.before_or_equal' => 'Tanggal panen tidak boleh berada di masa depan.',
            ]);
    
            // Cek jika tanggal panen sudah ada
            $panenExists = Panen::where('tanggalPanen', $request->tanggalPanen)->first();
            if ($panenExists) {
                // Tampilkan popup error jika tanggal sudah ada
                $this->gagalPopUp([
                    'Tanggal panen sudah ada dengan jumlah panen sebanyak ' . $panenExists->jumlahPanen . '. Harap gunakan tanggal lain.',
                ]);
                return redirect()->back()->withInput();
            }
    
            // Simpan data panen baru
            $panen = new Panen();
            $panen->jumlahPanen = $request->jumlahPanen;
            $panen->tanggalPanen = $request->tanggalPanen;
            $panen->save();
    
            // Tampilkan popup sukses
            $this->berhasilPopUp('Data panen berhasil disimpan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tampilkan popup error jika validasi gagal
            $this->gagalPopUp($e->validator->errors()->all());
            return redirect()->back()->withInput();
        }
    
        return redirect()->route('dashboard.karyawan.panen');
    }
    

    public function hapusPanen($id)
    {
        $panen = $this->ambilPanen($id);
    
        // Ambil seluruh data stok termasuk perubahan terkait panen ini
        $stok = Stok::all();
    
        // Simulasikan stok setelah menghapus data panen
        $stokSimulasi = $stok->reject(function ($item) use ($panen) {
            // Buang data stok terkait panen yang akan dihapus
            return $item->panen_id == $panen->id;
        })->sortBy('tanggalBerubah');
    
        // Hitung stok secara kronologis
        $stokTotal = 0;
        foreach ($stokSimulasi as $item) {
            $stokTotal += $item->jumlahPerubahan;
    
            // Cek jika stok menjadi negatif
            if ($stokTotal < 0) {
                return redirect()->back()->with('gagalDihapus', 
                    'Data tidak dapat dihapus karena menyebabkan stok menjadi negatif pada tanggal ' . 
                    Carbon::parse($item->tanggalBerubah)->format('d-m-Y') . 
                    ' dengan stok menjadi ' . $stokTotal . ' kg.'
                );
            }
        }
    
        // Jika validasi lolos, hapus panen
        $panen->delete();
    
        return redirect()->route('dashboard.karyawan.panen')->with('berhasilDihapus', 'Data panen berhasil dihapus');
    }
    

    public function ubahPanen($id)
    {
        $panen = $this->ambilPanen($id);
        return view('dashboard.karyawan.panen.halamanubahpanen', compact('panen'));
    }
    public function perbaruiDataPanen(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'jumlahPanen' => 'required|integer|min:0',
                'tanggalPanen' => 'required|date|before_or_equal:today',
            ], [
                'jumlahPanen.required' => 'Jumlah panen wajib diisi.',
                'jumlahPanen.integer' => 'Jumlah panen harus berupa angka.',
                'jumlahPanen.min' => 'Jumlah panen tidak boleh bernilai negatif.',
                'tanggalPanen.required' => 'Tanggal panen wajib diisi.',
                'tanggalPanen.date' => 'Tanggal panen harus berupa tanggal yang valid.',
                'tanggalPanen.before_or_equal' => 'Tanggal panen tidak boleh berada di masa depan.',
            ]);
    
            $panen = $this->ambilPanen($id);
    
            // Validasi jika ada tanggal yang sama (abaikan data yang sedang diubah)
            $panenExists = Panen::where('tanggalPanen', $request->tanggalPanen)
                ->where('id', '!=', $id)
                ->first();
    
            if ($panenExists) {
                // Tampilkan popup error jika tanggal sudah ada
                $this->gagalPopUp([
                    'Tanggal panen sudah ada dengan jumlah panen sebanyak ' . $panenExists->jumlahPanen . '. Harap gunakan tanggal lain.',
                ]);
                return redirect()->back()->withInput();
            }
    
            // Ambil semua perubahan stok (termasuk panen yang sedang diubah)
            $stok = Stok::where('id', '!=', $panen->stok->id)
                ->orWhere('panen_id', $id)
                ->get();
    
            // Simulasikan stok berdasarkan tanggal perubahan
            $stokSimulasi = $stok->map(function ($item) use ($request, $panen) {
                // Jika item adalah panen yang sedang diubah, gunakan tanggal dan jumlah baru
                if ($item->panen_id == $panen->id) {
                    $item->tanggalBerubah = $request->tanggalPanen;
                    $item->jumlahPerubahan = $request->jumlahPanen;
                }
                return $item;
            })->sortBy('tanggalBerubah'); // Urutkan stok berdasarkan tanggal
    
            // Hitung stok secara kronologis
            $stokTotal = 0;
            foreach ($stokSimulasi as $item) {
                // Pastikan tanggalBerubah adalah instance Carbon
                $tanggalBerubah = Carbon::parse($item->tanggalBerubah);
    
                $stokTotal += $item->jumlahPerubahan;
                if ($stokTotal < 0) {
                    // Tampilkan popup error jika stok menjadi negatif
                    $this->gagalPopUp([
                        'Perubahan tanggal menyebabkan stok menjadi negatif pada tanggal ' 
                        . $tanggalBerubah->format('d-m-Y') 
                        . ' dengan stok menjadi ' . $stokTotal . ' kg.',
                    ]);
                    return redirect()->back()->withInput();
                }
            }
    
            // Jika validasi lolos, update panen
            $panen->jumlahPanen = $request->jumlahPanen;
            $panen->tanggalPanen = $request->tanggalPanen;
            $panen->update();
    
            // Tampilkan popup sukses
            $this->berhasilPopUp('Data panen berhasil diperbarui!');
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tampilkan popup error jika validasi gagal
            $this->gagalPopUp($e->validator->errors()->all());
            return redirect()->back()->withInput();
        }
    
        return redirect()->route('dashboard.karyawan.panen');
    }
    
    
}
