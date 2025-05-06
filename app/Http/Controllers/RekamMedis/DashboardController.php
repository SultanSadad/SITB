<?php

namespace App\Http\Controllers\RekamMedis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data hasil uji hari ini dengan pagination
        $todayResults = HasilUjiTB::whereDate('created_at', Carbon::today())
            ->with('pasien')
            ->latest()
            ->paginate(5); // PAGINATION: tampilkan 5 per halaman
        
        $todayResultsCount = $todayResults->total(); // total semua data, bukan cuma di halaman ini
        $totalPatients = Pasien::count();
        $totalTests = HasilUjiTB::count();
        
        return view('rekam_medis.dashboard_rekam_medis', compact(
            'todayResults', 
            'todayResultsCount',
            'totalPatients',
            'totalTests'
        ));
    }
    
}

