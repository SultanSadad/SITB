<?php

namespace App\Http\Controllers\Petugas\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardLaboranController extends Controller
{
    public function index()
    {
        // Hasil uji hari ini
        // Ambil hasil uji yang dibuat hari ini, beserta relasi pasien, urut terbaru dan paginasi
        $todayResults = HasilUjiTB::whereDate('created_at', Carbon::today())
            ->with('pasien')
            ->latest()
            ->paginate(5);

        // Hitung total hasil uji hari ini
        $todayResultsCount = $todayResults->total();

        // Hitung total seluruh pasien dan total hasil uji di database
        $totalPatients = Pasien::count();
        $totalTests = HasilUjiTB::count();

        // Ambil tahun sekarang dan 3 tahun sebelumnya
        $currentYear = Carbon::now()->year;
        $years = [$currentYear, $currentYear - 1, $currentYear - 2, $currentYear - 3];

        // Tentukan kolom tanggal yang digunakan untuk statistik bulanan
        $dateColumn = 'tanggal_uji'; // atau bisa diganti ke 'created_at' jika perlu

        // Label bulan untuk tampilan grafik
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

        // Ambil jumlah hasil uji per bulan untuk tahun saat ini
        $monthlyStats = HasilUjiTB::selectRaw("DATE_PART('month', {$dateColumn}) AS month, COUNT(*) AS total")
            ->whereYear($dateColumn, $currentYear)
            ->groupBy(DB::raw("DATE_PART('month', {$dateColumn})"))
            ->orderBy('month')
            ->get();

        // Inisialisasi array 12 bulan dengan nilai nol
        $chartData = array_fill(0, 12, 0);

        // Isi array berdasarkan data statistik aktual
        foreach ($monthlyStats as $stat) {
            $month = (int) $stat->month - 1; // Ubah ke indeks array (0-11)
            $chartData[$month] = $stat->total;
        }

        // Siapkan struktur data untuk statistik tahunan
        $yearlyStats = [];
        $yearlyStats[$currentYear] = $chartData;

        // Tambahkan data per bulan untuk tahun sebelumnya
        foreach ($years as $year) {
            if ($year == $currentYear)
                continue; // Tahun sekarang sudah diproses

            $prevYearStats = HasilUjiTB::selectRaw("DATE_PART('month', {$dateColumn}) AS month, COUNT(*) AS total")
                ->whereYear($dateColumn, $year)
                ->groupBy(DB::raw("DATE_PART('month', {$dateColumn})"))
                ->orderBy('month')
                ->get();

            $yearData = array_fill(0, 12, 0);
            foreach ($prevYearStats as $stat) {
                $month = (int) $stat->month - 1;
                $yearData[$month] = $stat->total;
            }

            $yearlyStats[$year] = $yearData;
        }

        // Kirim semua data ke tampilan dashboard laboran
        return view('petugas.laboran.dashboard_laboran', compact(
            'todayResults',
            'todayResultsCount',
            'totalPatients',
            'totalTests',
            'chartLabels',
            'chartData',
            'yearlyStats'
        ));

    }

    public function showByPasienRekamMedis($pasienId)
    {
        // Cari data pasien berdasarkan ID yang dikirimkan
        $pasien = Pasien::findOrFail($pasienId);

        // Ambil seluruh hasil uji milik pasien tersebut, terbaru di atas
        $hasilUji = $pasien->hasilUjiTB()->latest()->get();

        // Kirim data pasien dan hasil uji ke view detail_hasil_uji
        return view('petugas.rekam_medis.detail_hasil_uji', compact('pasien', 'hasilUji'));

    }
}