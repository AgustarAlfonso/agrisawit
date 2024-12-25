<?php

namespace App\Observers;

use App\Models\Jadwal;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class JadwalObserver
{
    public function created(Jadwal $jadwal)
    {
        $this->logActivity('menambah', $jadwal);
    }

    public function updated(Jadwal $jadwal)
    {
        $this->logActivity('mengubah', $jadwal);
    }

    public function deleted(Jadwal $jadwal)
    {
        $this->logActivity('menghapus', $jadwal);
    }

    protected function logActivity($action, $jadwal)
    {
        if (Auth::check()) {
            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'activity_description' => "$action jadwal perawatan jenis '{$jadwal->jenisPerawatan}' pada tanggal '{$jadwal->tanggal}'",
            ]);
        }
    }
}
