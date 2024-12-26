<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class LogActivity
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $path = $request->path();
            $description = $this->mapRouteToDescription($path);

            ActivityLog::create([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'user_role' => Auth::user()->role,
                'activity_description' => $description,
            ]);
        }

        return $next($request);
    }

    private function mapRouteToDescription($path)
    {
        // Pemetaan path ke deskripsi aktivitas
        $menuDescriptions = [
            'dashboard/pemilik/akun' => 'akses akun',
            'dashboard/pemilik/index' => 'akses dashboard pemilik',
            'dashboard/pemilik/laporan' => 'akses laporan pemilik',
            'dashboard/karyawan/penjualan' => 'akses penjualan',
            'dashboard/karyawan/index' => 'akses dashboard karyawan',
            'dashboard/karyawan/stok' => 'akses stok',
            'dashboard/karyawan/panen' => 'akses panen',
            'dashboard/karyawan/jadwal' => 'akses jadwal',
            'dashboard/karyawan/laporan' => 'akses laporan karyawan',
            'dashboard/pemilik/log' => 'akses log ',
            // Tambahkan path lainnya jika perlu
        ];

        foreach ($menuDescriptions as $menuPath => $description) {
            if (str_contains($path, $menuPath)) {
                return $description;
            }
        }

        // Default jika tidak cocok
        return 'akses ' . $path;
    }
}
