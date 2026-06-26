<?php

namespace App\Http\Controllers;

use App\Models\Kost;
use App\Models\KostImage;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Menampilkan Dashboard Admin dengan Statistik
     */
    public function dashboard()
    {
        $totalKost = Kost::count();
        // Menggunakan role 'pencari' sesuai dengan sistem registrasi terbaru Anda
        $totalPenyewa = User::where('role', 'pencari')->count();
        $totalTransaksi = Transaksi::count();

        // Statistik pesan belum dibaca sebagai indikator notifikasi
        $unreadMessages = Message::where('is_read', false)->count();
        $recentKosts = Kost::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalKost',
            'totalPenyewa',
            'totalTransaksi',
            'recentKosts',
            'unreadMessages'
        ));
    }

    /**
     * ==========================================
     * MANAJEMEN AKUN USER / PENDAFTAR
     * ==========================================
     */

    /**
     * Daftar Semua Akun Pengguna (Pencari & Pemilik)
     */
    public function userIndex(Request $request)
    {

        $user = User::where('role', '')->first();
        // Mengecualikan role admin agar akun admin tidak terkelola/terhapus di sini
        $query = User::where('role', '!=', 'admin');

        // Fitur Pencarian berdasarkan Nama, Email, atau No HP
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%');
            });
        }

        // Fitur Filter Berdasarkan Jenis Role (pencari / pemilik)
        if ($request->has('role') && $request->role != '') {
            $query->where('role', $request->role);
        }

        // Ambil data terbaru dengan paginasi 10 data per halaman
        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }
    public function userEdit($id)
    {
        $user = User::where('role', '!=', 'admin')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Melihat Detail Profil Akun Pengguna
     */
    public function userShow($id)
    {
        // Mengambil user dengan relasi penyewa dan payments
        $user = User::with(['penyewa.payments.kamar.kost'])
            ->where('role', '!=', 'admin')
            ->findOrFail($id);

        return view('admin.users.show', compact('user'));
    }

    /**
     * Menghapus Akun Pengguna Secara Permanen
     */
    public function userDestroy($id)
    {
        $user = User::where('role', '!=', 'admin')->findOrFail($id);
        $namaUser = $user->name;

        // Cegah Admin menghapus dirinya sendiri jika tidak sengaja memanggil rute ini
        if (auth()->id() == $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun milik "' . $namaUser . '" berhasil dihapus permanen.');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,pemilik,admin',
            'new_password' => 'nullable|min:6',
        ]);

        $data = $request->only(['name', 'email', 'role']);

        // Jika admin memasukkan password baru, kita update
        if ($request->filled('new_password')) {
            $data['password'] = \Illuminate\Support\Facades\Hash::make($request->new_password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function userCreate()
    {
        $user = new User();
        return view('admin.users.create', compact('user'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:user,pemilik,admin',
            'password' => 'required|min:6',
        ]);

        $data = $request->only(['name', 'email', 'role']);
        $data['password'] = \Illuminate\Support\Facades\Hash::make($request->password);

        User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna baru berhasil dibuat.');
    }



    /**
     * ==========================================
     * MANAJEMEN PESAN / CONTACT MASUK
     * ==========================================
     */

    /**
     * Daftar Semua Pesan Masuk dari Pengunjung
     */
    public function messageIndex()
    {
        $messages = Message::latest()->paginate(10);
        return view('admin.messages.index', compact('messages'));
    }

    /**
     * Detail Pesan Masuk & Otomatis Mengubah Status Menjadi "Sudah Dibaca"
     */
    public function messageShow($id)
    {
        $message = Message::findOrFail($id);

        if (!$message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', compact('message'));
    }

    /**
     * Menghapus Pesan Masuk
     */
    public function messageDestroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus permanen.');
    }

    /**
     * ==========================================
     * MANAJEMEN DATA KOST GLOBAL
     * ==========================================
     */

    /**
     * Tampilkan Semua Daftar Properti Kost
     */
    public function kostIndex()
    {
        $kosts = Kost::with('owner')->latest()->paginate(10);
        return view('admin.kost.index', compact('kosts'));
    }

    /**
     * Form Tambah Kost Baru
     */
    public function kostCreate()
    {
        return view('admin.kost.create');
    }

    /**
     * Detail Info Kost (Perbaikan Parameter ID)
     */
    public function kostShow($id)
    {
        $kost = Kost::with('images','kamar')->findOrFail($id);
        // $item = $kost->facilities()->get(); // Ambil fasilitas terkait kost ini

        return view('admin.kost.show', compact('kost'));
    }

    /**
     * Simpan Data Kost Baru ke Database
     */
    public function kostStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required',
            'city' => 'required|string',
            'price_monthly' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'address' => 'required',
            'room_total' => 'required|numeric',
            'contact_phone' => 'nullable|string',
            'contact_whatsapp' => 'nullable|string',
        ]);

        $kost = new Kost();
        $kost->name = $request->name;
        $kost->slug = Str::slug($request->name) . '-' . time();
        $kost->category = $request->category;
        $kost->price_monthly = $request->price_monthly;
        $kost->address = $request->address;
        $kost->city = $request->city;
        $kost->district = $request->district;
        $kost->description = $request->description;
        $kost->owner_id = auth()->id(); // Admin bertindak sebagai owner jika menginput sendiri

        if ($request->hasFile('image')) {
            $imagePath = $this->compressAndStoreImage($request->file('image'), 'kosts', 75);
            $kost->image = $imagePath;
        }

        $kost->contact_phone = $request->input('contact_phone', $request->input('contact_whatsapp', ''));
        $kost->contact_whatsapp = $request->input('contact_whatsapp', $request->input('contact_phone', ''));
        $kost->room_total = $request->room_total ?? 1;
        $kost->room_available = $request->room_total ?? 1;

        $kost->is_featured = $request->has('is_featured') ? 1 : 0;
        $kost->is_active = 1;

        $kost->save();

        if ($request->hasFile('gallery_images')) {
            $this->saveKostGalleryImages($kost, $request->file('gallery_images'));
        }

        return redirect()->route('admin.kost.index')->with('success', 'Properti Kost berhasil ditambahkan.');
    }

    /**
     * Mengunggah Tambahan Gambar ke Galeri Kost
     */
    public function kostUploadImages(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        $request->validate([
            'gallery_images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gallery_images')) {
            $this->saveKostGalleryImages($kost, $request->file('gallery_images'));
        }

        return back()->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    /**
     * Menghapus Foto Tertentu dari Galeri Kost
     */
    public function kostDeleteImage($kostId, $imageId)
    {
        $kost = Kost::findOrFail($kostId);
        $image = KostImage::where('kost_id', $kost->id)->findOrFail($imageId);

        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    /**
     * Halaman Edit Data Kost
     */
    public function kostEdit($id)
    {
        $kost = Kost::findOrFail($id);
        return view('admin.kost.edit', compact('kost'));
    }

    /**
     * Memperbarui Data Properti Kost
     */
    public function kostUpdate(Request $request, $id)
    {
        $kost = Kost::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'category' => 'required|in:ac,kipas,homestay',
            'price_monthly' => 'required|numeric|min:0',
            'room_total' => 'required|integer|min:1',
            'room_available' => 'required|integer|min:0',
            'contact_whatsapp' => 'required|string|max:20',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',

        ]);

        try {
            $validated['is_active'] = $request->has('is_active') ? 1 : 0;
            $validated['is_featured'] = $request->has('is_featured') ? 1 : 0;
            $validated['contact_phone'] = $request->contact_whatsapp;
            

            if ($kost->name !== $request->name) {
                $validated['slug'] = Str::slug($request->name) . '-' . time();
            }

            if ($request->hasFile('image')) {
                if ($kost->image && Storage::disk('public')->exists($kost->image)) {
                    Storage::disk('public')->delete($kost->image);
                }
                $validated['image'] = $this->compressAndStoreImage($request->file('image'), 'kosts', 75);
            }

            $kost->update($validated);

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    $galleryPath = $this->compressAndStoreImage($file, 'kosts/gallery', 75);
                    $kost->images()->create(['image_path' => $galleryPath]);
                }
            }

            return redirect()->route('admin.kost.index')->with('success', 'Data kost berhasil diperbarui.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Gagal memperbarui data: ' . $e->getMessage()]);
        }
    }

    /**
     * Menghapus Properti Kost Beserta Berkas Gambar
     */
    public function kostDestroy($id)
    {
        $kost = Kost::findOrFail($id);
        $namaKost = $kost->name;

        // Hapus file gambar utama dari penyimpanan
        if ($kost->image && Storage::disk('public')->exists($kost->image)) {
            Storage::disk('public')->delete($kost->image);
        }

        // Hapus semua berkas gambar yang ada di galeri kost ini
        foreach ($kost->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }

        // Jika Anda memiliki relasi kamar, hapus datanya terlebih dahulu
        if (method_exists($kost, 'kamar')) {
            $kost->kamar()->delete();
        }

        $kost->delete();

        return redirect()->route('admin.kost.index')->with('success', 'Kost "' . $namaKost . '" telah dihapus permanen.');
    }

    /**
     * Tampilkan Semua Log Transaksi Booking
     */
    public function transaksiIndex()
    {
        $transaksis = Transaksi::with(['penyewa', 'kamar'])->latest()->paginate(15);
        return view('admin.transaksi.index', compact('transaksis'));
    }

    /**
     * ==========================================
     * HELPER METHODS (PROSES GAMBAR)
     * ==========================================
     */

    private function saveKostGalleryImages(Kost $kost, array $files): array
    {
        $paths = [];
        foreach ($files as $file) {
            if (!$file->isValid()) {
                continue;
            }
            $path = $this->compressAndStoreImage($file, 'kosts/gallery', 75);
            $kost->images()->create(['image_path' => $path]);
            $paths[] = $path;
        }
        return $paths;
    }

    private function compressAndStoreImage(UploadedFile $file, string $directory = 'kosts', int $quality = 75): string
    {
        $extension = strtolower($file->extension());
        $validExtensions = ['jpeg', 'jpg', 'png'];

        if (!in_array($extension, $validExtensions)) {
            return $file->store($directory, 'public');
        }

        $path = trim($directory, '/') . '/' . $file->hashName();
        $fullPath = Storage::disk('public')->path($path);

        // Buat folder tujuan jika belum tersedia
        $fullDirectoryPath = dirname($fullPath);
        if (!file_exists($fullDirectoryPath)) {
            mkdir($fullDirectoryPath, 0755, true);
        }

        $imageInfo = getimagesize($file->path());

        if (!$imageInfo) {
            return $file->store($directory, 'public');
        }

        [$width, $height, $type] = $imageInfo;
        $maxWidth = 1200;
        $maxHeight = 1200;
        $ratio = min(1, $maxWidth / $width, $maxHeight / $height);
        $newWidth = (int) max(1, round($width * $ratio));
        $newHeight = (int) max(1, round($height * $ratio));

        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($file->path());
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($file->path());
                break;
            default:
                return $file->store($directory, 'public');
        }

        $destination = imagecreatetruecolor($newWidth, $newHeight);

        if ($type === IMAGETYPE_PNG) {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 0, 0, 0, 127);
            imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
        }

        imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        if ($type === IMAGETYPE_JPEG) {
            imagejpeg($destination, $fullPath, $quality);
        } else {
            $pngCompression = (int) round((100 - $quality) / 10);
            imagepng($destination, $fullPath, max(0, min(9, $pngCompression)));
        }

        imagedestroy($source);
        imagedestroy($destination);

        return $path;
    }
}