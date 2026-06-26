<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// Import Model langsung di atas agar kode di dalam class lebih ringkas
use App\Models\Kost;
use App\Models\KostImage;
use App\Models\Transaksi;
use App\Models\User;

class PemilikController extends Controller
{
    /**
     * 1. DASHBOARD UTAMA PEMILIK
     * Menampilkan halaman ringkasan performa bisnis (Statistik & Grafik)
     */
    public function dashboard()
{
    $user = Auth::user();
    
    // 1. Mengambil data counter untuk widget statistika
    $totalKost = Kost::where('owner_id', $user->id)->count();
    
    $totalTransaksi = Transaksi::whereHas('penyewa.kost', function ($query) use ($user) {
        $query->where('owner_id', $user->id);
    })->count();

    // 2. AMBIL DATA KOST TERBARU (Sesuai variabel yang diminta di Blade Anda)
    // Mengambil 5 properti kost terbaru milik owner aktif
    $recentKosts = Kost::where('owner_id', $user->id)
                        ->with('images')
                        ->latest()
                        ->take(5)
                        ->get();

    // 3. Pastikan $recentKosts dimasukkan ke dalam fungsi compact()
    return view('pemilik.dashboard', compact('totalKost', 'totalTransaksi', 'recentKosts'));
}

    /**
     * 2. MANAJEMEN KELOLA KOST
     * Menampilkan semua daftar properti kost milik user
     */
    public function index()
    {
        $user = Auth::user();
        $kosts = Kost::where('owner_id', $user->id)->with('images')->get();
        return view('pemilik.kost.index', compact('kosts'));
    }

    public function create()
    {
        return view('pemilik.kost.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'main_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120'
        ]);

        $user = Auth::user();

        $kost = new Kost();
        $kost->title = $request->input('title');
        $kost->slug = Str::slug($kost->title) . '-' . time(); // Menggunakan helper Str yang sudah di-import
        $kost->address = $request->input('address');
        $kost->price = $request->input('price');
        $kost->owner_id = $user->id;
        $kost->contact_phone = $request->input('contact_phone', $request->input('contact_whatsapp', ''));
        $kost->contact_whatsapp = $request->input('contact_whatsapp', $request->input('contact_phone', ''));

        if ($request->hasFile('main_image')) {
            $kost->main_image = $this->compressAndStoreImage($request->file('main_image'));
        }

        $kost->save();

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $this->compressAndStoreImage($image);
                $kost->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('pemilik.kost.index')->with('success', 'Kost berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kost = Kost::where('id', $id)->where('owner_id', Auth::id())->with('images')->firstOrFail();
        return view('pemilik.kost.edit', compact('kost'));
    }

    public function update(Request $request, $id)
    {
        $kost = Kost::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();

        $request->validate([
            'title' => 'required|string|max:255',
            'address' => 'required|string',
            'price' => 'required|numeric',
            'main_image' => 'nullable|image|max:5120',
            'gallery_images.*' => 'nullable|image|max:5120'
        ]);

        $kost->title = $request->input('title');
        $kost->address = $request->input('address');
        $kost->price = $request->input('price');
        $kost->contact_phone = $request->input('contact_phone', $request->input('contact_whatsapp', $kost->contact_phone));
        $kost->contact_whatsapp = $request->input('contact_whatsapp', $request->input('contact_phone', $kost->contact_whatsapp));

        if ($request->hasFile('main_image')) {
            if ($kost->main_image) {
                Storage::disk('public')->delete($kost->main_image);
            }
            $kost->main_image = $this->compressAndStoreImage($request->file('main_image'));
        }

        $kost->save();

        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $image) {
                $path = $this->compressAndStoreImage($image);
                $kost->images()->create(['image_path' => $path]);
            }
        }

        return redirect()->route('pemilik.kost.index')->with('success', 'Kost berhasil diupdate.');
    }

    public function destroy($id)
    {
        $kost = Kost::where('id', $id)->where('owner_id', Auth::id())->firstOrFail();

        foreach ($kost->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        if ($kost->main_image) {
            Storage::disk('public')->delete($kost->main_image);
        }

        $kost->delete();

        return redirect()->route('pemilik.kost.index')->with('success', 'Kost berhasil dihapus.');
    }

    /**
     * 3. DATA TRANSAKSI
     * Menampilkan riwayat pembayaran sewa dari properti milik owner
     */
    public function transaksiIndex()
    {
        $user = Auth::user();

        $transaksis = Transaksi::whereHas('penyewa.kost', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->with(['penyewa', 'kamar'])->latest()->paginate(15);

        return view('pemilik.transaksi.index', compact('transaksis'));
    }

    /**
     * 4. DATA PENYEWA (PERBAIKAN BUG METHOD MISSING)
     * Menampilkan data pelanggan/penyewa yang menyewa di kost milik owner
     */
    public function penyewaIndex()
    {
        $user = Auth::user();

        // Mengambil data transaksi yang terikat dengan kost milik owner aktif
        $transaksis = Transaksi::whereHas('penyewa.kost', function ($query) use ($user) {
            $query->where('owner_id', $user->id);
        })->with(['penyewa'])->latest()->paginate(15);

        // Kirim data $transaksis ke halaman view
        return view('pemilik.penyewa.index', compact('transaksis'));
    }
 
    private function compressAndStoreImage($file)
    {
        $image = imagecreatefromstring(file_get_contents($file->getRealPath()));
        if (!$image) {
            return $file->store('uploads/kost', 'public');
        }

        $width = imagesx($image);
        $height = imagesy($image);
        $maxWidth = 1200;
        $maxHeight = 800;

        $ratio = min($maxWidth / $width, $maxHeight / $height, 1);
        $newWidth = (int) ($width * $ratio);
        $newHeight = (int) ($height * $ratio);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $filename = 'uploads/kost/' . uniqid() . '.jpg';
        ob_start();
        imagejpeg($newImage, null, 75);
        $imageData = ob_get_clean();

        Storage::disk('public')->put($filename, $imageData);

        imagedestroy($image);
        imagedestroy($newImage);

        return $filename;
    }
}