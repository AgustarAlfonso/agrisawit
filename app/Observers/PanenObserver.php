<?php

namespace App\Observers;

use App\Models\Panen;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PanenObserver
{
    public function created(Panen $panen)
    {
        $this->logActivity('menambah', $panen);
    }

    public function updated(Panen $panen)
    {
        $this->logActivity('mengubah', $panen);
    }

    public function deleted(Panen $panen)
    {
        $this->logActivity('menghapus', $panen);
    }

    protected function logActivity($action, $panen)
    {
        if (Auth::check()) {
            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'activity_description' => "$action panen seberat {$panen->jumlahPanen} kg",
            ]);
        }
    }
}
