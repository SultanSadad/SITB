<?php

// Nama File   = HasilUjiLaboranController.php
// Deskripsi   = Controller ini mengelola proses terkait hasil uji TBC dari perspektif petugas laboran.
//               Fungsi yang disediakan meliputi: menampilkan daftar pasien beserta hasil uji mereka (dengan filter dan pencarian),
//               menampilkan detail semua hasil uji untuk pasien tertentu, menyimpan hasil uji baru (termasuk upload file),
//               menghapus hasil uji beserta file-nya, menampilkan semua riwayat hasil uji dari semua pasien,
//               serta mengelola status verifikasi pasien.
// Dibuat oleh = Sultan Sadad- 3312301102
// Tanggal     = 4 April 2025
namespace App\Http\Controllers\Petugas\Laboran;

// Import Controller dasar Laravel.
use App\Http\Controllers\Controller;
// Import Request untuk ambil data dari form atau URL.
use Illuminate\Http\Request;
// Import Model Pasien (data pasien).
use App\Models\Pasien;
// Import Model HasilUjiTB (data hasil uji TB).
use App\Models\HasilUjiTB;
// Import Log untuk mencatat pesan error.
use Illuminate\Support\Facades\Log;
// Import Storage untuk kelola file (simpan, ambil, hapus).
use Illuminate\Support\Facades\Storage;

