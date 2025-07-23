<?php

// Nama File   = DashboardRekamMedisController.php
// Deskripsi   = Controller ini bertanggung jawab untuk menampilkan halaman dashboard utama bagi petugas rekam medis.
//               Fungsi utamanya adalah menyediakan ringkasan statistik terkini, seperti jumlah hasil uji hari ini,
//               total pasien, total hasil uji, serta data bulanan untuk grafik statistik hasil uji TBC selama beberapa tahun terakhir.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\RekamMedis;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Request untuk ambil data dari form atau URL (meskipun di sini tidak digunakan secara langsung).
use Illuminate\Http\Request;
// Import Model HasilUjiTB (data hasil uji TB).
use App\Models\HasilUjiTB;
// Import Model Pasien (data pasien).
use App\Models\Pasien;
// Import Carbon untuk mempermudah manipulasi tanggal dan waktu.
use Carbon\Carbon;

class DashboardRekamMedisController extends Controller
{
    /**
     * index()
     *
     * Fungsi ini buat nampilin halaman dashboard utama untuk petugas rekam medis.
     * Isinya ringkasan data hasil uji dan statistik per bulan.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // --- Data Ringkasan Utama ---

        // Ambil 5 hasil uji TB yang dibuat HARI INI.
        // Termasuk data pasien terkait (`with('pasien')`).
        // Diurutkan dari yang terbaru, dan ditampilkan 5 per halaman.
        $todayResults = HasilUjiTB::whereDate('created_at', Carbon::today())
            ->with('pasien')
            ->latest()
            ->paginate(5);

        // Hitung total berapa banyak hasil uji yang masuk (dibuat) hari ini.
        $todayResultsCount = $todayResults->total();

        // Hitung total semua pasien yang terdaftar di database.
        $totalPatients = Pasien::count();

        // Hitung total semua hasil uji TB yang pernah tersimpan di database.
        $totalTests = HasilUjiTB::count();

        // --- Data untuk Grafik Statistik Bulanan ---

        // Label (nama) bulan dalam bahasa Indonesia untuk tampilan grafik.
        $chartLabels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Siapkan tempat untuk menyimpan statistik hasil uji per bulan untuk beberapa tahun.
        $yearlyStats = [];
        // Ambil tahun saat ini (misal: 2024).
        $currentYear = date('Y');

        // Loop untuk mengambil data statistik 3 tahun terakhir (tahun sekarang, tahun-1, tahun-2).
        // Contoh: Jika tahun sekarang 2024, maka akan ambil data untuk 2024, 2023, dan 2022.
        for ($year = $currentYear; $year >= $currentYear - 2; $year--) {
            $monthlyData = []; // Array untuk menyimpan jumlah hasil uji setiap bulan di tahun ini.

            // Loop untuk setiap bulan (dari Januari sampai Desember).
            for ($month = 1; $month <= 12; $month++) {
                // Hitung jumlah hasil uji TB yang dilakukan pada tahun `$year` dan bulan `$month` ini.
                $monthlyCount = HasilUjiTB::whereYear('tanggal_uji', $year)
                    ->whereMonth('tanggal_uji', $month)
                    ->count();

                // Tambahkan jumlah hasil uji bulanan ke array `$monthlyData`.
                $monthlyData[] = $monthlyCount;
            }

            // Simpan data bulanan ini ke array `$yearlyStats` dengan kunci berupa tahunnya.
            $yearlyStats[$year] = $monthlyData;
        }

        // Kirim semua data yang sudah disiapkan ke tampilan (view) dashboard rekam medis.
        return view('petugas.rekam_medis.dashboard_rekam_medis', compact(
            'todayResults',      // 5 hasil uji terbaru yang dibuat hari ini
            'todayResultsCount', // Jumlah total hasil uji hari ini
            'totalPatients',     // Total semua pasien
            'totalTests',        // Total semua hasil uji
            'chartLabels',       // Nama-nama bulan untuk label grafik
            'yearlyStats'        // Data statistik hasil uji per bulan untuk 3 tahun terakhir
        ));
    }
}
