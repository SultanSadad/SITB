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
        // Ambil data pasien yang lagi login lewat guard 'pasien'.
        $pasien = auth()->guard('pasien')->user();

        // Baris di bawah ini dikomen, artinya relasi 'hasilUjiTB' gak diload dulu.
        // Kalau nanti di dashboard perlu data hasil uji, baru aktifkan baris ini.
        // $pasien->load('hasilUjiTB');

        // Tampilkan view 'pemohon.dashboard_pasien' dan kirim data $pasien ke sana.
        return view('pemohon.dashboard_pasien', compact('pasien'));
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
        // Ambil data pasien yang lagi login.
        $pasien = auth()->guard('pasien')->user();

        // Penting: Cek dulu $pasien gak boleh kosong.
        // Kalau kosong (harusnya gak terjadi karena ada middleware), kasih error 401.
        if (!$pasien) {
            abort(401, 'Anda tidak terautentikasi sebagai pasien.');
        }

        // Ambil inputan pencarian dari URL (kalau ada).
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Ambil data hasil uji TB punya pasien yang lagi login.
        $hasilUjiList = $pasien->hasilUjiTB()
            // Kalau ada input 'search', filter berdasarkan 'tanggal_uji'.
            // `CAST(tanggal_uji AS TEXT)`: Ubah tanggal jadi teks biar bisa dicari pake LIKE.
            ->when($search, function ($query) use ($search) {
                $query->whereRaw("CAST(tanggal_uji AS TEXT) LIKE ?", ["%$search%"]);
            })
            // Kalau ada 'startDate', filter data dari tanggal tersebut atau setelahnya.
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            // Kalau ada 'endDate', filter data sampai tanggal tersebut atau sebelumnya.
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            // Urutkan dari yang terbaru.
            ->latest()
            // Tampilkan 7 data per halaman (pagination).
            ->paginate(7);

        // Tambahkan parameter pencarian ke link pagination biar filternya tetap aktif.
        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // Tampilkan view 'pemohon.hasil_uji' dan kirim data $hasilUjiList ke sana.
        return view('pemohon.hasil_uji', compact('hasilUjiList'));
    }

    /**
     * show()
     *
     * Fungsi ini buat nampilin detail (biasanya file PDF) dari satu hasil uji TB.
     * Penting: Cuma bisa nampilin hasil uji milik pasien yang lagi login.
     *
     * @param  \App\Models\HasilUjiTB $hasilUjiTB Objek HasilUjiTB yang mau ditampilkan.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\Response Respon berupa file PDF atau error.
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
