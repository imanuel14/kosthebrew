<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Penyewa;
use App\Models\Kamar;
use App\Models\Kost;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman payment/booking
     * Bisa menerima kamar_id atau kost_id
     */
    public function create(Request $request)
    {
        $kamar = null;
        $kost = null;
        
        if ($request->kamar_id) {
            // Booking kamar spesifik
            $kamar = Kamar::with('kost')->findOrFail($request->kamar_id);
            $kost = $kamar->kost;
        } elseif ($request->kost_id) {
            // Booking kost langsung (ambil kamar pertama yang tersedia)
            $kost = Kost::findOrFail($request->kost_id);
            $kamar = Kamar::where('kost_id', $kost->id)
                ->where('status', 'tersedia')
                ->first();
            
            if (!$kamar) {
                return back()->with('error', 'Tidak ada kamar tersedia untuk kost ini.');
            }
        } else {
            return back()->with('error', 'ID kamar atau kost tidak valid.');
        }
        
        // Menyelaraskan properti harga jika di database field-nya adalah price_monthly
        if (!isset($kamar->harga) && isset($kost->price_monthly)) {
            $kamar->harga = $kost->price_monthly;
        }
        
        return view('user.payments.create', compact('kamar', 'kost'));
    }

    /**
     * Memproses pembayaran awal (create payment)
     */
    public function store(Request $request)
    {
        $request->validate([
            'kost_id'    => 'required|exists:kosts,id',
            'duration'   => 'required|integer|in:1,3,6,12',
            'start_date' => 'required|date|after_or_equal:today',
        ]);

        $kost = Kost::findOrFail($request->kost_id);
        
        // Ambil kamar pertama yang tersedia untuk kost ini
        $kamar = Kamar::where('kost_id', $kost->id)
            ->where('status', 'tersedia')
            ->first();
            
        if (!$kamar) {
            return back()->with('error', 'Maaf, tidak ada kamar yang tersedia saat ini.');
        }

        // Tentukan harga sewa per bulan (adaptif terhadap field database)
        $hargaPerBulan = $kamar->harga ?? $kost->price_monthly;
        
        // Hitung total harga berdasarkan durasi sewa pilihan user
        $totalHarga = $hargaPerBulan * (int)$request->duration;

        $user = Auth::user();

        // MENGGUNAKAN DATABASE TRANSACTION UNTUK KEAMANAN DAN KONSISTENSI DATA
        $payment = DB::transaction(function () use ($user, $kost, $kamar, $hargaPerBulan, $totalHarga, $request) {
            
            // SECURITY UPDATE: Hapus data pemesanan berstatus 'pending' yang usang milik user ini 
            // agar tidak terjadi penumpukan/tabrakan data di database jika user memesan ulang.
            Penyewa::where('user_id', $user->id)->where('status', 'pending')->delete();

            // Buat data penyewa baru yang bersih
            $penyewa = Penyewa::create([
                'user_id'       => $user->id,
                'kost_id'       => $kost->id,
                'kamar_id'      => $kamar->id,
                'tanggal_masuk' => $request->start_date,
                'jaminan'       => $hargaPerBulan, // Jaminan biasanya senilai 1 bulan sewa
                'status'        => 'pending',
            ]);

            // Buat invoice awal
            return Payment::create([
                'penyewa_id'        => $penyewa->id,
                'kamar_id'          => $kamar->id,
                'order_id'          => 'INV-' . time() . '-' . Str::upper(Str::random(4)),
                'amount'            => $totalHarga,
                'metode_pembayaran' => $request->metode_pembayaran ?? 'transfer',
                'status'            => 'pending',
            ]);
        });

        // Eksekusi simulasi pelunasan langsung otomatis
        return $this->processPayment($payment);
    }

    /**
     * Memproses pembayaran (simulasi instan sukses)
     */
    private function processPayment(Payment $payment)
    {
        try {
            DB::transaction(function () use ($payment) {
                // 1. Update status data pembayaran
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                    'provider' => 'simulasi',
                ]);

                // 2. Update status penyewa menjadi aktif
                $payment->penyewa->update(['status' => 'aktif']);
                
                // 3. Update status kamar menjadi terisi
                $payment->kamar->update(['status' => 'terisi']);
                
                // 4. Kurangi kuota stok kamar tersedia di tabel induk Kost
                if ($payment->kamar->kost->room_available > 0) {
                    $payment->kamar->kost->decrement('room_available');
                }

                // 5. Cetak record di tabel Transaksi sebagai bukti kuitansi finansial
                Transaksi::create([
                    'penyewa_id' => $payment->penyewa_id,
                    'kamar_id' => $payment->kamar_id,
                    'bulan' => now()->month,
                    'tahun' => now()->year,
                    'jumlah_bayar' => $payment->amount,
                    'tanggal_bayar' => now(),
                    'metode_pembayaran' => $payment->metode_pembayaran,
                    'status' => 'lunas',
                    'keterangan' => 'Pembayaran sewa awal sukses via ' . $payment->metode_pembayaran,
                ]);
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }

        // Redirect mengarah ke view sukses dengan menyertakan object payment terbaru
        return redirect()->route('payment.success', $payment->id)
            ->with('success', 'Pembayaran sukses diverifikasi sistem!');
    }

    /**
     * Halaman sukses penyerahan kuitansi digital
     */
    public function success($id)
    {
        $payment = Payment::with(['penyewa.user', 'kamar.kost'])->findOrFail($id);
        
        // Buat objek dummy Transaksi jika relasi data finansial Anda dipanggil di view
        $transaksi = Transaksi::where('penyewa_id', $payment->penyewa_id)->latest()->first();

        return view('user.payments.success', compact('payment', 'transaksi'));
    }

    /**
     * Callback Webhook Payment Gateway (Opsional/Sistem Otomatis Masa Depan)
     */
    public function callback(Request $request)
    {
        $orderId = $request->order_id;
        $payment = Payment::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Invoice data tidak ditemukan'], 404);
        }

        $status = $request->transaction_status;
        
        switch ($status) {
            case 'settlement':
            case 'capture':
                $payment->update([
                    'status' => 'success',
                    'paid_at' => now(),
                    'transaction_id' => $request->transaction_id,
                ]);
                
                $payment->penyewa->update(['status' => 'aktif']);
                $payment->kamar->update(['status' => 'terisi']);
                break;
                
            case 'pending':
                $payment->update(['status' => 'pending']);
                break;
                
            case 'deny':
            case 'cancel':
            case 'expire':
                $payment->update(['status' => 'failed']);
                break;
        }

        return response()->json(['message' => 'Callback received successfully']);
    }

    /**
     * Cek status manual invoice pembayaran tertentu
     */
    public function checkStatus($id)
    {
        $payment = Payment::with(['penyewa.user', 'kamar.kost'])->findOrFail($id);
        return view('user.payments.status', compact('payment'));
    }

    /**
     * Riwayat log koleksi daftar pembayaran milik user login saat ini
     */
    public function myPayments()
    {
        $user = Auth::user();
        
        // Mengambil semua riwayat ID penyewa yang terikat dengan user account ini
        $penyewaIds = Penyewa::where('user_id', $user->id)->pluck('id');
        
        if ($penyewaIds->isEmpty()) {
            $payments = collect(); 
            return view('user.payments.index', compact('payments'))->with('warning', 'Anda belum memiliki riwayat pembayaran.');
        }

        // Mengambil seluruh invoice data dari array list penampung di atas
        $payments = Payment::whereIn('penyewa_id', $penyewaIds)
            ->with('kamar.kost')
            ->latest()
            ->paginate(10);

        // Pastikan variabel yang dilempar bernama 'payments' untuk dicocokkan ke Blade
        return view('user.payments.index', compact('payments'));
    }
}