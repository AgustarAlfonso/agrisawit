<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Akun extends Authenticatable
{
    use Notifiable;

    protected $table = 'akun'; // Nama tabel yang digunakan
    protected $fillable = [
        'username', 'password', 'name', 'role' // Sesuaikan dengan kolom di tabel `akun`
    ];
}
