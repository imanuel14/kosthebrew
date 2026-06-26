<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Import Model User agar lebih rapi

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile');
    }

    public function update(Request $request)
    {
        // Menggunakan User::findOrFail agar jika user tidak ditemukan langsung error 404
        $user = User::findOrFail(Auth::id());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'ktp_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $data = $request->only(['name', 'phone', 'address']);

        // Logika Update File KTP
        if ($request->hasFile('ktp_image')) {
            // 1. Cek apakah ada file lama, dan apakah file tersebut benar ada di disk
            if ($user->ktp_path && Storage::disk('public')->exists($user->ktp_path)) {
                Storage::disk('public')->delete($user->ktp_path);
            }
            
            // 2. Simpan file baru dan ambil path-nya
            $path = $request->file('ktp_image')->store('ktp', 'public');
            $data['ktp_path'] = $path;
        }

        // 3. Update data user
        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}