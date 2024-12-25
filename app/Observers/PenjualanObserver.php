<?php

namespace App\Observers;

use App\Models\Penjualan;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PenjualanObserver
{
    public function created(Penjualan $penjualan)
    {
        $this->logActivity('menambah', $penjualan);
    }

    public function updated(Penjualan $penjualan)
    {
        $this->logActivity('mengubah', $penjualan);
    }

    public function deleted(Penjualan $penjualan)
    {
        $this->logActivity('menghapus', $penjualan);
    }

    protected function logActivity($action, $penjualan)
    {
        if (Auth::check()) {
            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'activity_description' => "$action penjualan sebanyak {$penjualan->jumlahTerjual} unit dengan total harga Rp. {$penjualan->totalHarga}",
            ]);
        }
    }
}
