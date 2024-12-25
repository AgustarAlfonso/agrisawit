<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LockScreenProtection
{
    public function handle(Request $request, Closure $next)
    {
        // Periksa apakah session 'locked' ada
        if (session('locked')) {
            return redirect()->route('lockscreen'); // Arahkan ke halaman lockscreen jika terkunci
        }

        return $next($request);
    }
}
