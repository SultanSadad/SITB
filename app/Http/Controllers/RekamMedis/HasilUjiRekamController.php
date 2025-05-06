<?php

namespace App\Http\Controllers\RekamMedis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HasilUjiTB;
use Illuminate\Support\Facades\Storage; // Tambahkan import ini

class HasilUjiRekamController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');
    $startDate = $request->input('start');
    $endDate = $request->input('end');

    // Ambil data hasil uji langsung seperti di laboran
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

    return view('rekam_medis.DataHasilUji', compact('hasilUjiList'));
}

    public function destroy($id)
    {
        $hasil = HasilUjiTB::findOrFail($id);

        // Hapus file dari storage
        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) { // Gunakan Storage di sini
            Storage::disk('public')->delete($hasil->file);
        }

        $hasil->delete();

        return redirect()->back()->with('success', 'Hasil uji berhasil dihapus');
    }
}
