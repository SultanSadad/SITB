<?php

// Nama File   = HasilUjiRekamMedisController.php
// Deskripsi   = Controller ini mengelola fungsionalitas terkait hasil uji dari perspektif petugas rekam medis.
//               Meliputi: menampilkan daftar hasil uji TBC terbaru untuk setiap pasien, menampilkan seluruh riwayat
//               hasil uji TBC dari semua pasien, menampilkan detail riwayat hasil uji TBC untuk pasien tertentu,
//               serta fungsi untuk menghapus data hasil uji TBC beserta file yang terkait.
// Dibuat oleh = Sultan Sadad - 3312301102
// Tanggal     = 4 April 2025

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\HasilUjiTB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class HasilUjiRekamMedisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        $latestIds = HasilUjiTB::select(DB::raw('MAX(id) as id'))
            ->groupBy('pasien_id');

        $hasilUjiList = HasilUjiTB::with('pasien')
            ->whereIn('id', $latestIds)
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest()
            ->paginate(10);

        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        if ($hasilUjiList->isEmpty() && $hasilUjiList->currentPage() > 1) {
            return redirect()->route('rekam-medis.hasil-uji', ['page' => 1]);
        }

        return view('petugas.rekam_medis.hasil_uji', compact('hasilUjiList'));
    }

    public function indexDataHasilUji(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        $hasilUjiList = HasilUjiTB::with('pasien')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest()
            ->paginate(9);

        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        return view('petugas.rekam_medis.riwayat_hasil_uji', compact('hasilUjiList'));
    }

    public function show($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(8);

        return view('petugas.rekam_medis.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }

    public function destroy($id)
    {
        $hasil = HasilUjiTB::findOrFail($id);

        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            Storage::disk('public')->delete($hasil->file);
        }

        $hasil->delete();

        return redirect()->back()->with('success', 'Hasil uji berhasil dihapus');
    }
}
