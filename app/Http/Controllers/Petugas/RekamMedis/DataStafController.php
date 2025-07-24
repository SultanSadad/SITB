<?php

// Nama File   = DataStafController.php
// Deskripsi   = Controller ini bertanggung jawab untuk mengelola data staf rumah sakit dari perspektif petugas rekam medis.
//               Fungsi yang disediakan meliputi: menampilkan daftar staf dengan fitur pencarian,
//               menambahkan staf baru (termasuk enkripsi password), memperbarui data staf yang sudah ada (dengan validasi unik dan opsionalitas password),
//               menghapus data staf, serta menyediakan endpoint AJAX untuk mengambil data staf tertentu (untuk form edit) dan melakukan pencarian dinamis.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\RekamMedis;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Pastikan ini mengarah ke model Staf Anda (misal: App\Models\Staf).
use App\Models\Staf;
// Import Request untuk ambil data dari form atau URL.
use Illuminate\Http\Request;
// Import Hash untuk mengenkripsi password.
use Illuminate\Support\Facades\Hash;
// Import Log untuk mencatat pesan error.
use Illuminate\Support\Facades\Log;
// Import Rule untuk validasi data unik atau kondisi lainnya.
use Illuminate\Validation\Rule;
// Import Rules\Password untuk validasi kekuatan password.
use Illuminate\Validation\Rules\Password;
// Import ValidationException untuk menangani error validasi.
use Illuminate\Validation\ValidationException;

