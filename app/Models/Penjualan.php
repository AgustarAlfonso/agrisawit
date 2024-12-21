<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'Penjualan';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'jumlahTerjual',
        'totalHarga',
        'tanggalPenjualan',
    ];

    /**
     * Casting atribut ke tipe data tertentu.
     */
    protected $casts = [
        'totalHarga' => 'decimal:2',
    ];

    

}
