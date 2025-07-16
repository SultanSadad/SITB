<?php
// Nama File   = DashboardLaboranController.php 
// Deskripsi   = Controller ini mengatur logika bisnis untuk halaman dashboard petugas laboran.
//               Meliputi pengambilan data statistik ringkasan (hasil uji hari ini, total hasil uji, total pasien),
//               serta menyiapkan data untuk grafik statistik hasil uji bulanan/tahunan.
//               Juga terdapat fungsi untuk menampilkan riwayat hasil uji TB per pasien.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\Laboran;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Request untuk ambil data dari form atau URL.
use Illuminate\Http\Request;
// Import Model HasilUjiTB (data hasil uji TB).
use App\Models\HasilUjiTB;
// Import Model Pasien (data pasien).
use App\Models\Pasien;
// Import Carbon untuk mempermudah manipulasi tanggal dan waktu.
use Carbon\Carbon;
// Import DB untuk query database langsung.
use Illuminate\Support\Facades\DB;

class DashboardLaboranController extends Controller
{
    /**
     * index()
     *
     * Fungsi ini buat nampilin halaman dashboard utama untuk petugas laboran.
     * Isinya ringkasan data hasil uji dan statistik.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // --- Data untuk Ringkasan Utama ---

        // Ambil 5 hasil uji TB yang dibuat HARI INI.
        // Langsung ambil juga data pasien yang terkait (`with('pasien')`),
        // Diurutkan dari yang terbaru, dan ditampilkan 5 per halaman.
        $todayResults = HasilUjiTB::whereDate('created_at', Carbon::today())
            ->with('pasien')
            ->latest()
            ->paginate(5);

        // Hitung total berapa banyak hasil uji yang dibuat hari ini.
        $todayResultsCount = $todayResults->total();

        // Hitung total semua pasien yang terdaftar.
        $totalPatients = Pasien::count();
        // Hitung total semua hasil uji TB yang pernah dibuat.
        $totalTests = HasilUjiTB::count();

        // --- Data untuk Grafik Statistik Bulanan/Tahunan ---

        // Ambil tahun sekarang dan 3 tahun sebelumnya.
        $currentYear = Carbon::now()->year;
        $years = [$currentYear, $currentYear - 1, $currentYear - 2, $currentYear - 3];

        // Tentukan kolom tanggal mana yang mau dipakai untuk statistik (tanggal uji atau tanggal dibuat).
        $dateColumn = 'tanggal_uji';

        // Label (nama) bulan untuk grafik.
        $chartLabels = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        // Ambil jumlah hasil uji per bulan untuk TAHUN SAAT INI.
        // `MONTH({$dateColumn})`: Ambil nomor bulan dari kolom tanggal.
        // `COUNT(*)`: Hitung jumlah data.
        // `groupBy`: Kelompokkan berdasarkan bulan.
        // `orderBy`: Urutkan berdasarkan bulan.
        $monthlyStats = HasilUjiTB::selectRaw("MONTH({$dateColumn}) AS month, COUNT(*) AS total")
            ->whereYear($dateColumn, $currentYear)
            ->groupBy(DB::raw("MONTH({$dateColumn})"))
            ->orderBy('month')
            ->get();

        // Siapkan array kosong untuk data grafik (12 bulan, nilai awal 0).
        $chartData = array_fill(0, 12, 0);

        // Isi array $chartData dengan data yang sudah diambil dari database.
        // `(int) $stat->month - 1`: Ubah nomor bulan jadi indeks array (0-11).
        foreach ($monthlyStats as $stat) {
            $month = (int) $stat->month - 1;
            $chartData[$month] = $stat->total;
        }

        // Siapkan tempat untuk menyimpan statistik per bulan untuk beberapa tahun.
        $yearlyStats = [];
        // Masukkan data tahun sekarang ke $yearlyStats.
        $yearlyStats[$currentYear] = $chartData;

        // Ambil data statistik per bulan untuk tahun-tahun sebelumnya.
        foreach ($years as $year) {
            // Lewati tahun sekarang karena sudah diproses.
            if ($year == $currentYear)
                continue;

            // Lakukan query yang sama untuk tahun-tahun sebelumnya.
            $prevYearStats = HasilUjiTB::selectRaw("MONTH({$dateColumn}) AS month, COUNT(*) AS total")
                ->whereYear($dateColumn, $year)
                ->groupBy(DB::raw("MONTH({$dateColumn})"))
                ->orderBy('month')
                ->get();

            // Siapkan array data bulan untuk tahun ini, lalu isi.
            $yearData = array_fill(0, 12, 0);
            foreach ($prevYearStats as $stat) {
                $month = (int) $stat->month - 1;
                $yearData[$month] = $stat->total;
            }
            // Simpan data tahun ini ke $yearlyStats.
            $yearlyStats[$year] = $yearData;
        }

        // Kirim semua data yang sudah disiapkan ke tampilan (view) dashboard laboran.
        return view('petugas.laboran.dashboard_laboran', compact(
            'todayResults',      // Hasil uji hari ini (5 data terbaru)
            'todayResultsCount', // Jumlah hasil uji hari ini
            'totalPatients',     // Total semua pasien
            'totalTests',        // Total semua hasil uji
            'chartLabels',       // Nama-nama bulan untuk label grafik
            'chartData',         // Data hasil uji per bulan untuk tahun sekarang
            'yearlyStats'        // Data hasil uji per bulan untuk beberapa tahun
        ));
    }

    /**
     * showByPasienRekamMedis()
     *
     * Fungsi ini buat nampilin detail semua hasil uji TB milik satu pasien tertentu.
     * Biasanya diakses dari bagian rekam medis.
     *
     * @param  int  $pasienId ID pasien yang hasil ujinya mau ditampilkan.
     * @return \Illuminate\Contracts\View\View
     */
    public function showByPasienRekamMedis($pasienId)
    {
        // Cari data pasien berdasarkan ID. Kalau gak ketemu, otomatis kasih error 404.
        $pasien = Pasien::findOrFail($pasienId);

        // Ambil semua hasil uji TB yang terkait dengan pasien ini, diurutkan dari yang terbaru.
        $hasilUji = $pasien->hasilUjiTB()->latest()->get();

        // Kirim data pasien dan hasil uji ke tampilan 'petugas.rekam_medis.detail_hasil_uji'.
        return view('petugas.rekam_medis.detail_hasil_uji', compact('pasien', 'hasilUji'));
    }
}