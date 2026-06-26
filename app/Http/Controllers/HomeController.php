<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use App\Models\Message;
use App\Models\User;
class HomeController extends Controller
{
    public function index()
    {

        // 1. Ambil daftar kota unik dari tabel kost
        $cities = Kost::select('city')->distinct()->pluck('city');

        $featuredKosts = Kost::with('profile')->where('is_active')->take(4)->get();


        // 2. Ambil kategori unik (ac, kipas, homestay)
        $categories = Kost::select('category')->distinct()->pluck('category');

        // 4. Ambil Kost TERBARU (latestKosts)
        $latestKosts = Kost::where('is_active', 1)
            ->latest() // Mengurutkan dari yang terbaru (created_at)
            ->take(6)
            ->get();

        $kosts = Kost::where('is_active', true)->take(6)->get();
        // 4. KIRIM SEMUA VARIABEL KE VIEW
        return view('home', compact('cities', 'categories', 'featuredKosts', 'latestKosts'));
    }

    public function myBookings()
    {
        // Sementara return view atau abort jika belum ada halamannya
        return view('bookings.index');
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContactMessage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|numeric|digits_between:9,15', // Validasi nomor HP/WA
            'email' => 'nullable|email|max:255',               // Nullable berarti tidak wajib
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'name' => $validated['name'],
            'whatsapp' => $validated['whatsapp'],
            'email' => $validated['email'], // Akan bernilai null jika dikosongkan
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Pesan Anda berhasil dikirim!');
    }
}
