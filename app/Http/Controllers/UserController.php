<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kost;
use App\Models\Penyewa;
use App\Models\Transaksi;
use App\Models\User;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Redirect admins to admin dashboard
        if (strtolower($user->role) === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // Pemilik (owner) has separate dashboard
        if (strtolower($user->role) === 'pemilik' || strtolower($user->role) === 'owner') {
            return redirect()->route('pemilik.dashboard');
        }

        // --- LOGIKA MOTIVASI (Hanya untuk Penyewa) ---
        $hari = \Carbon\Carbon::now()->translatedFormat('l');
        $motivasiList = [
            'Monday' => 'Senin semangat! Awal yang baru untuk mencapai target mingguanmu.',
            'Tuesday' => 'Selasa produktif! Fokus pada apa yang benar-benar penting hari ini.',
            'Wednesday' => 'Rabu ceria! Kamu sudah setengah jalan menuju akhir pekan.',
            'Thursday' => 'Kamis manis! Terus konsisten, hasil tidak akan mengkhianati usaha.',
            'Friday' => 'Jumat berkah! Selesaikan tugasmu dengan maksimal agar akhir pekan tenang.',
            'Saturday' => 'Sabtu santai! Waktunya isi ulang energi dan evaluasi diri.',
            'Sunday' => 'Minggu tenang! Istirahatlah, kamu layak mendapatkannya.'
        ];

        $kataMotivasi = $motivasiList[$hari] ?? 'Selamat beraktivitas!';

        // Default: penyewa dashboard
        return view('user.dashboard', compact('user', 'kataMotivasi', 'hari'));
    }

    public function pemilikDashboard()
    {
        $user = Auth::user();
        if (!$user)
            return redirect()->route('login');
        if (strtolower($user->role) !== 'pemilik' && strtolower($user->role) !== 'owner') {
            abort(403);
        }

        $totalKost = Kost::where('owner_id', $user->id)->count();

        $totalPenyewa = Penyewa::whereHas('kost', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->count();

        $totalTransaksi = Transaksi::whereHas('penyewa', function ($query) use ($user) {
            $query->whereHas('kost', function ($subQuery) use ($user) {
                $subQuery->where('owner_id', $user->id);
            });
        })->count();

        $recentKosts = Kost::where('owner_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('pemilik.dashboard', compact('user', 'totalKost', 'totalPenyewa', 'totalTransaksi', 'recentKosts'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'required|string',
        ]);

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data berhasil diperbarui!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Data berhasil dihapus!');
    }

    public function create()
    {
        $user = new User(); // Membuat instance baru untuk form create
        return view('admin.users.create', compact('user'));
    }
    public function show($id)
{
    // Mengambil data user berdasarkan ID
    $user = \App\Models\User::findOrFail($id);

    // Mengirim data ke view (sesuaikan dengan path view Anda)
    return view('admin.users.show', compact('user'));
}
}
