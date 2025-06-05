<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Carbon\Carbon;

class DashboardRekamMedisController extends Controller
{
    public function index()
    {
        // Ambil data hasil uji yang dibuat hari ini, termasuk relasi pasien, urut terbaru dan paginasi 5 data
        $todayResults = HasilUjiTB::whereDate('created_at', Carbon::today())
            ->with('pasien')
            ->latest()
            ->paginate(5);

        // Hitung jumlah hasil uji yang masuk hari ini
        $todayResultsCount = $todayResults->total();

        // Hitung total pasien yang terdaftar
        $totalPatients = Pasien::count();

        // Hitung total hasil uji yang tersimpan
        $totalTests = HasilUjiTB::count();

        // Buat label bulan dalam bahasa Indonesia (untuk chart)
        $chartLabels = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        // Siapkan array untuk statistik 3 tahun terakhir (termasuk tahun sekarang)
        $yearlyStats = [];
        $currentYear = date('Y'); // Tahun saat ini

        for ($year = $currentYear; $year >= $currentYear - 2; $year--) {
            $monthlyData = [];

            for ($month = 1; $month <= 12; $month++) {
                // Hitung jumlah hasil uji berdasarkan tahun dan bulan
                $monthlyCount = HasilUjiTB::whereYear('tanggal_uji', $year)
                    ->whereMonth('tanggal_uji', $month)
                    ->count();

                $monthlyData[] = $monthlyCount; // Simpan jumlah ke array bulanan
            }

            $yearlyStats[$year] = $monthlyData; // Simpan data bulanan ke array per tahun
        }

        // Kirim semua data ke view dashboard
        return view('petugas.rekam_medis.dashboard_rekam_medis', compact(
            'todayResults',
            'todayResultsCount',
            'totalPatients',
            'totalTests',
            'chartLabels',
            'yearlyStats'
        ));
    }
}
