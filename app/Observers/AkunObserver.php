<?php

namespace App\Observers;

use App\Models\Akun;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AkunObserver
{
    public function created(Akun $akun)
    {
        $this->logActivity('menambah', $akun);
    }

    public function updated(Akun $akun)
    {
        $this->logActivity('mengubah', $akun);
    }

    public function deleted(Akun $akun)
    {
        $this->logActivity('menghapus', $akun);
    }

    protected function logActivity($action, $akun)
    {
        if (Auth::check()) {
            $user = Auth::user();
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'activity_description' => "$action akun dengan username '{$akun->username}' dan role '{$akun->role}'",
            ]);
        }
    }
}
