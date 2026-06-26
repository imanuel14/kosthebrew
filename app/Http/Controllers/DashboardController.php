<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Kost;
use App\Models\User;


class DashboardController extends Controller
{
    //
    public function index()
    {
        $data['totalKost'] = Kost::count();
        $data['totalPenyewa'] = User::where('role', 'user')->count();
        $data['totalTransaksi'] = 0; // Sesuaikan dengan model transaksi Anda
        $data['recentKosts'] = Kost::latest()->take(5)->get();
        // AMBIL DATA LOG TERBARU (Maksimal 5 baris terakhir)
        $data['activityLogs'] = ActivityLog::with('user')->latest()->take(5)->get();
        return view('backend.layout.main', $data);
    }

    public function dashboard()
    {
        return view('backend.content.dashboard');

    }
    public function profil()
    {
        return view('backend.content.profil');
    }

}
