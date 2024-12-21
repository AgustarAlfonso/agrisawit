<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function tampilStok()
    {
        $stok = Stok::orderBy('tanggalBerubah', 'desc')->paginate(5);  // Menampilkan 10 item per halaman
        return view('dashboard.karyawan.stok.tampil', compact('stok'));
    }

    
}
