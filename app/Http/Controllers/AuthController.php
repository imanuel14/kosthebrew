<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ActivityLog;


class AuthController extends Controller
{
    public function showLogin() 
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate(rules: [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(credentials: $credentials)) {
            $request->session()->regenerate();
            
            $role = strtolower(Auth::user()->role);

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'pemilik') {
                return redirect()->route('pemilik.dashboard');
            }
            
            // Default untuk pencari / penyewa -> arahkan ke dashboard pengguna
            return redirect()->route('user.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->only('email'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // PERBAIKAN: role disesuaikan dengan value input select option di HTML Anda (pencari, pemilik)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'required|string|max:15',
            'role' => 'required|in:pencari,pemilik' 
        ]);

        // Data tersimpan di sini (OTOMATIS MASUK & BISA DILIHAT DI HALAMAN ADMIN)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'role' => $request->role,
        ]);

        /* | Alur Pilihan:
        | Jika ingin user LANGSUNG LOGIN otomatis setelah daftar, biarkan kode ini aktif:
        | Auth::login($user);
        | return redirect()->route('home')->with('success', 'Registrasi berhasil!');
        */

        // Alur Rekomendasi: Data masuk ke DB/Admin, tapi user diminta login manual dulu
        return redirect()->route('login')->with('success', 'Akun pendaftar berhasil dibuat! Silakan masuk menggunakan akun Anda.');
    }

    public function logout(Request $request)
    {
        // Pastikan method tap() tersedia di model ActivityLog Anda
        if (class_exists('App\Models\ActivityLog') && method_exists('App\Models\ActivityLog', 'tap')) {
            ActivityLog::tap('Logged out');
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Berhasil keluar dari sistem.');
    }
}