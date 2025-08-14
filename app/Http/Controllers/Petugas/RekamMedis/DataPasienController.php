<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class DataPasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();

        // Search
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(nik) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(no_erm) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('CAST(tanggal_lahir AS TEXT) LIKE ?', ["%{$search}%"]);
            });
        }

        // Filter verifikasi
        if ($request->has('verification_status')) {
            if ($request->verification_status === 'verified') {
                $query->where('verifikasi', true);
            } elseif ($request->verification_status === 'unverified') {
                $query->where('verifikasi', false);
            }
        }

        // Sort
        $sortField = $request->get('sort', 'nama');
        $sortDirection = $request->get('direction', 'asc');

        if ($sortField === 'verifikasi') {
            $query->orderByRaw("
                CASE
                    WHEN no_erm IS NULL OR nama IS NULL OR nik IS NULL
                         OR tanggal_lahir IS NULL OR no_whatsapp IS NULL
                    THEN 0 ELSE 1
                END " . strtoupper($sortDirection));
        } else {
            $allowed = ['no_erm','nama','nik','no_whatsapp','tanggal_lahir','created_at'];
            if (!in_array($sortField, $allowed, true)) {
                $sortField = 'nama';
            }
            $query->orderBy($sortField, $sortDirection);
        }

        $pasiens = $query->paginate(9)->appends($request->all());

        return view('petugas.rekam_medis.data_pasien', compact('pasiens', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_erm'        => ['required','string','unique:pasiens,no_erm'],
            'nama_pasien'   => ['required','string','max:255'],
            'nik'           => ['nullable','string','unique:pasiens,nik'],
            'tanggal_lahir' => ['nullable','date'],
            'no_whatsapp'   => ['nullable','string','unique:pasiens,no_whatsapp'],
        ]);

        try {
            $pasien = Pasien::create([
                'no_erm'        => $request->no_erm,
                'nama'          => $request->nama_pasien,
                'nik'           => $request->nik,
                'tanggal_lahir' => $request->tanggal_lahir,
                'no_whatsapp'   => $request->no_whatsapp,
            ]);

            // (opsional) buat user pasien
            User::create([
                'name'      => $request->nama_pasien,
                'role'      => 'pasien',
                'pasien_id' => $pasien->id,
            ]);

            return redirect()->route('rekam-medis.pasien.index')
                ->with('notif_type', 'success_add')
                ->with('notif_message', 'Data pasien berhasil ditambahkan.');
        } catch (Throwable $e) {
            return redirect()->route('rekam-medis.pasien.index')
                ->withInput()
                ->with('notif_type', 'error')
                ->with('notif_message', 'Gagal menambahkan pasien.');
        }
    }

    public function update(Request $request, Pasien $pasien)
    {
        try {
            $validated = $request->validate([
                'nama'          => ['required','string','max:255'],
                'nik'           => ['nullable','string', Rule::unique('pasiens', 'nik')->ignore($pasien->id)],
                'no_erm'        => ['required','string', Rule::unique('pasiens', 'no_erm')->ignore($pasien->id)],
                'no_whatsapp'   => ['nullable','string', Rule::unique('pasiens', 'no_whatsapp')->ignore($pasien->id)],
                'tanggal_lahir' => ['nullable','date'],
            ]);

            $pasien->update($validated);

            return redirect()->route('rekam-medis.pasien.index')
                ->with('notif_type', 'success_edit')
                ->with('notif_message', 'Data pasien berhasil diperbarui.');
        } catch (ValidationException $e) {
            return back()->withInput()
                ->withErrors($e->validator)
                ->with('notif_type', 'error')
                ->with('notif_message', $e->validator->errors()->first() ?: 'Validasi gagal.');
        } catch (Throwable $e) {
            return redirect()->route('rekam-medis.pasien.index')
                ->with('notif_type', 'error')
                ->with('notif_message', 'Gagal memperbarui data pasien.');
        }
    }

    public function destroy(Pasien $pasien)
    {
        try {
            User::where('pasien_id', $pasien->id)->delete();
            $pasien->delete();

            return redirect()->route('rekam-medis.pasien.index')
                ->with('notif_type', 'success_delete')
                ->with('notif_message', 'Data pasien berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->route('rekam-medis.pasien.index')
                ->with('notif_type', 'error')
                ->with('notif_message', 'Gagal menghapus data pasien.');
        }
    }

    public function verifikasi(Request $request, Pasien $pasien)
    {
        try {
            $pasien->verifikasi = (bool) $request->verifikasi;
            $pasien->save();

            return response()->json([
                'success' => true,
                'message' => $pasien->verifikasi
                    ? 'Verifikasi pasien berhasil.'
                    : 'Verifikasi pasien dibatalkan.',
                'type'    => 'success_general',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui status verifikasi.',
                'type'    => 'error',
            ], 500);
        }
    }

    public function searchPasien(Request $request)
    {
        $search = $request->get('search');
        $pasiens = Pasien::where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->limit(10)
            ->get(['id','nama','nik','tanggal_lahir']);

        return response()->json($pasiens);
    }
}
