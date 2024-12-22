<?php

namespace App\Http\Controllers;

use App\Models\Stok;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function ambilSemuaStok()
    {
        return Stok::orderBy('tanggalBerubah', 'desc')->paginate(5);
    }
    
    public function tampilStok()
    {
        $stok = $this->ambilSemuaStok();  // Memanggil fungsi ambilSemuaStok()
        return view('dashboard.karyawan.stok.tampil', compact('stok'));
    }
    
    
}
