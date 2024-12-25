<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        session()->forget('unlocked'); // Menghapus session unlocked
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function lockScreen()
    {
        session(['locked' => true]); // Menandakan bahwa layar terkunci
        return view('lockscreen'); // tampilkan halaman lock screen
    }
    
    public function unlockScreen(Request $request)
    {
        $user = Auth::user();
    
        if (Hash::check($request->password, $user->password)) {
            // Memeriksa role dan mengarahkan pengguna ke dashboard yang sesuai
            if ($user->role == 'karyawan') {
                session()->forget('locked'); // Menghapus session lock screen                return redirect()->route('dashboard.karyawan.index'); // halaman dashboard untuk karyawan
            } elseif ($user->role == 'pemilik') {
                session()->forget('locked'); // Menghapus session lock screen                return redirect()->route('dashboard.karyawan.index'); // halaman dashboard untuk karyawan
                return redirect()->route('dashboard.pemilik.index'); // halaman dashboard untuk pemilik
            }
        }
    
        return back()->withErrors(['password' => 'Password salah.']); // kembalikan dengan error jika password salah
    }

}

?>