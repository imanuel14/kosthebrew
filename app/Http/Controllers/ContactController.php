<?php

// app/Http/Controllers/ContactController.php
namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi input dari halaman publik
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Simpan ke database
        Message::create($validated);

        // 3. Kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim! Admin kami akan segera menghubungi Anda.');
    }
}