class DataStafController extends Controller
{
    /**
     * index()
     *
     * Fungsi ini buat nampilin halaman daftar semua staf.
     * Ada fitur pencarian berdasarkan nama, email, NIP, atau peran.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request untuk input pencarian.
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Mulai query untuk mengambil data staf.
        $query = Staf::query();

        // Kalau ada input 'q' (query pencarian) dari pengguna:
        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = $request->q;
            // Cari staf yang nama, email, NIP, atau perannya mirip dengan kata kunci.
            $query->where(function ($q) use ($searchTerm) {
                $lowerSearch = strtolower($searchTerm);

                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$lowerSearch}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$lowerSearch}%"])
                    ->orWhereRaw('LOWER(nip) LIKE ?', ["%{$lowerSearch}%"])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ["%{$lowerSearch}%"])
                    ->orWhereRaw('LOWER(peran) LIKE ?', ["%{$lowerSearch}%"]);
            });
        }

        // Ambil data staf sesuai query, diurutkan dari yang terbaru, dan tampilkan 10 per halaman.
        $stafs = $query->latest()->paginate(10);

        // Tambahkan parameter pencarian ('q') ke link pagination.
        // Ini penting supaya hasil pencarian tetap ada saat pindah halaman.
        $stafs->appends(['q' => $request->q]);

        // Tampilkan view 'petugas.rekam_medis.data_staf' dan kirim data $stafs.
        return view('petugas.rekam_medis.data_staf', compact('stafs'));
    }

    /**
     * store()
     *
     * Fungsi ini buat nyimpen data staf baru ke database.
     * Ada validasi untuk memastikan data yang masuk benar dan unik.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi data form staf baru.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form.
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:staf,nip', // NIP boleh kosong, tapi harus unik kalau diisi.
            'email' => 'required|string|max:255|unique:staf,email', // Email wajib dan harus unik.
            'no_whatsapp' => 'nullable|string|max:255',
            'peran' => 'required|string', // Peran (misal: laboran, rekam medis) wajib diisi.
            'password' => ['required', 'confirmed', Password::min(8)], // Password wajib, harus sama dengan konfirmasi, min. 8 karakter.
        ]);

        try {
            // Buat data staf baru di database pakai data yang sudah divalidasi.
            Staf::create([
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'email' => $validated['email'],
                'no_whatsapp' => $validated['no_whatsapp'],
                'peran' => $validated['peran'],
                'password' => Hash::make($validated['password']), // Enkripsi password sebelum disimpan.
            ]);

            // Redirect kembali ke halaman daftar staf dengan pesan sukses.
            return redirect()->route('rekam-medis.staf.index')->with([
                'success_type' => 'success_add', // Tipe pesan sukses (untuk styling/skrip JS).
                'success_message' => 'Data staf Berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            // Kalau ada error, catat di log.
            Log::error('Gagal membuat staf: ' . $e->getMessage());
            // Redirect kembali dengan pesan error.
            return redirect()->route('rekam-medis.staf.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal menambahkan data staf.'
            ]);
        }
    }

    /**
     * update()
     *
     * Fungsi ini buat update (mengubah) data staf yang sudah ada.
     * Password bersifat opsional, hanya diupdate kalau diisi.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi data update.
     * @param  \App\Models\Staf $staf Objek Staf yang akan diupdate.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Staf $staf)
    {
        // Validasi data update.
        // Rule::unique('staf')->ignore($staf->id) artinya cek unik, tapi lewati ID staf ini sendiri.
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => ['nullable', 'string', 'max:255', Rule::unique('staf')->ignore($staf->id)],
            'email' => ['required', 'string', 'max:255', Rule::unique('staf')->ignore($staf->id)],
            'no_whatsapp' => 'nullable|string|max:255',
            'peran' => 'required|string',
            'password' => ['nullable', 'confirmed', Password::min(8)], // Password boleh kosong (nullable).
        ]);

        try {
            // Update data profil staf secara manual.
            $staf->nama = $validated['nama'];
            $staf->nip = $validated['nip'];
            $staf->email = $validated['email'];
            $staf->no_whatsapp = $validated['no_whatsapp'];
            $staf->peran = $validated['peran'];

            // Cek apakah kolom 'password' di form diisi oleh pengguna.
            if ($request->filled('password')) {
                // Jika diisi, enkripsi dan update passwordnya.
                $staf->password = Hash::make($request->password);
            }

            // Simpan semua perubahan ke database.
            $staf->save();

            // Redirect kembali ke halaman daftar staf dengan pesan sukses.
            return redirect()->route('rekam-medis.staf.index')->with([
                'success_type' => 'success_edit', // Tipe pesan sukses.
                'success_message' => 'Data staf berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            // Kalau ada error, catat di log.
            Log::error('Gagal update staf: ' . $e->getMessage());
            // Redirect kembali dengan pesan error.
            return redirect()->to('rekam-medis/data-staf')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal memperbarui data staf.'
            ]);
        }
    }

    /**
     * destroy()
     *
     * Fungsi ini buat menghapus data staf dari database.
     *
     * @param  \App\Models\Staf $staf Objek Staf yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Staf $staf)
    {
        try {
            // Langsung hapus data staf dari database.
            $staf->delete();
            // Redirect kembali ke halaman daftar staf dengan pesan sukses.
            return redirect()->route('rekam-medis.staf.index')->with([
                'success_type' => 'success_delete', // Tipe pesan sukses.
                'success_message' => 'Data Staf berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            // Kalau ada error, catat di log.
            Log::error('Gagal menghapus staf: ' . $e->getMessage());
            // Redirect kembali dengan pesan error.
            return redirect()->route('rekam-medis.staf.index')->with([
                'success_type' => 'error',
                'success_message' => 'Terjadi kesalahan saat menghapus data staf.'
            ]);
        }
    }

    /**
     * editData()
     *
     * Fungsi ini buat ambil data staf untuk ditampilkan di modal edit (biasanya pakai AJAX).
     *
     * @param  \App\Models\Staf $staf Objek Staf yang datanya mau diambil.
     * @return \Illuminate\Http\JsonResponse
     */
    public function editData(Staf $staf)
    {
        // Kembalikan data staf sebagai JSON.
        return response()->json($staf);
    }

    /**
     * searchStaf()
     *
     * Metode ini mengembalikan bagian HTML tabel staf yang sudah difilter/dicari.
     * Biasa dipakai untuk update tabel secara dinamis tanpa refresh halaman penuh (AJAX).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi kata kunci pencarian.
     * @return string (HTML)
     */
    public function searchStaf(Request $request)
    {
        $query = Staf::query();
        $searchTerm = $request->get('q');

        // Jika ada kata kunci pencarian:
        if (!empty($searchTerm)) {
            // Filter staf berdasarkan nama, email, NIP, WhatsApp, atau peran.
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('nip', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('no_whatsapp', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('peran', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Ambil data staf, urutkan dari terbaru, dan paginasi 10 data per halaman.
        $stafs = $query->latest()->paginate(10);
        // Tambahkan parameter pencarian ke link pagination.
        $stafs->appends(['q' => $searchTerm]);

        // Kembalikan partial view (hanya baris-baris tabel) yang sudah di-render.
        // Ini memungkinkan pembaruan bagian tabel saja tanpa memuat ulang seluruh halaman.
        return view('petugas.rekam_medis.partials.staf_table_rows', compact('stafs'))->render();
    }
}
