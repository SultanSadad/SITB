<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Http\Controllers\Controller;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardRekamMedisController extends Controller
{
    public function index()
    {
        $currentYear = now()->year;
        $dateColumn  = 'tanggal_uji';

    // Ringkasan
        $todayResults = HasilUjiTB::whereDate('created_at', now()->toDateString())
        ->with('pasien')->latest()->paginate(5);
        $todayResultsCount = $todayResults->total();
        $totalPatients     = Pasien::count();
        $totalTests        = HasilUjiTB::count();

    // Label bulan
        $chartLabels = [
        'Januari','Februari','Maret','April','Mei','Juni',
        'Juli','Agustus','September','Oktober','November','Desember'
        ];

    // === bedanya di sini ===
        $years = [$currentYear, $currentYear - 1, $currentYear - 2, $currentYear - 3];

        $yearlyStats = [];
        foreach ($years as $year) {
            $rows = HasilUjiTB::selectRaw("EXTRACT(MONTH FROM {$dateColumn})::int AS month, COUNT(*) AS total")
            ->whereYear($dateColumn, $year)
            ->groupBy(DB::raw("EXTRACT(MONTH FROM {$dateColumn})::int"))
            ->orderBy('month')
            ->get();

            $arr = array_fill(0, 12, 0);
            foreach ($rows as $r) {
                $arr[((int)$r->month) - 1] = (int)$r->total;
            }
            // simpan sebagai object keyed-by-year
            $yearlyStats[(string)$year] = $arr;
        }

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
