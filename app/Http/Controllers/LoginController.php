<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function validasiAkun(Request $request)
    {
        $maxAttempts = 3; // Maximum attempts
        $lockoutTime = 30; // Lockout duration in seconds
        $credentials = $request->only('username', 'password');

        if (Session::has('lockout_time') && time() < Session::get('lockout_time')) {
            $remainingTime = Session::get('lockout_time') - time();
            return response()->json([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login.',
                'remainingTime' => $remainingTime
            ]);
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            Session::forget('login_attempts');
            Session::forget('lockout_time');

            $user = Auth::user();
            if ($user->role === 'pemilik') {
                return response()->json(['status' => 'success', 'redirect' => route('dashboard.pemilik.index')]);
            } elseif ($user->role === 'karyawan') {
                return response()->json(['status' => 'success', 'redirect' => route('dashboard.karyawan.index')]);
            }

            Auth::logout();
            return response()->json(['status' => 'error', 'message' => 'Role tidak valid.']);
        }

        $attempts = Session::get('login_attempts', 0) + 1;
        Session::put('login_attempts', $attempts);

        if ($attempts >= $maxAttempts) {
            Session::put('lockout_time', time() + $lockoutTime);
            return response()->json([
                'status' => 'error',
                'message' => 'Terlalu banyak percobaan login.',
                'remainingTime' => $lockoutTime
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => "Username atau Password salah. Percobaan tersisa: " . ($maxAttempts - $attempts)
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

?>