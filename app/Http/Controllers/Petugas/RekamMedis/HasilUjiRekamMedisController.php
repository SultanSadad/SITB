<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\HasilUjiTB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HasilUjiRekamMedisController extends Controller
{
    // Untuk halaman hasil_uji.blade.php
    public function index(Request $request)
    {
        // Ambil parameter pencarian dan filter tanggal dari request
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Ambil ID dari hasil uji terbaru (id terbesar) untuk setiap pasien
        $latestIds = HasilUjiTB::select(DB::raw('MAX(id) as id'))
            ->groupBy('pasien_id'); // Group berdasarkan pasien_id

        // Ambil hasil uji yang termasuk dalam daftar ID terbaru tadi
        $hasilUjiList = HasilUjiTB::with('pasien') // Load relasi pasien
            ->whereIn('id', $latestIds) // Hanya ambil hasil uji terbaru per pasien
            ->when($search, function ($query) use ($search) {
                // Jika ada input pencarian, filter berdasarkan atribut pasien
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            // Filter berdasarkan tanggal uji jika diset
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest() // Urutkan dari yang terbaru
            ->paginate(10); // Tampilkan 10 data per halaman

        // Simpan parameter pencarian agar tetap ada saat pindah halaman
        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // Jika halaman tidak memiliki data (karena filter/paginasi), redirect ke halaman 1
        if ($hasilUjiList->isEmpty() && $hasilUjiList->currentPage() > 1) {
            return redirect()->route('rekam-medis.hasil-uji', ['page' => 1]);
        }

        // Tampilkan view dengan data hasil uji terbaru per pasien
        return view('petugas.rekam_medis.hasil_uji', compact('hasilUjiList'));
    }


    // Untuk halaman datahasiluji.blade.php
    public function indexDataHasilUji(Request $request)
    {
        // Ambil parameter pencarian dan filter tanggal
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Query data hasil uji, termasuk relasi ke pasien
        $hasilUjiList = HasilUjiTB::with('pasien')
            // Jika ada input pencarian, filter berdasarkan nama, nik, no_erm, no_whatsapp
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            // Filter berdasarkan tanggal uji jika tersedia
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest() // Urutkan dari hasil uji terbaru
            ->paginate(9); // Paginasi 9 hasil per halaman

        // Simpan parameter query agar tetap ada saat pagination
        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // Tampilkan view riwayat hasil uji
        return view('petugas.rekam_medis.riwayat_hasil_uji', compact('hasilUjiList'));
    }



    // Menampilkan semua hasil uji dari satu pasien
    public function show($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId); // Ambil data pasien berdasarkan ID

        // Ambil semua hasil uji milik pasien tersebut
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(8); // Paginasi 8 data

        // Tampilkan halaman detail hasil uji milik pasien
        return view('petugas.rekam_medis.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }



    // Menghapus satu hasil uji
    public function destroy($id)
    {
        $hasil = HasilUjiTB::findOrFail($id); // Cari data hasil uji berdasarkan ID

        // Jika ada file dan file-nya tersimpan di storage publik, hapus file
        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            Storage::disk('public')->delete($hasil->file);
        }

        // Hapus record hasil uji dari database
        $hasil->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Hasil uji berhasil dihapus');
    }


}

