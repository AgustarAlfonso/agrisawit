<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JamKerjaMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $now = Carbon::now();

        if ($user->role == 'karyawan') {
            $start = Carbon::createFromTime(7, 0, 0);  // Jam 7 pagi
            $end = Carbon::createFromTime(19, 0, 0);   // Jam 7 malam

            if ($now->lessThan($start) || $now->greaterThan($end)) {
                return response()->view('errors.jam-kerja');
            }
        }

        return $next($request);
    }
}
