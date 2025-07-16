<?php
// Nama File   = DataPasienController.php 
// Deskripsi   = Controller ini bertanggung jawab untuk mengelola data pasien dari perspektif petugas rekam medis.
//               Fungsi yang disediakan meliputi: menampilkan daftar pasien dengan fitur pencarian, filter status verifikasi, dan pengurutan;
//               menambahkan pasien baru (beserta pembuatan akun user terkait), memperbarui data pasien yang sudah ada,
//               menghapus pasien (beserta akun user terkait), serta mengelola status verifikasi pasien.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\RekamMedis;

// Import Model Pasien (data pasien).
use App\Models\Pasien;
// Import Model User (data pengguna, untuk login).
use App\Models\User;
// Import Request untuk ambil data dari form atau URL.
use Illuminate\Http\Request;
// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Rule untuk validasi data unik atau kondisi lainnya.
use Illuminate\Validation\Rule;

class DataPasienController extends Controller
{
    /**
     * index()
     *
     * Fungsi ini buat nampilin daftar semua pasien untuk petugas rekam medis.
     * Ada fitur cari, filter berdasarkan status verifikasi, dan urut data.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request untuk input pencarian, filter, dan urutan.
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Mulai query untuk mengambil data pasien.
        $query = Pasien::query();

        // Jika ada input 'search' dari pengguna, lakukan pencarian.
        if ($request->filled('search')) {
            $search = strtolower($request->search); // Ubah input pencarian ke huruf kecil.
            // Cari pasien yang nama, NIK, No. ERM, WhatsApp, atau tanggal lahirnya mirip.
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(nik) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(no_erm) LIKE ?', ["%$search%"])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ["%$search%"])
                    ->orWhereRaw('CAST(tanggal_lahir AS TEXT) LIKE ?', ["%$search%"]); // Cari di tanggal lahir juga
            });
        }

        // Filter berdasarkan status verifikasi (sudah/belum diverifikasi).
        if ($request->has('verification_status')) {
            if ($request->verification_status === 'verified') {
                $query->where('verifikasi', true); // Hanya tampilkan yang sudah diverifikasi (true).
            } elseif ($request->verification_status === 'unverified') {
                $query->where('verifikasi', false); // Hanya tampilkan yang belum diverifikasi (false).
            }
        }

        // Tentukan kolom untuk mengurutkan data (default: 'nama' ASC).
        $sortField = $request->get('sort', 'nama');
        // Tentukan arah pengurutan (default: 'asc' / A-Z).
        $sortDirection = $request->get('direction', 'asc');

        // Logika sorting khusus jika kolom 'verifikasi' yang disortir.
        if ($sortField === 'verifikasi') {
            // Urutkan berdasarkan kelengkapan data: data yang lebih lengkap diutamakan.
            $query->orderByRaw("
            CASE
                WHEN no_erm IS NULL OR nama IS NULL OR nik IS NULL
                    OR tanggal_lahir IS NULL OR no_whatsapp IS NULL
                THEN 0 ELSE 1
            END " . strtoupper($sortDirection)); // 0 untuk tidak lengkap, 1 untuk lengkap.
        } else {
            // Urutkan berdasarkan kolom biasa yang diminta.
            $query->orderBy($sortField, $sortDirection);
        }

        // Ambil data pasien sesuai query, dan tampilkan 9 data per halaman.
        $pasiens = $query->paginate(9);

        // Tambahkan semua parameter filter dan sorting ke link pagination.
        $pasiens->appends($request->all());

        // Tampilkan view 'petugas.rekam_medis.data_pasien' dan kirim data yang dibutuhkan.
        return view('petugas.rekam_medis.data_pasien', compact('pasiens', 'sortField', 'sortDirection'));
    }

    /**
     * searchPasien()
     *
     * Fungsi ini buat mencari pasien secara "real-time" (biasanya untuk fitur autocomplete/live search).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi kata kunci pencarian.
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchPasien(Request $request)
    {
        $search = $request->get('search');

        // Cari pasien berdasarkan nama atau NIK, ambil maksimal 10 hasil.
        $pasiens = Pasien::where(function ($query) use ($search) {
            $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%']);
        })->limit(10)->get(['id', 'nama', 'nik', 'tanggal_lahir']); // Hanya ambil kolom yang penting.

        // Kembalikan hasil sebagai JSON (untuk digunakan oleh JavaScript).
        return response()->json($pasiens);
    }

    /**
     * create()
     *
     * Fungsi ini untuk menampilkan form tambah pasien. Karena formnya pakai modal,
     * fungsi ini hanya akan mengarahkan kembali ke halaman index (daftar pasien).
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        return redirect()->route('pasiens.index');
    }

    /**
     * store()
     *
     * Fungsi ini buat nyimpen data pasien baru ke database.
     * Sekalian bikin akun user (role 'pasien') untuk pasien tersebut.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi data form pasien.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form.
        // Pastikan 'no_erm' dan 'nama_pasien' wajib diisi. 'nik' dan 'no_whatsapp' harus unik.
        $request->validate([
            'no_erm' => 'required|string|unique:pasiens,no_erm',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik',
            'tanggal_lahir' => 'nullable|date',
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp',
        ]);

        try {
            // Buat data pasien baru di tabel 'pasiens'.
            $pasien = Pasien::create([
                'no_erm' => $request->no_erm,
                'nama' => $request->nama_pasien, // Sesuaikan nama kolom di database dengan input form.
                'nik' => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_whatsapp' => $request->no_whatsapp,
            ]);
            // Buat juga akun user baru dengan role 'pasien' dan kaitkan dengan ID pasien yang baru dibuat.
            User::create(['name' => $request->nama_pasien, 'role' => 'pasien', 'pasien_id' => $pasien->id]);

            // Redirect kembali ke halaman daftar pasien dengan pesan sukses.
            return redirect()->route('rekam-medis.pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Jika ada error, redirect dengan pesan error.
            return redirect()->route('rekam-medis.pasien.index')->with('error', 'Gagal menambahkan pasien.');
        }
    }

    /**
     * edit()
     *
     * Fungsi ini untuk menampilkan form edit pasien. Sama seperti `create()`,
     * karena form edit biasanya pakai modal, fungsi ini hanya redirect ke halaman index.
     *
     * @param  \App\Models\Pasien $pasien Objek Pasien yang akan diedit.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit(Pasien $pasien)
    {
        return redirect()->route('pasiens.index');
    }

    /**
     * show()
     *
     * Fungsi ini buat ambil detail satu pasien tertentu.
     * Biasa dipakai untuk ngisi data di modal edit lewat AJAX.
     *
     * @param  \App\Models\Pasien $pasien Objek Pasien yang detailnya mau ditampilkan.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Pasien $pasien)
    {
        // Kembalikan data pasien sebagai JSON.
        return response()->json($pasien);
    }

    /**
     * update()
     *
     * Fungsi ini buat update (mengubah) data pasien yang sudah ada.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi data update.
     * @param  \App\Models\Pasien $pasien Objek Pasien yang akan diupdate.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Pasien $pasien)
    {
        // Validasi data update.
        // 'unique:pasiens,nik,' . $pasien->id artinya cek unik, tapi lewati ID pasien ini sendiri.
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik,' . $pasien->id,
            'no_erm' => 'required|string|unique:pasiens,no_erm,' . $pasien->id,
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp,' . $pasien->id,
            'tanggal_lahir' => 'nullable|date',
        ]);

        try {
            // Update data pasien di database pakai data yang sudah divalidasi.
            $pasien->update($validated);

            // Redirect kembali ke halaman daftar pasien dengan pesan sukses.
            return redirect()->route('rekam-medis.pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
        } catch (\Exception $e) {
            // Jika ada error, redirect dengan pesan error.
            return redirect()->route('rekam-medis.pasien.index')->with('error', 'Gagal memperbarui data pasien.');
        }
    }

    /**
     * destroy()
     *
     * Fungsi ini buat menghapus data pasien dan akun user terkait dari database.
     *
     * @param  \App\Models\Pasien $pasien Objek Pasien yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pasien $pasien)
    {
        try {
            // Hapus akun user yang terkait dengan pasien ini.
            User::where('pasien_id', $pasien->id)->delete();
            // Hapus data pasien dari database.
            $pasien->delete();

            // Redirect kembali ke halaman daftar pasien dengan pesan sukses.
            return redirect()->route('rekam-medis.pasien.index')->with('success', 'Data pasien berhasil dihapus.');
        } catch (\Exception | \Throwable $e) { // Tangkap Throwable juga untuk error fatal
            // Jika ada error, redirect dengan pesan error.
            return redirect()->route('rekam-medis.pasien.index')->with('error', 'Gagal menghapus data pasien.');
        }
    }

    /**
     * verifikasi()
     *
     * Fungsi ini buat update status verifikasi pasien (biasanya dipanggil lewat AJAX).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request (berisi status verifikasi dari checkbox).
     * @param  \App\Models\Pasien $pasien Objek Pasien yang status verifikasinya mau diupdate.
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifikasi(Request $request, Pasien $pasien)
    {
        try {
            // Set status verifikasi pasien sesuai nilai dari request (true/false).
            $pasien->verifikasi = $request->verifikasi;
            $pasien->save(); // Simpan perubahan ke database.

            // Kirim respons sukses dalam bentuk JSON.
            return response()->json([
                'success' => true,
                'message' => $request->verifikasi ? 'Verifikasi pasien berhasil.' : 'Verifikasi pasien dibatalkan.',
                'type' => 'success_general'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi error, kirim respons error dalam bentuk JSON dengan kode status 500.
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status verifikasi. ' . $e->getMessage(),
                'type' => 'error'
            ], 500);
        }
    }
}