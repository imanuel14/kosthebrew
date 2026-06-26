<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes - Kost HeBrew
|--------------------------------------------------------------------------
*/

// =========================================================================
// 1. PUBLIC / GUEST ROUTES (Dapat Diakses Semua Pengunjung Tanpa Login)
// =========================================================================
Route::get('/', [KostController::class, 'welcome'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact/send', [HomeController::class, 'sendContactMessage'])->name('contact.send');

// --- Rute Eksplorasi Kost & Kamar ---
Route::get('/kost', [KostController::class, 'index'])->name('kosts.index');
Route::get('/kosts/search', [KostController::class, 'search'])->name('kosts.search');
Route::get('/kosts/category/{category}', [KostController::class, 'category'])->name('kosts.category');
Route::get('/kosts/{slug}', [KostController::class, 'show'])->name('kosts.show');
Route::get('/kamar', [KostController::class, 'index'])->name('kamar.index');
Route::get('/kamar/{slug}', [KostController::class, 'show'])->name('kamar.show');

// --- Rute Transaksi Instan / Webhook (Tanpa Auth untuk Midtrans/Testing) ---
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
Route::get('/book/{kost_id}', [PaymentController::class, 'create'])->name('pemilik.book.kost');


// =========================================================================
// 2. AUTHENTICATION ROUTES (Manajemen Masuk & Daftar Akun)
// =========================================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// =========================================================================
// 3. AUTHENTICATED USER ROUTES (Khusus Pencari Kost / Penyewa)
// =========================================================================
Route::middleware(['auth'])->group(function () {
    // Dashboard & Profil Penyewa
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
    Route::get('/my-bookings', [HomeController::class, 'myBookings'])->name('bookings.my');
    Route::get('/my-payments', [PaymentController::class, 'myPayments'])->name('payments.my');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('user.profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');


    // Alur Transaksi Pembayaran / Booking Kamar
    Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/success/{payment}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/status/{payment}', [PaymentController::class, 'checkStatus'])->name('payment.status');

    // Link Legacy / Shortcut Lintas Role (Jika Masih Diperlukan)
    Route::get('/pemilik/dashboard', [UserController::class, 'pemilikDashboard'])->name('pemilik.dashboard');
    Route::get('/pemilik/transaksi', [UserController::class, 'pemilikTransaksi'])->name('pemilik.transaksi');
});


// =========================================================================
// 4. PEMILIK KOST ROUTES (Hanya Diakses oleh Pengguna dengan Role Pemilik)
// =========================================================================
Route::middleware(['auth', 'pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
    
    // Dashboard Utama Pemilik
    Route::get('/', [PemilikController::class, 'index'])->name('dashboard');

    // Manajemen Properti Kost Milik Pribadi (CRUD)
    Route::prefix('kost')->name('kost.')->group(function () {
        Route::get('/', [PemilikController::class, 'index'])->name('index'); 
        Route::get('/create', [PemilikController::class, 'create'])->name('create'); 
        Route::post('/', [PemilikController::class, 'store'])->name('store'); 
        
        // Parameter ID diletakkan di bawah agar /create tidak dianggap sebagai ID
        Route::get('/{id}', [PemilikController::class, 'show'])->name('show'); 
        Route::get('/{id}/edit', [PemilikController::class, 'edit'])->name('edit'); 
        Route::put('/{id}', [PemilikController::class, 'update'])->name('update'); 
        Route::delete('/{id}', [PemilikController::class, 'destroy'])->name('destroy'); 

        // Manajemen Gambar Galeri Kost oleh Pemilik
        Route::post('/{id}/images', [PemilikController::class, 'uploadImages'])->name('images.store'); 
        Route::delete('/{kost}/images/{image}', [PemilikController::class, 'deleteImage'])->name('images.destroy'); 
    });

    // Ringkasan Bisnis Pemilik
    Route::get('/transaksi', [PemilikController::class, 'transaksiIndex'])->name('transaksi.index');
    Route::get('/penyewa', [PemilikController::class, 'penyewaIndex'])->name('penyewa.index');
});


// =========================================================================
// 5. ADMIN CONTROL PANEL ROUTES (Hanya untuk Super Admin / Manajemen Utama)
// =========================================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
Route::resource('users', UserController::class);
    // Dashboard Statistik Utama Admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
   // --- MANAJEMEN AKUN USER / PENDAFTAR BARU ---
Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', [AdminController::class, 'userIndex'])->name('index');
    
    // Tambahkan 4 rute baru ini:
    Route::get('/create', [AdminController::class, 'userCreate'])->name('create');
    Route::post('/', [AdminController::class, 'userStore'])->name('store');
    Route::get('/{id}/edit', [AdminController::class, 'userEdit'])->name('edit');
    Route::put('/{id}', [AdminController::class, 'userUpdate'])->name('update');
    
    Route::get('/{id}', [AdminController::class, 'userShow'])->name('show');
    Route::delete('/{id}', [AdminController::class, 'userDestroy'])->name('destroy');
    Route::post('/{id}/toggle-role', [AdminController::class, 'toggleUserRole'])->name('toggleRole');

});

    // --- MANAJEMEN DATA KOST GLOBAL ---
    Route::prefix('kost')->name('kost.')->group(function () {
        Route::get('/', [AdminController::class, 'kostIndex'])->name('index');
        Route::get('/create', [AdminController::class, 'kostCreate'])->name('create');
        Route::post('/', [AdminController::class, 'kostStore'])->name('store');
        Route::get('/{id}', [AdminController::class, 'kostShow'])->name('show');
        Route::get('/{id}/edit', [AdminController::class, 'kostEdit'])->name('edit');
        Route::put('/{id}', [AdminController::class, 'kostUpdate'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'kostDestroy'])->name('destroy');
        
        // Fitur Unggah & Hapus Galeri Gambar oleh Admin
        Route::post('/{id}/images', [AdminController::class, 'kostUploadImages'])->name('images.store');
        Route::delete('/{kost}/images/{image}', [AdminController::class, 'kostDeleteImage'])->name('images.destroy');
    });

    // --- MANAJEMEN HUBUNGI KAMI / KOTAK MASUK PESAN ---
    Route::prefix('messages')->name('messages.')->group(function () {
        Route::get('/', [AdminController::class, 'messageIndex'])->name('index');
        Route::get('/{id}', [AdminController::class, 'messageShow'])->name('show');
        Route::delete('/{id}', [AdminController::class, 'messageDestroy'])->name('destroy');
    });

    // --- MANAJEMEN TRANSAKSI & TESTIMONI WEBSITE ---
    Route::get('/transaksi', [AdminController::class, 'transaksiIndex'])->name('transaksi.index');
    Route::resource('/testimonial', TestimonialController::class)->names('testimonial');
});