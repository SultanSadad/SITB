<?php

// Nama File   =
// Deskripsi   =
//
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 1 April 2025
namespace App\Http\Controllers\Pemohon;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Model Pasien (data pasien).
use App\Models\Pasien;
// Import Model HasilUjiTB (data hasil uji TB).
use App\Models\HasilUjiTB;
// Import Request untuk ambil data dari form atau URL.
use Illuminate\Http\Request;
// Import Auth untuk cek status login pengguna.
use Illuminate\Support\Facades\Auth;
// Import untuk tampilan (View).
use Illuminate\Contracts\View\View;
// Import untuk respons HTTP.
use Illuminate\Http\Response;
// Import untuk Factory (biasanya untuk membuat instance view).
use Illuminate\Contracts\View\Factory;
// Import untuk Application (konteks aplikasi Laravel).
use Illuminate\Contracts\Foundation\Application;
// Import Storage untuk kelola file (simpan, ambil, hapus).
use Illuminate\Support\Facades\Storage;

class HasilUjiPasienController extends Controller
{
    /**
     * Konstruktor: Pastikan cuma user pasien yang udah login yang bisa akses controller ini.
     */
    public function __construct()
    {
        // Pasang middleware 'auth:pasien' untuk semua fungsi di controller ini.
        // Artinya, kalau belum login sebagai 'pasien', akan dialihkan ke halaman login.
        $this->middleware('auth:pasien');
    }

    /**
     * dashboard()
     *
     * Fungsi ini buat nampilin halaman dashboard khusus untuk pasien yang lagi login.
     * Isinya data dasar pasien.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function dashboard()
    {
        $pasien = auth()->guard('pasien')->user();
        return view('pemohon.dashboard', compact('pasien'));
    }




    /**
     * index()
     *
     * Fungsi ini buat nampilin daftar hasil uji TB milik pasien yang lagi login.
     * Ada fitur cari berdasarkan tanggal dan kata kunci.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request untuk ambil inputan pencarian.
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $pasien = auth()->guard('pasien')->user();

        if (!$pasien) {
            abort(401, 'Anda tidak terautentikasi sebagai pasien.');
        }

        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        $hasilUjiList = $pasien->hasilUjiTB()
            ->when($search, function ($query) use ($search) {
                $query->whereRaw("CAST(tanggal_uji AS TEXT) LIKE ?", ["%$search%"]);
            })
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest()
            ->paginate(7);

        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // === TAMBAHKAN BARIS INI UNTUK MENDAPATKAN DAN MENERUSKAN $nonce ===
        $nonce = $request->attributes->get('csp_nonce');
        // ==================================================================

        // Tampilkan view 'pemohon.hasil_uji' dan kirim data $hasilUjiList dan $nonce ke sana.
        return view('pemohon.hasil_uji', compact('hasilUjiList', 'nonce')); // Tambahkan 'nonce' di compact
    }

    /**
     * show()
     *
     * Fungsi ini buat nampilin detail (biasanya file PDF) dari satu hasil uji TB.
     * Penting: Cuma bisa nampilin hasil uji milik pasien yang lagi login.
     *
     * @param  \App\Models\HasilUjiTB $hasilUjiTB Objek HasilUjiTB yang mau ditampilkan.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\Response
     *         Respon berupa file PDF atau error.
     */
    public function show(HasilUjiTB $hasilUjiTB)
    {
        // Ambil data user yang lagi login (pasien).
        $user = Auth::guard('pasien')->user();

        // Cek: Pastikan ID pasien yang login sama dengan pasien_id di data HasilUjiTB.
        // Kalau beda, berarti dia coba akses data orang lain, kasih error 403 (Forbidden).
        if ($user->id !== $hasilUjiTB->pasien_id) {
            abort(403, 'Anda tidak diizinkan mengakses hasil uji pasien lain.');
        }

        // Cek: Pastikan file hasil uji (PDF) ada di storage.
        // Kalau gak ada, kasih error 404 (Not Found).
        if (!Storage::disk('public')->exists($hasilUjiTB->file)) {
            abort(404, 'File hasil uji tidak ditemukan.');
        }

        // Kalau semua cek lolos, kirim file PDF dari storage.
        // 'Content-Type': Kasih tahu browser kalau ini file PDF.
        // 'Content-Disposition': 'inline' berarti file akan dibuka langsung di browser.
        return Storage::disk('public')->response($hasilUjiTB->file, null, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($hasilUjiTB->file) . '"',
        ]);
    }
}
