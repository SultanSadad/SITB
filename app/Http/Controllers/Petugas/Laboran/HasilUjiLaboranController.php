<?php

declare(strict_types=1);

namespace App\Http\Controllers\Petugas\Laboran;

use App\Http\Controllers\Controller;
use App\Models\HasilUjiTB;
use App\Models\Pasien;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Class HasilUjiLaboranController
 *
 * Controller untuk mengelola hasil uji laboratorium oleh petugas laboran.
 *
 * @category Controllers
 * @package  App\Http\Controllers\Petugas\Laboran
 * @author   Sultan Sadad <sultansadad@gmail.com>
 * @license  http://opensource.org/licenses/MIT MIT License
 * @link     http://localhost
 */
class HasilUjiLaboranController extends Controller
{
    /**
     * Menampilkan daftar pasien dengan hasil uji.
     *
     * @param  Request  $request  Objek request HTTP.
     * @return View
     */
    public function index(Request $request): View
    {
        $search    = $request->input('search');
        $startDate = $request->input('start');
        $endDate   = $request->input('end');

        $pasiens = Pasien::when($search, function ($query) use ($search) {
            return $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(no_erm) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->with([
                'hasilUjiTB' => function ($query) use ($startDate, $endDate) {
                    if ($startDate) {
                        $query->whereDate('tanggal_uji', '>=', $startDate);
                    }
                    if ($endDate) {
                        $query->whereDate('tanggal_uji', '<=', $endDate);
                    }
                },
            ])
            ->latest()
            ->paginate(10);

        $pasiens->appends($request->only(['search', 'start', 'end']));

        return view('petugas.laboran.hasil_uji', compact('pasiens'));
    }

    /**
     * Menampilkan detail hasil uji dari seorang pasien.
     *
     * @param  int  $pasienId  ID pasien.
     * @return View
     */
    public function show(int $pasienId): View
    {
        $pasien       = Pasien::findOrFail($pasienId);
        $hasilUjiList = $pasien->hasilUjiTB()->latest()->paginate(9);
        $hasilUjiList->appends(request()->all());

        return view('petugas.laboran.detail_hasil_uji', compact('pasien', 'hasilUjiList'));
    }

    /**
     * Menyimpan hasil uji baru untuk pasien.
     *
     * @param  Request  $request   Objek request HTTP.
     * @param  int      $pasienId  ID pasien.
     * @return RedirectResponse
     */
    public function store(Request $request, int $pasienId): RedirectResponse
    {
        try {
            $request->validate([
                'tanggal_uji'    => 'required|date',
                'tanggal_upload' => 'required|date|before_or_equal:today',
                'file'           => 'required|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240',
            ]);

            $file = $request->file('file');
            $path = $file->store('hasil-uji', 'public');

            $hasil                 = new HasilUjiTB();
            $hasil->pasien_id      = $pasienId;
            $hasil->staf_id        = auth()->user()->staf_id;
            $hasil->tanggal_uji    = $request->tanggal_uji;
            $hasil->tanggal_upload = $request->tanggal_upload;
            $hasil->file           = $path;
            $hasil->save();

            return redirect()
                ->route('laboran.hasil-uji.show', $pasienId)
                ->with('success', 'Hasil uji berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Upload error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Gagal upload: ' . $e->getMessage());
        }
    }

    /**
     * Menghapus hasil uji dari pasien.
     *
     * @param  int  $id  ID hasil uji.
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $hasil    = HasilUjiTB::findOrFail($id);
        $pasienId = $hasil->pasien_id;

        if ($hasil->file && Storage::disk('public')->exists($hasil->file)) {
            Storage::disk('public')->delete($hasil->file);
        }

        $hasil->delete();

        return redirect()
            ->route('laboran.hasil-uji.show', $pasienId)
            ->with('success', 'Hasil uji berhasil dihapus');
    }

    /**
     * Menampilkan semua riwayat hasil uji yang telah diunggah.
     *
     * @param  Request  $request  Objek request HTTP.
     * @return View
     */
    public function semuaHasilUji(Request $request): View
    {
        $search    = $request->input('search');
        $startDate = $request->input('start');
        $endDate   = $request->input('end');
        $sort      = $request->input('sort', 'tanggal_upload');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['nik', 'nama', 'tanggal_upload', 'no_whatsapp', 'tanggal_uji'];

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'tanggal_upload';
        }

        $hasilUjiList = HasilUjiTB::with('pasien')
            ->whereNotNull('file')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('pasien', function ($sub) use ($search) {
                    $sub->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%'])
                        ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
                });
            })
            ->when($startDate, fn ($query) => $query->whereDate('tanggal_uji', '>=', $startDate))
            ->when($endDate, fn ($query) => $query->whereDate('tanggal_uji', '<=', $endDate))
            ->when(in_array($sort, ['nik', 'nama', 'no_whatsapp'], true), function ($query) use ($sort, $direction) {
                $query->join('pasiens', 'pasiens.id', '=', 'hasil_uji_t_b_s.pasien_id')
                    ->orderBy("pasiens.$sort", $direction)
                    ->select('hasil_uji_t_b_s.*');
            }, function ($query) use ($sort, $direction) {
                $query->orderBy($sort ?? 'tanggal_uji', $direction ?? 'desc');
            })
            ->paginate(9);

        $hasilUjiList->appends($request->only(['search', 'start', 'end', 'sort', 'direction']));

        return view('petugas.laboran.riwayat_hasil_uji', compact('hasilUjiList'));
    }

    /**
     * Memperbarui status verifikasi pasien.
     *
     * @param  Request  $request  Objek request HTTP.
     * @param  int      $id       ID pasien.
     * @return JsonResponse
     */
    public function updateVerifikasi(Request $request, int $id): JsonResponse
    {
        try {
            $pasien             = Pasien::findOrFail($id);
            $pasien->verifikasi = $request->boolean('verifikasi');
            $pasien->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Verifikasi update error: ' . $e->getMessage());

            return response()->json(
                ['success' => false, 'message' => $e->getMessage()],
                500
            );
        }
    }

    /**
     * Menampilkan riwayat hasil uji.
     *
     * @param  Request  $request  Objek request HTTP.
     * @return View
     */
    public function riwayat(Request $request): View
    {
        $hasilUjiList = HasilUjiTB::with('pasien')
            ->latest()
            ->paginate(10);

        $hasilUjiList->appends($request->all());

        return view('petugas.laboran.riwayat_hasil_uji', compact('hasilUjiList'));
    }
}