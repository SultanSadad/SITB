<?php

// Nama File   = HasilUjiRekamMedisController.php
// Deskripsi   = Controller ini mengelola fungsionalitas terkait hasil uji dari perspektif petugas rekam medis.
//               Meliputi: menampilkan daftar hasil uji TBC terbaru untuk setiap pasien, menampilkan seluruh riwayat hasil uji TBC dari semua pasien,
//               menampilkan detail riwayat hasil uji TBC untuk pasien tertentu, serta fungsi untuk menghapus data hasil uji TBC beserta file yang terkait.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\RekamMedis;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Model Pasien untuk data pasien.
use App\Models\Pasien;
// Import Model HasilUjiTB untuk data hasil uji TB.
use App\Models\HasilUjiTB; // Baris ini sudah mengimpornya
// Import Request untuk ambil data dari formulir atau URL.
use Illuminate\Http\Request;
// Import Storage untuk mengelola file (menyimpan, mengambil, menghapus).
use Illuminate\Support\Facades\Storage;
// Import DB untuk query database langsung.
use Illuminate\Support\Facades\DB;

class HasilUjiRekamMedisController extends Controller
{
    /**
     * index()
     *
     * Menampilkan halaman **'Hasil Uji'** yang berisi **hasil uji TB terbaru dari setiap pasien**.
     * Dilengkapi fitur pencarian dan filter berdasarkan rentang tanggal.
     *
     * @param  \Illuminate\Http\Request  $request Input pencarian dan filter tanggal.
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian dan tanggal mulai/akhir dari request.
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Dapatkan ID hasil uji terbaru (ID terbesar) untuk setiap pasien.
        // PERBAIKAN: Gunakan 'HasilUjiTB' langsung karena sudah di-use di atas.
        $latestIds = HasilUjiTB::select(DB::raw('MAX(id) as id'))
            ->groupBy('pasien_id');

        // Ambil data hasil uji berdasarkan ID terbaru, beserta data pasiennya.
        // PERBAIKAN: Gunakan 'HasilUjiTB' langsung karena sudah di-use di atas.
        $hasilUjiList = HasilUjiTB::with('pasien')
            ->whereIn('id', $latestIds) // Filter hanya hasil uji terbaru per pasien.
            ->when($search, function ($query) use ($search) {
                // Jika ada pencarian, filter pasien berdasarkan nama, NIK, No. ERM, atau WhatsApp.
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            // Filter berdasarkan tanggal uji jika tanggal mulai/akhir diset.
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest() // Urutkan dari yang terbaru.
            ->paginate(10); // Tampilkan 10 data per halaman.

        // Tambahkan parameter pencarian dan filter ke tautan paginasi.
        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // Jika halaman kosong dan bukan halaman pertama, arahkan kembali ke halaman 1.
        if ($hasilUjiList->isEmpty() && $hasilUjiList->currentPage() > 1) {
            return redirect()->route('rekam-medis.hasil-uji', ['page' => 1]);
        }

        // Tampilkan view 'petugas.rekam_medis.hasil_uji' dengan data yang sudah difilter.
        return view('petugas.rekam_medis.hasil_uji', compact('hasilUjiList'));
    }



    /**
     * indexDataHasilUji()
     *
     * Menampilkan halaman **'Riwayat Hasil Uji'** yang berisi **SEMUA riwayat hasil uji TB dari SEMUA pasien**.
     * Dilengkapi fitur pencarian dan filter berdasarkan rentang tanggal.
     *
     * @param  \Illuminate\Http\Request  $request Input pencarian dan filter tanggal.
     * @return \Illuminate\Contracts\View\View
     */
    public function indexDataHasilUji(Request $request)
    {
        // Ambil kata kunci pencarian dan tanggal mulai/akhir dari request.
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Ambil semua data hasil uji TB, beserta data pasiennya.
        // PERBAIKAN: Gunakan 'HasilUjiTB' langsung karena sudah di-use di atas.
        $hasilUjiList = HasilUjiTB::with('pasien')
            ->when($search, function ($query) use ($search) {
                // Jika ada pencarian, filter pasien berdasarkan nama, NIK, No. ERM, atau WhatsApp.
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            // Filter berdasarkan tanggal uji jika tanggal mulai/akhir diset.
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest() // Urutkan dari yang terbaru.
            ->paginate(9); // Tampilkan 9 data per halaman.

        // Tambahkan parameter pencarian dan filter ke tautan paginasi.
        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // Tampilkan view 'petugas.rekam_medis.riwayat_hasil_uji' dengan data yang sudah difilter.
        return view('petugas.rekam_medis.riwayat_hasil_uji', compact('hasilUjiList'));
    }



    /**
     * show()
     *
     * Menampilkan **semua hasil uji TB untuk satu pasien tertentu**.
     *
     * @param  int  $pasienId ID pasien yang hasil ujinya ingin ditampilkan.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($pasienId)
    {
        // Cari data pasien berdasarkan ID, atau tampilkan error 404 jika tidak ditemukan.
        $pasien = Pasien::findOrFail($pasienId);

        // Ambil semua hasil uji milik pasien ini, urutkan dari terbaru, dan paginasi 8 data.
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(8);

        // Tampilkan view 'petugas.rekam_medis.detail_hasil_uji' dengan data pasien dan hasil ujinya.
        return view('petugas.rekam_medis.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }



    /**
     * destroy()
     *
     * Menghapus **satu data hasil uji TB beserta file-nya** dari penyimpanan.
     *
     * @param  int  $id ID dari HasilUjiTB yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Cari data hasil uji TB berdasarkan ID, atau tampilkan error 404 jika tidak ditemukan.
        // PERBAIKAN: Gunakan 'HasilUjiTB' langsung karena sudah di-use di atas.
        $hasil = HasilUjiTB::findOrFail($id);

        // Jika ada file terkait dan file tersebut ada di penyimpanan publik, hapus file tersebut.
        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            Storage::disk('public')->delete($hasil->file);
        }

        // Hapus catatan hasil uji dari database.
        $hasil->delete();

        // Arahkan kembali ke halaman sebelumnya dengan pesan sukses.
        return redirect()->back()->with('success', 'Hasil uji berhasil dihapus');
    }
}
