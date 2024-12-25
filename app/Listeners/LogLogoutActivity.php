<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;

class LogLogoutActivity
{
    public function handle(Logout $event)
    {
        $user = $event->user;

        if ($user) {
            ActivityLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role,
                'activity_description' => 'Berhasil logout',
            ]);
        }
    }
}

