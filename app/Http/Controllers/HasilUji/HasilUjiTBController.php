<?php

namespace App\Http\Controllers\HasilUji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\HasilUjiTB;
use Carbon\Carbon;

class HasilUjiTBController extends Controller
{
    public function showByPasienRekamMedis($pasienId)
    {
        $pasien = Pasien::findOrFail($pasienId);
    
        // Ambil semua hasil uji (termasuk hari ini jika perlu)
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->get();
    
        return view('rekam_medis.DetailHasilUji', compact('pasien', 'hasilUjiList'));
    }
    public function showByPasien($pasienId)
{
    $pasien = Pasien::findOrFail($pasienId);
    
    // Ambil semua hasil uji (termasuk hari ini jika perlu)
    $hasilUjiList = $pasien->hasilUjiTB()->latest()->get();
    
    return view('laboran.detail_laboran', compact('pasien', 'hasilUjiList'));
}
    
    public function store(Request $request, $pasienId)
    {
        $request->validate([
            'tanggal_uji' => 'required|date',
            'tanggal_upload' => 'required|date|before_or_equal:today',
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
        // created_at akan otomatis diisi dengan timestamp saat ini
        $hasil->save();

        return redirect()->back()->with('success', 'Hasil uji berhasil ditambahkan');
    }

    

    public function index(Request $request)
{
    $search = $request->input('search');
    $startDate = $request->input('start');
    $endDate = $request->input('end');

    $pasiens = Pasien::when($search, function ($query) use ($search) {
        return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
            ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
            ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
    })
    ->with(['hasilUjiTB' => function($query) use ($startDate, $endDate) {
        // Apply date filters to the relationship query
        if ($startDate) {
            $query->whereDate('tanggal_uji', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('tanggal_uji', '<=', $endDate);
        }
    }])
    ->whereHas('hasilUjiTB', function($query) use ($startDate, $endDate) {
        // Ensure we only include patients that have results matching the date criteria
        if ($startDate) {
            $query->whereDate('tanggal_uji', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('tanggal_uji', '<=', $endDate);
        }
    })
    ->latest()
    ->paginate(6);

    // Append search and date filter parameters to pagination links
    $pasiens->appends([
        'search' => $search,
        'start' => $startDate,
        'end' => $endDate
    ]);

    return view('rekam_medis.DataHasilUji', compact('pasiens'));
}
public function indexLaboran(Request $request)
{
    $search = $request->input('search');
    $startDate = $request->input('start');
    $endDate = $request->input('end');

    // Query untuk mendapatkan SEMUA pasien tanpa filter hasil uji
    $pasiens = Pasien::when($search, function ($query) use ($search) {
        return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
            ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
            ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
    })
    ->with(['hasilUjiTB' => function($query) use ($startDate, $endDate) {
        // Apply date filters to the relationship query only
        if ($startDate) {
            $query->whereDate('tanggal_uji', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('tanggal_uji', '<=', $endDate);
        }
    }])
    // Hapus whereHas filter yang membatasi hanya pasien dengan hasil uji
    ->latest()
    ->paginate(6);

    // Append search and date filter parameters to pagination links
    $pasiens->appends([
        'search' => $search,
        'start' => $startDate,
        'end' => $endDate
    ]);

    return view('laboran.hasil_uji', compact('pasiens'));
}

    public function destroy($id)
    {
        $hasil = HasilUjiTB::findOrFail($id);

        // Hapus file dari storage
        if ($hasil->file && \Storage::disk('public')->exists($hasil->file)) {
            \Storage::disk('public')->delete($hasil->file);
        }

        $hasil->delete();

        return redirect()->back()->with('success', 'Hasil uji berhasil dihapus');
    }

    public function semuaHasilUji(Request $request)
{
    $search = $request->input('search');
    $startDate = $request->input('start');
    $endDate = $request->input('end');

    $hasilUjiList = HasilUjiTB::with('pasien')
    ->when($search, function ($query) use ($search) {
        $query->whereHas('pasien', function ($sub) use ($search) {
            $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
        });
    })
    
        ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
        ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
        ->latest()
        ->paginate(10);

    $hasilUjiList->appends($request->only(['search', 'start', 'end']));

    return view('laboran.DataHasilUji', compact('hasilUjiList'));
}


}