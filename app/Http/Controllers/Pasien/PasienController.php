<?php

namespace App\Http\Controllers\Pasien;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PasienController extends Controller
{
    // Menampilkan semua data pasien
    public function index(Request $request)
    {
        $query = Pasien::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $pasiens = $query->paginate(7);
        $pasiens->appends($request->all()); // Mempertahankan parameter search di pagination

        return view('rekam_medis.data_pasien', compact('pasiens'));
    }
    
   

    public function searchPasien(Request $request)
    {
        $search = $request->get('search');

        // Case-insensitive search, mencari di nama dan NIK
        $pasiens = Pasien::where(function ($query) use ($search) {
            $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->limit(10) // Batasi hasil untuk performa
            ->get(['id', 'nama', 'nik', 'tanggal_lahir']); // Ambil hanya field yang dibutuhkan

        return response()->json($pasiens);
    }


    // Menampilkan form tambah pasien
    public function create()
    {
        return view('pasiens.create');
    }

    // Menyimpan data pasien baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens',
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'nullable|string',
        ]);

        Pasien::create([
            'nama' => $request->nama_pasien,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_whatsapp' => $request->no_whatsapp,
        ]);


        return redirect()->route('pasiens.index');
    }

    // Menampilkan form edit pasien
    public function edit(Pasien $pasien)
    {
        return view('rekam_medis.data_pasien', compact('pasien'));
    }

    // Menyimpan perubahan data pasien
    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'nullable|string',
        ]);

        $pasien->update($request->all());

        return redirect()->route('pasiens.index');
    }

    // Menghapus data pasien
    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasiens.index');
    }
   // Tambahkan metode ini di PasienController.php
public function laboranIndex()
{
    $pasiens = Pasien::latest()->paginate(8); // Pagination dengan 6 item per halaman
    return view('laboran.hasil_uji', compact('pasiens'));
}
}