<?php

// Nama File   = DataPasienLaboranController.php
// Deskripsi   = Controller ini bertanggung jawab untuk mengelola data pasien dari perspektif petugas laboran.
//               Fungsi utamanya meliputi menampilkan daftar pasien dengan fitur pencarian dan pengurutan,
//               menambahkan pasien baru, memperbarui informasi pasien yang sudah ada, dan menghapus data pasien.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\Laboran;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Request untuk ambil data dari form atau URL.
use Illuminate\Http\Request;
// Import Model Pasien (data pasien).
use App\Models\Pasien;

class DataPasienLaboranController extends Controller
{
    /**
     * index()
     *
     * Fungsi ini buat nampilin daftar semua pasien.
     * Ada fitur cari dan urut data pasien.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request untuk ambil inputan pencarian dan urutan.
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Buat query dasar untuk ambil data pasien.
        $query = Pasien::query();

        // Kalau ada input 'search' dari pengguna:
        if ($request->filled('search')) {
            $search = strtolower($request->search); // Ubah input pencarian ke huruf kecil.
            // Cari pasien yang nama, NIK, WhatsApp, atau No. ERM-nya mirip dengan input search.
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . $search . '%'])
                    ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . $search . '%']);
            });
        }

        // Tentukan kolom untuk mengurutkan data (default: 'created_at').
        $sortField = $request->get('sort', 'created_at');
        // Tentukan arah pengurutan (default: 'desc' / dari terbaru ke terlama).
        $sortDirection = $request->get('direction', 'desc');

        // Daftar kolom yang boleh dipakai untuk mengurutkan.
        $allowedSorts = ['no_erm', 'nama', 'nik', 'no_whatsapp', 'tanggal_lahir', 'created_at'];
        // Kalau kolom yang diminta gak ada di daftar yang diizinkan, pakai 'created_at' saja.
        if (!in_array($sortField, $allowedSorts)) {
            $sortField = 'created_at';
        }

        // Ambil data pasien sesuai query, urutkan, dan tampilkan 9 data per halaman.
        $pasiens = $query->orderBy($sortField, $sortDirection)->paginate(9);
        // Tambahkan parameter pencarian dan urutan ke link pagination biar filternya tetap aktif.
        $pasiens->appends($request->all());

        // Tampilkan view 'petugas.laboran.data_pasien' dan kirim data yang dibutuhkan.
        return view('petugas.laboran.data_pasien', compact('pasiens', 'sortField', 'sortDirection'));
    }

    /**
     * store()
     *
     * Fungsi ini buat nyimpen data pasien baru yang dikirim dari form.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi data form.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk dari form.
        // Pastikan 'nama' wajib diisi. 'nik', 'no_erm', 'no_whatsapp' harus unik (kalau diisi).
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'nullable|string|unique:pasiens,nik',
            'no_erm' => 'required|string|unique:pasiens,no_erm',
            'no_whatsapp' => 'nullable|string|unique:pasiens,no_whatsapp',
            'tanggal_lahir' => 'nullable|date',
        ]);

        // Buat data pasien baru di database pakai data yang sudah divalidasi.
        Pasien::create($validated);

        // Redirect kembali ke halaman daftar pasien dengan pesan sukses.
        return redirect()->route('laboran.pasien.index')->with('success', 'Pasien berhasil ditambahkan');
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

        // Update data pasien di database pakai data yang sudah divalidasi.
        $pasien->update($validated);

        // Redirect kembali ke halaman daftar pasien dengan pesan sukses.
        // Menggunakan `redirect()->to()` karena rute `laboran/data-pasien` mungkin tidak punya nama.
        return redirect()->to('laboran/data-pasien')->with('success', 'Data pasien berhasil diperbarui');
    }

    /**
     * destroy()
     *
     * Fungsi ini buat menghapus data pasien dari database.
     *
     * @param  \App\Models\Pasien $pasien Objek Pasien yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Pasien $pasien)
    {
        // Hapus data pasien dari database.
        $pasien->delete();

        // Redirect kembali ke halaman daftar pasien dengan pesan sukses.
        return redirect()->route('laboran.pasien.index')->with('success', 'Pasien berhasil dihapus');
    }
}
