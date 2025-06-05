<?php

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
        // Ambil input pencarian dan rentang tanggal dari form
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Query data pasien berdasarkan pencarian dan hasil uji berdasarkan tanggal
        $pasiens = Pasien::when($search, function ($query) use ($search) {
            return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->with([
                // Jika ada filter tanggal, filter relasi hasil uji per pasien
                'hasilUjiTB' => function ($query) use ($startDate, $endDate) {
                    if ($startDate)
                        $query->whereDate('tanggal_uji', '>=', $startDate);
                    if ($endDate)
                        $query->whereDate('tanggal_uji', '<=', $endDate);
                }
            ])
            ->latest() // Urutkan pasien terbaru
            ->paginate(10); // Paginasi 10 pasien per halaman

        // Tambahkan filter ke pagination
        $pasiens->appends($request->only(['search', 'start', 'end']));

        // Tampilkan ke view
        return view('petugas.laboran.hasil_uji', compact('pasiens'));
    }


    public function show($pasienId)
    {
        // Ambil data pasien berdasarkan ID
        $pasien = Pasien::findOrFail($pasienId);

        // Ambil daftar hasil uji untuk pasien tersebut (paginasi 9 item)
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(9);

        // Simpan filter sebelumnya untuk pagination
        $hasilUjiList->appends(request()->all());

        // Tampilkan detail hasil uji
        return view('petugas.laboran.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }



    public function store(Request $request, $pasienId)
    {
        try {
            // Validasi input dari form
            $request->validate([
                'tanggal_uji' => 'required|date',
                'tanggal_upload' => 'required|date|before_or_equal:today',
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            ]);

            // Upload file dan simpan ke storage
            $file = $request->file('file');
            $path = $file->store('hasil-uji', 'public');

            // Simpan data hasil uji ke database
            $hasil = new HasilUjiTB();
            $hasil->pasien_id = $pasienId;
            $hasil->staf_id = auth()->user()->staf_id;
            $hasil->tanggal_uji = $request->tanggal_uji;
            $hasil->tanggal_upload = $request->tanggal_upload;
            $hasil->file = $path;
            $hasil->save();

            return redirect()->back()->with('success', 'Hasil uji berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangani error dan tampilkan pesan
            Log::error('Upload error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        // Temukan hasil uji berdasarkan ID
        $hasil = HasilUjiTB::findOrFail($id);

        // Hapus file dari storage jika ada
        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            Storage::disk('public')->delete($hasil->file);
        }

        // Hapus data hasil uji dari database
        $hasil->delete();

        return redirect()->back()->with('success', 'Hasil uji berhasil dihapus');
    }


    public function semuaHasilUji(Request $request)
    {
        // Ambil parameter dari URL
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');
        $sort = $request->input('sort', 'tanggal_upload');
        $direction = $request->input('direction', 'desc');

        // Batasi hanya sorting kolom tertentu
        $allowedSorts = ['nik', 'nama', 'tanggal_upload', 'no_whatsapp', 'tanggal_uji'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'tanggal_upload';
        }

        // Ambil data hasil uji beserta pasien
        $hasilUjiList = HasilUjiTB::with('pasien')
            ->whereNotNull('file') // hanya hasil uji yang memiliki file
            ->when($search, function ($query) use ($search) {
                // Filter berdasarkan pasien yang cocok dengan pencarian
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            // Filter berdasarkan tanggal
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            // Sorting dinamis (jika kolom dari tabel pasien, join dulu)
            ->when(in_array($sort, ['nik', 'nama', 'no_whatsapp']), function ($query) use ($sort, $direction) {
                $query->join('pasiens', 'pasiens.id', '=', 'hasil_uji_t_b_s.pasien_id')
                    ->orderBy("pasiens.$sort", $direction)
                    ->select('hasil_uji_t_b_s.*');
            }, function ($query) use ($sort, $direction) {
                $query->orderBy($sort ?? 'tanggal_uji', $direction ?? 'desc');
            })
            ->paginate(9);

        // Tambahkan query string ke pagination
        $hasilUjiList->appends($request->only(['search', 'start', 'end', 'sort', 'direction']));

        return view('petugas.laboran.riwayat_hasil_uji', compact('hasilUjiList'));
    }


    public function updateVerifikasi(Request $request, $id)
    {
        try {
            // Cari pasien berdasarkan ID
            $pasien = Pasien::findOrFail($id);

            // Update status verifikasi sesuai checkbox
            $pasien->verifikasi = $request->verifikasi ? true : false;
            $pasien->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Tangani error jika gagal update
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

}
