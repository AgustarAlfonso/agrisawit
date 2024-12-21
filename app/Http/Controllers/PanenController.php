<?php

namespace App\Http\Controllers;

use App\Models\Panen;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PanenController extends Controller
{
    public function ambilSemuaPanen()
    {
        return Panen::orderBy('tanggalPanen', 'desc')->paginate(5);
    }

    public function ambilPanen($id)
    {
        return Panen::findOrFail($id);
    }

    public function tampilPanen()
    {
        $panens = $this->ambilSemuaPanen();
        return view('dashboard.karyawan.panen.tampil', compact('panens'));
    }

    public function tambahPanen()
    {
        return view('dashboard.karyawan.panen.tambah');
    }

    public function simpanDatapanen(Request $request)
    {
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

        $panenExists = Panen::where('tanggalPanen', $request->tanggalPanen)->first();
        if ($panenExists) {
            return redirect()->back()->withErrors([
                'tanggalPanen' => 'Tanggal panen sudah ada dengan jumlah panen sebanyak ' . $panenExists->jumlahPanen . '. Harap gunakan tanggal lain.',
            ])->withInput();
        }

        $panen = new Panen();
        $panen->jumlahPanen = $request->jumlahPanen;
        $panen->tanggalPanen = $request->tanggalPanen;
        $panen->save();

        return redirect()->route('dashboard.karyawan.panen')->with('berhasilDibuat', 'Data panen berhasil disimpan!');
    }

    public function hapusPanen($id)
    {
        $panen = $this->ambilPanen($id);
        $stokSaatIni = Stok::sum('jumlahPerubahan');

        if ($stokSaatIni - $panen->jumlahPanen < 0) {
            return redirect()->back()->with('gagalDihapus', 'Data tidak dapat dihapus karena stok tidak bisa negatif.');
        }

        $panen->delete();

        return redirect()->route('dashboard.karyawan.panen')->with('berhasilDihapus', 'Data panen berhasil dihapus');
    }

    public function ubahPanen($id)
    {
        $panen = $this->ambilPanen($id);
        return view('dashboard.karyawan.panen.ubah', compact('panen'));
    }

    public function perbaruiDataPanen(Request $request, $id)
    {
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

        // Validasi jika ada tanggal yang sama (abaikan data yang sedang diubah)
        $panenExists = Panen::where('tanggalPanen', $request->tanggalPanen)
            ->where('id', '!=', $id)
            ->first();
        if ($panenExists) {
            return redirect()->back()->withErrors([
                'tanggalPanen' => 'Tanggal panen sudah ada dengan jumlah panen sebanyak ' . $panenExists->jumlahPanen . '. Harap gunakan tanggal lain.',
            ])->withInput();
        }

        // Ambil data panen saat ini
        $panen = $this->ambilPanen($id);
        $stokSaatIni = Stok::sum('jumlahPerubahan'); // Menghitung total stok saat ini

        // Validasi jumlah panen agar stok tidak negatif
        $selisihPanen = $request->jumlahPanen - $panen->jumlahPanen; // Perubahan jumlah panen
        if ($stokSaatIni + $selisihPanen < 0) {
            return redirect()->back()->withErrors([
                'jumlahPanen' => 'Perubahan jumlah panen akan menyebabkan stok menjadi negatif.',
            ])->withInput();
        }

        // Mengupdate data panen
        $panen->jumlahPanen = $request->jumlahPanen;
        $panen->tanggalPanen = $request->tanggalPanen;
        $panen->update();

        return redirect()->route('dashboard.karyawan.panen')->with('berhasilDibuat', 'Data panen berhasil diperbarui!');
    }
}
