<?php

namespace App\Http\Controllers\RekamMedis;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'nik' => 'required|string|max:16|unique:pasien,nik',
        'tanggal_lahir' => 'required|date',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ], 422);
    }

    Pasien::create([
        'nama' => $request->nama,
        'nik' => $request->nik,
        'tanggal_lahir' => $request->tanggal_lahir,
        'alamat' => '-'
    ]);

    return response()->json(['success' => true]);
}
    public function dashboard()
{
    $pasien = Pasien::all(); // ambil semua data pasien
    return view('rekammedis.dashboard', compact('pasien'));
} 
}

