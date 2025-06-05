<?php

namespace App\Http\Controllers\Pemohon;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class HasilUjiPasienController extends Controller
{
    // Method untuk menampilkan dashboard pasien yang sedang login
    public function dashboard()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Cari data pasien berdasarkan ID pasien milik user, sekaligus load relasi hasilUjiTB
        $pasien = Pasien::with('hasilUjiTB')->findOrFail($user->pasien_id);

        // Tampilkan view dashboard pasien dengan data pasien
        return view('pemohon.dashboard_pasien', compact('pasien'));
    }

    // Method untuk menampilkan halaman daftar hasil uji pasien (dengan filter pencarian dan tanggal)
    public function index(Request $request)
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Cari data pasien berdasarkan ID pasien milik user
        $pasien = Pasien::findOrFail($user->pasien_id);

        // Ambil input pencarian (tanggal) dan rentang tanggal dari request
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Ambil hasil uji milik pasien dengan filter:
        // - jika ada input pencarian, cari berdasarkan tanggal_uji
        // - jika ada tanggal awal, filter hasil >= startDate
        // - jika ada tanggal akhir, filter hasil <= endDate
        // - urutkan dari terbaru dan pagination 7 per halaman
        $hasilUjiList = $pasien->hasilUjiTB()
            ->when($search, function ($query) use ($search) {
                $query->whereRaw("CAST(tanggal_uji AS TEXT) LIKE ?", ["%$search%"]);
            })
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->latest()
            ->paginate(7);

        // Tambahkan parameter pencarian & tanggal ke URL pagination
        $hasilUjiList->appends($request->only(['search', 'start', 'end']));

        // Tampilkan view hasil uji dengan data hasilUjiList
        return view('pemohon.hasil_uji', compact('hasilUjiList'));
    }


}
