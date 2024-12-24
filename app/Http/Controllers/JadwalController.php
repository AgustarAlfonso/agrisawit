<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    // Fungsi untuk mengambil semua jadwal
    public function ambilSemuaJadwal($perPage = 5)
    {
        return Jadwal::orderBy('tanggal', 'desc')->paginate($perPage);
    }

    private function berhasilPopUp($pesan)
    {
        session()->flash('berhasil', $pesan);
    }
    
    private function gagalPopUp($errors)
    {
        session()->flash('gagal', $errors->all());
    }
    

    // Fungsi untuk mengambil jadwal berdasarkan ID
    public function ambilJadwal($id)
    {
        return Jadwal::findOrFail($id);
    }

    public function tampilJadwal()
    {
        $jadwals = $this->ambilSemuaJadwal();
        $upcomingJadwals = Jadwal::where('status', 'pending')
                                 ->whereBetween('tanggal', [Carbon::now(), Carbon::now()->addDays(7)])
                                 ->get();
    
        return view('dashboard.karyawan.jadwal.tampil', compact('jadwals', 'upcomingJadwals'));
    }

    public function tambahJadwal()
    {
        return view('dashboard.karyawan.jadwal.tambah');
    }

    public function simpanDataJadwal(Request $request)
    {
        try{
            $request->validate([
                'jenisPerawatan' => 'required|string|max:255',
                'tanggal' => 'required|date|after_or_equal:' . Carbon::now()->toDateString(),
            ], [
                'jenisPerawatan.required' => 'Jenis perawatan harus diisi.',
                'jenisPerawatan.max' => 'Jenis perawatan maksimal 255 karakter.',
                'tanggal.required' => 'Tanggal harus diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'tanggal.after_or_equal' => 'Tanggal tidak boleh di masa lalu.',
            ]);
        
            $jadwal = new Jadwal();
            $jadwal->jenisPerawatan = $request->jenisPerawatan;
            $jadwal->tanggal = $request->tanggal;
            $jadwal->status = 'Pending';
            $jadwal->save();

            $this->berhasilPopUp('Jadwal berhasil disimpan!');

        } catch(\Illuminate\Validation\ValidationException $e){
            $this->gagalPopUp($e->validator->errors());
            return redirect()->back()->withInput();
        }

    
        return redirect()->route('dashboard.karyawan.jadwal');
    }

    public function hapusJadwal($id)
    {
        // Menggunakan ambilJadwal untuk mendapatkan jadwal berdasarkan ID
        $jadwal = $this->ambilJadwal($id);
        $jadwal->delete();
    
        return redirect()->route('dashboard.karyawan.jadwal')->with('berhasilDihapus', 'Jadwal berhasil dihapus');
    }

    public function ubahJadwal($id)
    {
        // Menggunakan ambilJadwal untuk mendapatkan jadwal berdasarkan ID
        $jadwal = $this->ambilJadwal($id);
        return view('dashboard.karyawan.jadwal.ubah', compact('jadwal'));
    }

    public function perbaruiDataJadwal(Request $request, $id)
    {
        try{

            $request->validate([
                'jenisPerawatan' => 'required|string|max:255',
                'status' => 'required|string',
            ], [
                'jenisPerawatan.required' => 'Jenis perawatan harus diisi.',
                'jenisPerawatan.max' => 'Jenis perawatan maksimal 255 karakter.',
                'tanggal.required' => 'Tanggal harus diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'status.required' => 'Status harus diisi.',
            ]);
    
            // Menggunakan ambilJadwal untuk mendapatkan jadwal berdasarkan ID
            $jadwal = $this->ambilJadwal($id);
            $jadwal->status = $request->status;
            $jadwal->update();

            $this->berhasilPopUp('Jadwal berhasil diperbarui!');

        } catch(\Illuminate\Validation\ValidationException $e){
            $this->gagalPopUp($e->validator->errors());
            return redirect()->back()->withInput();
        }

       

        return redirect()->route('dashboard.karyawan.jadwal');    
    }
}

    