class HasilUjiLaboranController extends Controller
{
    /**
     * index()
     *
     * Fungsi ini buat nampilin daftar pasien beserta hasil uji TB mereka.
     * Ada fitur cari pasien dan filter hasil uji berdasarkan rentang tanggal.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request untuk input pencarian dan filter tanggal.
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        // Ambil inputan dari form pencarian (nama, NIK, dll) dan rentang tanggal.
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');

        // Ambil data pasien.
        $pasiens = Pasien::when($search, function ($query) use ($search) {
            // Jika ada input 'search', filter pasien berdasarkan nama, NIK, WhatsApp, atau No. ERM.
            return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->with([
                // Muat relasi `hasilUjiTB` (data hasil uji pasien).
                'hasilUjiTB' => function ($query) use ($startDate, $endDate) {
                    // Jika ada tanggal mulai, filter hasil uji dari tanggal tersebut atau setelahnya.
                    if ($startDate) {
                        $query->whereDate('tanggal_uji', '>=', $startDate);
                    }
                    // Jika ada tanggal akhir, filter hasil uji sampai tanggal tersebut atau sebelumnya.
                    if ($endDate) {
                        $query->whereDate('tanggal_uji', '<=', $endDate);
                    }
                }
            ])
            ->latest() // Urutkan daftar pasien dari yang terbaru dibuat.
            ->paginate(10); // Tampilkan 10 pasien per halaman.

        // Tambahkan parameter filter ke link pagination agar filternya tetap aktif saat pindah halaman.
        $pasiens->appends($request->only(['search', 'start', 'end']));

        // Tampilkan view 'petugas.laboran.hasil_uji' dan kirim data $pasiens.
        return view('petugas.laboran.hasil_uji', compact('pasiens'));
    }

    /**
     * show()
     *
     * Fungsi ini buat nampilin semua hasil uji TB untuk satu pasien tertentu.
     *
     * @param  int  $pasienId ID pasien yang hasil ujinya mau ditampilkan.
     * @return \Illuminate\Contracts\View\View
     */
    public function show($pasienId)
    {
        // Cari data pasien berdasarkan ID. Kalau gak ketemu, otomatis kasih error 404 (Not Found).
        $pasien = Pasien::findOrFail($pasienId);

        // Ambil semua hasil uji TB milik pasien tersebut, diurutkan dari yang terbaru, dan paginasi 9 item per halaman.
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(9);

        // Tambahkan parameter query string yang ada ke link pagination.
        $hasilUjiList->appends(request()->all());

        // Tampilkan view 'petugas.laboran.detail_hasil_uji' dan kirim data pasien serta daftar hasil uji.
        return view('petugas.laboran.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }

    /**
     * store()
     *
     * Fungsi ini buat nyimpen data hasil uji TB baru beserta file-nya ke database dan storage.
     *
     * @param  \Illuminate\Http\Request  $request Objek Request yang berisi data form (tanggal, file).
     * @param  int  $pasienId ID pasien yang akan ditambahkan hasil ujinya.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, $pasienId)
    {
        try {
            // Validasi input dari form.
            // 'tanggal_uji' & 'tanggal_upload' wajib diisi dan format tanggal.
            // 'tanggal_upload' tidak boleh lebih dari tanggal hari ini.
            // 'file' wajib, harus berupa PDF/gambar/doc, dan maksimal 10MB.
            $request->validate([
                'tanggal_uji' => 'required|date',
                'tanggal_upload' => 'required|date|before_or_equal:today',
                'file' => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240', // max 10MB
            ]);

            // Ambil file yang diupload.
            $file = $request->file('file');
            // Simpan file ke folder 'hasil-uji' di storage publik.
            $path = $file->store('hasil-uji', 'public');

            // Buat objek `HasilUjiTB` baru.
            $hasil = new HasilUjiTB();
            // Isi data hasil uji.
            $hasil->pasien_id = $pasienId; // ID pasien yang terkait.
            $hasil->staf_id = auth()->user()->staf_id; // ID staf (laboran) yang mengupload.
            $hasil->tanggal_uji = $request->tanggal_uji; // Tanggal uji dari form.
            $hasil->tanggal_upload = $request->tanggal_upload; // Tanggal upload dari form.
            $hasil->file = $path; // Path (lokasi) file yang sudah diupload.
            $hasil->save(); // Simpan data ke database.

            // Redirect kembali ke halaman detail hasil uji pasien dengan pesan sukses.
            return redirect()->route('laboran.hasil-uji.show', $pasienId)->with('success', 'Hasil uji berhasil ditambahkan');
        } catch (\Exception $e) {
            // Jika terjadi error saat proses, catat errornya di log.
            Log::error('Upload error: ' . $e->getMessage());
            // Redirect kembali ke halaman sebelumnya dengan pesan error.
            return redirect()->back()->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    /**
     * destroy()
     *
     * Fungsi ini buat menghapus data hasil uji TB dan file terkait dari storage.
     *
     * @param  int  $id ID dari HasilUjiTB yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        // Cari data HasilUjiTB berdasarkan ID. Kalau gak ketemu, kasih error 404.
        $hasil = HasilUjiTB::findOrFail($id);
        // Simpan ID pasien sebelum data hasil uji dihapus, karena akan dipakai untuk redirect.
        $pasienId = $hasil->pasien_id;

        // Cek apakah ada file terkait dan file tersebut ada di storage.
        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            // Jika ada, hapus file dari storage.
            Storage::disk('public')->delete($hasil->file);
        }

        // Hapus data hasil uji dari database.
        $hasil->delete();

        // Redirect kembali ke halaman detail hasil uji pasien dengan pesan sukses.
        return redirect()->route('laboran.hasil-uji.show', $pasienId)->with('success', 'Hasil uji berhasil dihapus');
    }

    /**
     * semuaHasilUji()
     *
     * Fungsi ini buat nampilin daftar SEMUA hasil uji TB dari semua pasien.
     * Ada fitur pencarian, filter tanggal, dan pengurutan (sorting).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request untuk input pencarian, filter, dan sorting.
     * @return \Illuminate\Contracts\View\View
     */
    public function semuaHasilUji(Request $request)
    {
        // Ambil parameter dari URL untuk pencarian, filter tanggal, dan sorting.
        $search = $request->input('search');
        $startDate = $request->input('start');
        $endDate = $request->input('end');
        $sort = $request->input('sort', 'tanggal_upload'); // Kolom sorting (default: tanggal_upload).
        $direction = $request->input('direction', 'desc'); // Arah sorting (default: descending/terbaru).

        // Daftar kolom yang diizinkan untuk sorting.
        $allowedSorts = ['nik', 'nama', 'tanggal_upload', 'no_whatsapp', 'tanggal_uji'];
        // Jika kolom sorting yang diminta tidak diizinkan, pakai 'tanggal_upload'.
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'tanggal_upload';
        }

        // Ambil semua data hasil uji TB, beserta data pasien terkait.
        $hasilUjiList = HasilUjiTB::with('pasien')
            ->whereNotNull('file') // Hanya tampilkan hasil uji yang ada filenya.
            ->when($search, function ($query) use ($search) {
                // Jika ada input 'search', filter hasil uji berdasarkan data pasien yang cocok.
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            // Filter berdasarkan tanggal uji jika 'startDate' atau 'endDate' diisi.
            ->when($startDate, fn($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            // Logika sorting data:
            ->when(in_array($sort, ['nik', 'nama', 'no_whatsapp']), function ($query) use ($sort, $direction) {
                // Jika kolom sorting berasal dari tabel 'pasiens' (relasi), lakukan JOIN.
                $query->join('pasiens', 'pasiens.id', '=', 'hasil_uji_t_b_s.pasien_id')
                    ->orderBy("pasiens.$sort", $direction) // Urutkan berdasarkan kolom di tabel pasien.
                    ->select('hasil_uji_t_b_s.*'); // Pastikan hanya memilih kolom dari tabel hasil_uji_t_b_s.
            }, function ($query) use ($sort, $direction) {
                // Jika kolom sorting dari tabel 'hasil_uji_t_b_s' itu sendiri.
                $query->orderBy($sort ?? 'tanggal_uji', $direction ?? 'desc'); // Urutkan langsung.
            })
            ->paginate(9); // Tampilkan 9 hasil uji per halaman.

        // Tambahkan semua parameter query string ke link pagination agar filter dan sorting tetap aktif.
        $hasilUjiList->appends($request->only(['search', 'start', 'end', 'sort', 'direction']));

        // Tampilkan view 'petugas.laboran.riwayat_hasil_uji' dan kirim data hasil uji.
        return view('petugas.laboran.riwayat_hasil_uji', compact('hasilUjiList'));
    }

    /**
     * updateVerifikasi()
     *
     * Fungsi ini buat update status verifikasi pasien (biasanya lewat AJAX).
     *
     * @param  \Illuminate\Http\Request  $request Objek Request (berisi status verifikasi dari checkbox).
     * @param  int  $id ID pasien yang status verifikasinya mau diupdate.
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateVerifikasi(Request $request, $id)
    {
        try {
            // Cari pasien berdasarkan ID. Kalau gak ketemu, kasih error 404.
            $pasien = Pasien::findOrFail($id);

            // Update kolom 'verifikasi' di database pasien.
            // Jika checkbox 'verifikasi' dicentang (true), set jadi true, kalau tidak (false).
            $pasien->verifikasi = $request->verifikasi ? true : false;
            $pasien->save(); // Simpan perubahan ke database.

            // Kirim respons sukses dalam bentuk JSON.
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            // Jika terjadi error, catat di log.
            Log::error('Verifikasi update error: ' . $e->getMessage());
            // Kirim respons error dalam bentuk JSON dengan kode status 500.
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
