<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kost;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\KostImage; // Tambahkan ini jika dibutuhkan di controller
use App\Models\Testimonial;

class KostController extends Controller
{
    public function welcome()
    {
        $testimonials = Testimonial::latest()->get();

        return view('home', compact('testimonials'));
    }

    /**
     * Halaman KAMAR (Semua Kamar + Filter)
     */
    public function index(Request $request)
    {
        // 1. Inisialisasi query untuk pencarian
        $query = Kost::where('is_active', 1);

        // 2. Logika Filter Pencarian
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('city', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category')) {
            // Asumsi kategori difilter berdasarkan kolom tertentu di tabel kost atau kamar
            $query->where('category', $request->category);
        }

        // 3. Ambil data untuk komponen View
        $cities = Kost::distinct()->pluck('city');

        // Mengambil daftar fasilitas unik dari kolom 'fasilitas' di model Kamar
        // Karena kolom 'fasilitas' Anda di model Kamar, kita ambil dari sana
        $facilities = \App\Models\Fasilitas::all();

        $kosts = $query->paginate(9);

        $featuredKosts = Kost::where('is_active', 1)->latest()->take(4)->get();
        $categories = ['ac', 'kipas', 'homestay'];

        return view('kost.index', compact(
            'cities',
            'kosts',
            'featuredKosts',
            'categories',
            'facilities'
        ));
    }

    /**
     * Detail Kamar
     */
    public function show($id) // Ganti $slug jadi $id jika ingin pakai angka
    {
        $kost = Kost::where('id', $id)
            ->where('is_active', true)
            ->with(['kamar', 'facilities', 'images']) // Tambahkan 'images' di sini
            ->firstOrFail();

        $relatedKosts = Kost::where('city', $kost->city)
            ->where('id', '!=', $kost->id)
            ->where('is_active', true)
            ->take(3)
            ->get();

        return view('kost.show', compact('kost', 'relatedKosts'));
    }
    public function category($category)
    {
        $kosts = Kost::with('profile')
            ->where('kategori', $category)
            ->where('status', 'active')
            ->paginate(12);

        return view('kost.category', compact('kosts', 'category'));
    }

    public function destroy($id)
    {
        $kost = Kost::findOrFail($id);
        $kost->delete();

        // Sangat penting untuk redirect kembali ke halaman index
        return redirect()->route('admin.kost.index')->with('success', 'Data berhasil dihapus');
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:ac,kipas,homestay',
            'city' => 'required|string',
            'district' => 'required|string',
            'owner_id' => 'required',
            'price_monthly' => 'required|numeric|min:0',
            'room_total' => 'required|integer|min:1',
            'room_available' => 'required|integer|min:0',
            'contact_phone' => 'nullable|string',
            'contact_whatsapp' => 'nullable|string',
            'address' => 'required|string',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'gallery_images.*' => 'nullable|image|max:2048',
            'bathroom_facilities' => 'nullable|array',
            'general_facilities' => 'nullable|array',
            'parking_facilities' => 'nullable|array',
            'room_rules' => 'nullable|array',
            'special_rules' => 'nullable|array',
            'nearby_places' => 'nullable|array',
            'rental_period' => 'required|in:monthly,3_months,6_months,yearly',
            'is_occupied' => 'nullable|boolean', // nullable karena jika tidak dicentang tidak dikirim
    ]);

        try {
            $kost = new \App\Models\Kost();
            $kost->name = $request->input('name');
            $kost->category = $request->input('category');
            $kost->city = $request->input('city');
            $kost->district = $request->input('district');
            $kost->owner_id = $request->input('owner_id');
            $kost->price_monthly = $request->input('price_monthly');
            $kost->room_total = $request->input('room_total');
            $kost->room_available = $request->input('room_available');

            // Ensure contact fields are never null (DB requires contact_phone)
            $kost->contact_phone = $request->input('contact_phone', $request->input('contact_whatsapp', ''));
            $kost->contact_whatsapp = $request->input('contact_whatsapp', $request->input('contact_phone', ''));

            $kost->address = $request->input('address');
            $kost->description = $request->input('description');
            $kost->is_featured = $request->has('is_featured') ? 1 : 0;
            $kost->is_active = 1;
            $kost->is_occupied = $request->has('is_occupied') ? true : false;

            // Process main image
            if ($request->hasFile('image')) {
                $kost->image = $this->compressAndStoreImage($request->file('image'), 'kosts', 75);
            }

            $kost->save();

            // Save gallery images if any
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $file) {
                    if (!$file->isValid())
                        continue;
                    $galleryPath = $this->compressAndStoreImage($file, 'kosts/gallery', 75);
                    $kost->images()->create(['image_path' => $galleryPath]);
                }
            }

            return redirect()->route('admin.kost.index')
                ->with('success', 'Data Kost berhasil disimpan!');
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
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

    public function update(Request $request, $id)
{
    $kost = Kost::findOrFail($id);

    // ... validasi lainnya ...

    // Ambil semua data
    $data = $request->all();

    // Pastikan checkbox di-set dengan benar
    // Jika tidak ada di request, maka nilainya 0
    $data['is_occupied'] = $request->has('is_occupied') ? 1 : 0;

    $kost->update($data);

    return redirect()->route('admin.kost.index')->with('success', 'Data berhasil diupdate!');
}


}
