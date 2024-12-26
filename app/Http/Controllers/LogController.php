<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function tampilLog()
    {
        // Grab the logs, paginate 'em like a pro!
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(20);

        // Send the logs to the view, 'cause sharing is caring.
        return view('dashboard.pemilik.log.tampil', compact('logs'));
    }
}
