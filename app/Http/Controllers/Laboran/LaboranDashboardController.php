<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Carbon\Carbon;

class LaboranDashboardController extends Controller
{
    public function index()
    {
        // Mengambil data hasil uji yang diupload hari ini saja
        $todayResults = HasilUjiTB::whereDate('created_at', Carbon::today())
            ->with('pasien')
            ->latest()
            ->get();
        
        // Menghitung jumlah hasil uji hari ini
        $todayResultsCount = $todayResults->count();
        
        // Data statistik lainnya yang mungkin dibutuhkan di dashboard
        $totalPatients = Pasien::count();
        $totalTests = HasilUjiTB::count();
        
        // Statistik tambahan untuk laboran jika dibutuhkan
        $positiveTests = HasilUjiTB::where('status', 'Positif')->count();
        $negativeTests = HasilUjiTB::where('status', 'Negatif')->count();
        
        return view('laboran.dashboard_laboran', compact(
            'todayResults', 
            'todayResultsCount',
            'totalPatients',
            'totalTests',
            'positiveTests',
            'negativeTests'
        ));
    }
    public function showByPasienRekamMedis($pasienId)
{
    $pasien = Pasien::findOrFail($pasienId);
    $hasilUji = $pasien->hasilUjiTB()->latest()->get();

    return view('rekam_medis.DetailHasilUji', compact('pasien', 'hasilUji'));
}

}   