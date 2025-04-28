<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;

class LaboranController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::all(); // Mengambil semua data pasien    
        return view('laboran.hasil_uji', compact('pasiens'));
    }

    public function showDetail($pasienId)
    {
        $pasien = Pasien::with('hasilUjiTB')->findOrFail($pasienId);
        return view('laboran.detail_laboran', compact('pasien'));
    }
}