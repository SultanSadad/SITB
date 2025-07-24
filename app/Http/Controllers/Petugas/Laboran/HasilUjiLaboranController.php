<?php

// Nama File   = HasilUjiLaboranController.php
// Deskripsi   = Controller ini mengelola proses terkait hasil uji TBC dari perspektif petugas laboran.
//               Fungsi yang disediakan meliputi:
//               - Menampilkan daftar pasien beserta hasil uji mereka (dengan filter dan pencarian),
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025

namespace App\Http\Controllers\Petugas\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\HasilUjiTB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HasilUjiLaboranController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        $pasiens = Pasien::when($search, function ($query) use ($search) {
            return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->with([
                'hasilUjiTB' => function ($query) use ($startDate, $endDate) {
                    if ($startDate) {
                        $query->whereDate('tanggal_uji', '>=', $startDate);
                    }
                    if ($endDate) {
                        $query->whereDate('tanggal_uji', '<=', $endDate);
                    }
                }
            ])
            ->latest()
            ->paginate(10);

        $pasiens->appends($request->only(['search', 'start', 'end']));

        return view('petugas.laboran.hasil_uji', compact('pasiens'));
    }

    public function show($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(9);
        $hasilUjiList->appends(request()->all());

        return view('petugas.laboran.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }

    public function store(Request $request, $pasienId)
    {
        try {
            $request->validate([
                'tanggal_uji' => 'required|date',
                'tanggal_upload' => 'required|date|before_or_equal:today',
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            ]);

            $file = $request->file('file');
            $path = $file->store('hasil-uji', 'public');

            $hasil = new HasilUjiTB();
            $hasil->pasien_id = $pasienId;
            $hasil->staf_id = auth()->user()->staf_id;
            $hasil->tanggal_uji = $request->tanggal_uji;
            $hasil->tanggal_upload = $request->tanggal_upload;
            $hasil->file = $path;
            $hasil->save();

            return redirect()
                ->route('laboran.hasil-uji.show', $pasienId)
                ->with('success', 'Hasil uji berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $hasil = HasilUjiTB::findOrFail($id);
        $pasienId = $hasil->pasien_id;

        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            Storage::disk('public')->delete($hasil->file);
        }

        $hasil->delete();

        return redirect()
            ->route('laboran.hasil-uji.show', $pasienId)
            ->with('success', 'Hasil uji berhasil dihapus');
    }

    public function semuaHasilUji(Request $request)
    {
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');
        $sort = $request->input('sort', 'tanggal_upload');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['nik', 'nama', 'tanggal_upload', 'no_whatsapp', 'tanggal_uji'];

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'tanggal_upload';
        }

        $hasilUjiList = HasilUjiTB::with('pasien')
            ->whereNotNull('file')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->when(in_array($sort, ['nik', 'nama', 'no_whatsapp']), function ($query) use ($sort, $direction) {
                $query->join('pasiens', 'pasiens.id', '=', 'hasil_uji_t_b_s.pasien_id')
                    ->orderBy("pasiens.$sort", $direction)
                    ->select('hasil_uji_t_b_s.*');
            }, function ($query) use ($sort, $direction) {
                $query->orderBy($sort ?? 'tanggal_uji', $direction ?? 'desc');
            })
            ->paginate(9);

        $hasilUjiList->appends($request->only(['search', 'start', 'end', 'sort', 'direction']));

        return view('petugas.laboran.riwayat_hasil_uji', compact('hasilUjiList'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            $pasien->verifikasi = $request->verifikasi ? true : false;
            $pasien->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Verifikasi update error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
