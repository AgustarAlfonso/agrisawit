<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;

class LogLoginActivity
{
    public function handle(Login $event)
    {
        $user = $event->user;

        ActivityLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_role' => $user->role,
            'activity_description' => 'Berhasil login',
        ]);
    }
}

