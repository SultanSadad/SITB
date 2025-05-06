<?php

namespace App\Http\Controllers\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\Staf;

class LaboranController extends Controller
{
    public function index()
{
    $pasiens = Pasien::paginate(10); // Mengambil data dengan pagination, 10 data per halaman
    return view('laboran.hasil_uji', compact('pasiens'));
}

    public function showDetail($pasienId)
    {
        $pasien = Pasien::with('hasilUjiTB')->findOrFail($pasienId);
        return view('laboran.detail_laboran', compact('pasien'));
    }

    // If this is intended to create staff, it should create a Staf model not a Pasien model
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:staf',
            'email' => 'required|email|unique:staf',
            'no_whatsapp' => 'nullable|string',
            'peran' => 'required|in:laboran,rekam_medis', // Changed from 'role' to 'peran'
        ]);
    
        Staf::create([  // Changed from Pasien to Staf
            'nama' => $request->nama,
            'nip' => $request->nip,
            'email' => $request->email,
            'no_whatsapp' => $request->no_whatsapp,
            'peran' => $request->peran, // Changed from 'role' to 'peran'
        ]);
    
        return redirect()->route('stafs.index')->with('success', 'Data staf berhasil ditambahkan.');
    }
}