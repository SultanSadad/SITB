<?php

namespace App\Http\Controllers\HasilUji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\HasilUjiTB; // Tambahkan import model HasilUjiTB

class HasilUjiTBController extends Controller
{
    public function showByPasien($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
        $hasilUji = $pasien->hasilUjiTB()->latest()->get();

        return view('laboran.detail_laboran', compact('pasien', 'hasilUji'));
    }

    public function store(Request $request, $pasienId)
    {
        $request->validate([
            'tanggal_uji' => 'required|date',
            'tanggal_upload' => 'required|date',
            'status' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $file = $request->file('file');
        $path = $file->store('hasil-uji', 'public');

        $hasil = new HasilUjiTB();
        $hasil->pasien_id = $pasienId;
        $hasil->tanggal_uji = $request->tanggal_uji;
        $hasil->tanggal_upload = $request->tanggal_upload;
        $hasil->status = $request->status;
        $hasil->file = $path;
        $hasil->save();

        return redirect()->back()->with('success', 'Hasil uji berhasil ditambahkan');
    }

    public function hasilUji(Request $request)
    {
        $search = $request->input('search');

        $pasiens = Pasien::when($search, function ($query) use ($search) {
            return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->with('hasilUjiTB')
            ->latest()
            ->paginate(7);

        return view('laboran.hasil_uji', compact('pasiens'));
    }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $hasilUjiList = HasilUjiTB::with('pasien')
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('pasien', function ($q) use ($search) {
                    $q->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            ->latest()
            ->paginate(7);

        return view('rekam_medis.hasil_uji', compact('hasilUjiList'));
    }
}