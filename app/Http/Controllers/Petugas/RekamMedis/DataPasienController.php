<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule; // Pastikan ini sudah ada

class DataPasienController extends Controller
{
    public function index(Request $request)
    {
        // Mulai query builder dari model Pasien
        $query = Pasien::query();

        // Jika input search tidak kosong, lakukan pencarian (case-insensitive)
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(nik) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(no_erm) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ["%$search%"])
                    ->orWhereRaw('CAST(tanggal_lahir AS TEXT) LIKE ?', ["%$search%"]);
            });
        }

        // Filter berdasarkan status verifikasi
        if ($request->has('verification_status')) {
            if ($request->verification_status === 'verified') {
                $query->where('verifikasi', true); // Tampilkan yang sudah diverifikasi
            } elseif ($request->verification_status === 'unverified') {
                $query->where('verifikasi', false); // Tampilkan yang belum diverifikasi
            }
        }

        // Tentukan kolom sorting dan arah (default: nama ASC)
        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');

        // Sorting khusus jika field yang disortir adalah 'verifikasi'
        if ($sortField === 'verifikasi') {
            // Urutkan berdasarkan kelengkapan data (data yang lengkap diurutkan lebih dulu)
            $query->orderByRaw("
            CASE
                WHEN no_erm IS NULL OR nama IS NULL OR nik IS NULL
                    OR tanggal_lahir IS NULL OR no_whatsapp IS NULL
                THEN 0 ELSE 1
            END " . strtoupper($sortDirection));
        } else {
            // Urutkan berdasarkan kolom biasa
            $query->orderBy($sortField, $sortDirection);
        }

        // Paginate hasil query (9 pasien per halaman)
        $pasiens = $query->paginate(9);

        // Tambahkan parameter filter ke pagination
        $pasiens->appends($request->all());

        // Tampilkan view dengan data
        return view('petugas.rekam_medis.data_pasien', compact('pasiens', 'sortField', 'sortDirection'));
    }

    public function searchPasien(Request $request)
    {
        $search = $request->get('search');

        // Cari pasien berdasarkan nama atau NIK (limit 10 untuk live search)
        $pasiens = Pasien::where(function ($query) use ($search) {
            $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%']);
        })->limit(10)->get(['id', 'nama', 'nik', 'tanggal_lahir']); // Hanya ambil field yang diperlukan

        return response()->json($pasiens); // Kembalikan sebagai JSON untuk AJAX/autocomplete
    }


    public function create()
    {
        // Karena form tambah pasien menggunakan modal (bukan halaman baru),
        // langsung redirect ke halaman data_pasien (index)
        return redirect()->route('pasiens.index');
    }


    // Menyimpan data pasien baru ke database
    public function store(Request $request)
    {
        // Validasi input, cek unique dan required sesuai field
        $request->validate([
            'no_erm' => 'required|string|unique:pasiens,no_erm',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik',
            'tanggal_lahir' => 'nullable|date',
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp',
        ], [
            // Kustomisasi pesan error
            'no_erm.unique' => 'Nomor ERM sudah digunakan pasien lain.',
            'nik.unique' => 'NIK sudah digunakan pasien lain.',
            'no_whatsapp.unique' => 'Nomor WhatsApp sudah digunakan pasien lain.',
            'nama_pasien.required' => 'Nama pasien wajib diisi.'
        ]);

        try {
            // Simpan data ke tabel `pasiens`
            $pasien = Pasien::create([
                'no_erm' => $request->no_erm,
                'nama' => $request->nama_pasien,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_whatsapp' => $request->no_whatsapp,
            ]);

            // Buat akun user default untuk pasien
            User::create([
                'name' => $request->nama_pasien,
                'email' => null,
                'password' => null,
                'role' => 'pasien',
                'pasien_id' => $pasien->id,
            ]);

            // Redirect dengan notifikasi sukses (modal)
            return redirect()->route('pasiens.index')->with([
                'success_type' => 'success_add',
                'success_message' => 'Data pasien berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            // Tangani error dan kembalikan notifikasi error
            return redirect()->route('pasiens.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal menambahkan pasien. Pesan error: ' . $e->getMessage()
            ]);
        }
    }


    // Tidak membuka halaman edit khusus, karena modal dipicu JS
    public function edit(Pasien $pasien)
    {
        return redirect()->route('pasiens.index');
    }


    // Memperbarui data pasien
    public function update(Request $request, Pasien $pasien)
    {
        // Validasi input, tapi abaikan field milik pasien itu sendiri (pakai pengecualian ID)
        $request->validate([
            'no_erm' => 'required|string|unique:pasiens,no_erm,' . $pasien->id,
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'nullable|date',
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp,' . $pasien->id,
        ], [
            'nik.unique' => 'NIK sudah digunakan pasien lain.',
            'no_whatsapp.unique' => 'Nomor WhatsApp sudah digunakan pasien lain.',
            'nama.required' => 'Nama pasien wajib diisi.'
        ]);

        try {
            // Update data pasien
            $pasien->update([
                'no_erm' => $request->no_erm,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_whatsapp' => $request->no_whatsapp,
            ]);

            // Sinkronkan nama user jika ada user-nya
            $user = User::where('pasien_id', $pasien->id)->where('role', 'pasien')->first();
            if ($user) {
                $user->name = $request->nama;
                $user->save();
            }

            return redirect()->route('pasiens.index')->with([
                'success_type' => 'success_edit',
                'success_message' => 'Data pasien berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('pasiens.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal memperbarui data pasien. Pesan error: ' . $e->getMessage()
            ]);
        }
    }


    // Menghapus pasien dan user terkait
    public function destroy(Pasien $pasien)
    {
        try {
            // Hapus akun user yang terkait dengan pasien
            User::where('pasien_id', $pasien->id)->where('role', 'pasien')->delete();
            $pasien->delete();

            return redirect()->route('pasiens.index')->with([
                'success_type' => 'success_delete',
                'success_message' => 'Data pasien berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return redirect()->route('pasiens.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal menghapus data pasien. Pesan error: ' . $e->getMessage()
            ]);
        }
    }


    // Tambahkan metode ini jika ada di route kamu untuk AJAX verifikasi
    // Mengubah status verifikasi pasien via AJAX
    public function verifikasi(Request $request, Pasien $pasien)
    {
        try {
            $pasien->verifikasi = $request->verifikasi;
            $pasien->save();

            return response()->json([
                'success' => true,
                'message' => $request->verifikasi ? 'Verifikasi pasien berhasil.' : 'Verifikasi pasien dibatalkan.',
                'type' => 'success_general'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status verifikasi. ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }

}