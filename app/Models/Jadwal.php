<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'Jadwal';

    // Tentukan atribut mana yang dapat diisi (mass assignable)
    protected $fillable = [
        'jenisPerawatan',
        'tanggal',
        'status',
    ];
}
