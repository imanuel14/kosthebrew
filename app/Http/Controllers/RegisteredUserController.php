<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisteredUserController extends Controller
{
    public function store(Request $request)
{
    // 1. Pastikan no_hp ada di dalam validasi
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed'],
        'role' => ['required', 'in:pencari,pemilik'],
        'no_hp' => ['required', 'string', 'max:15'], // <--- TAMBAHKAN INI
    ]);

    // 2. Masukkan no_hp agar ikut di-insert ke database
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'no_hp' => $request->no_hp, // <--- PASTIKAN BARIS INI ADA
    ]);

    // Proses login otomatis atau redirect setelahnya...
}
}
