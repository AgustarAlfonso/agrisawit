<?php

namespace App\Observers;

use App\Models\Panen;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class PanenObserver
{
    public function created(Panen $panen)
    {
        $this->logActivity('created', $panen);
    }

    public function updated(Panen $panen)
    {
        $this->logActivity('updated', $panen);
    }

    public function deleted(Panen $panen)
    {
        $this->logActivity('deleted', $panen);
    }

    protected function logActivity($action, $panen)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_role' => Auth::user()->role,
                'activity_description' => "User $action a Panen record: " . json_encode($panen),
            ]);
        }
    }
}