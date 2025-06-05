<?php

namespace App\Http\Controllers\Petugas\Laboran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pasien;

class DataPasienLaboranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query(); // Inisialisasi query builder Pasien

        // Jika form pencarian diisi
        if ($request->filled('search')) {
            $search = strtolower($request->search); // Ubah ke huruf kecil untuk pencocokan case-insensitive

            // Filter nama, nik, no whatsapp, atau no_erm yang mengandung kata kunci
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Sorting berdasarkan field tertentu
        $sortField = $request->get('sort', 'created_at'); // Default: created_at
        $sortDirection = $request->get('direction', 'desc'); // Default: desc

        // Validasi agar hanya field tertentu yang boleh digunakan untuk sort
        $allowedSorts = ['no_erm', 'nama', 'nik', 'no_whatsapp', 'tanggal_lahir', 'created_at'];
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        // Jalankan query dengan sorting dan pagination
        $pasiens = $query->orderBy($sortField, $sortDirection)->paginate(9);

        // Bawa parameter pencarian & sort ke halaman berikutnya
        $pasiens->appends($request->all());

        // Tampilkan view daftar pasien
        return view('petugas.laboran.data_pasien', compact('pasiens', 'sortField', 'sortDirection'));

    }

    public function store(Request $request)
    {
        // Validasi input form
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik',
            'no_erm' => 'required|string|unique:pasiens,no_erm',
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp',
            'tanggal_lahir' => 'nullable|date',
        ]);

        // Simpan ke database
        Pasien::create($validated);

        // Redirect ke halaman data pasien dengan notifikasi sukses
        return redirect()->route('laboran.data-pasien')->with('success', 'Pasien berhasil ditambahkan');

    }

    public function update(Request $request, Pasien $pasien)
    {
        // Validasi input dengan pengecualian untuk data yang sedang diedit
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik,' . $pasien->id,
            'no_erm' => 'required|string|unique:pasiens,no_erm,' . $pasien->id,
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp,' . $pasien->id,
            'tanggal_lahir' => 'nullable|date',
        ]);

        // Update data ke database
        $pasien->update($validated);

        // Redirect kembali dengan notifikasi sukses
        return redirect()->route('laboran.data-pasien')->with('success', 'Data pasien berhasil diperbarui');

    }

    public function destroy(Pasien $pasien)
    {
        // Hapus data pasien dari database
        $pasien->delete();

        // Redirect kembali ke halaman data pasien
        return redirect()->route('laboran.data-pasien')->with('success', 'Pasien berhasil dihapus');

    }
}
