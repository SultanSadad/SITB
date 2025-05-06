<?php

namespace App\Http\Controllers\Pasien;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{
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
        $pasiens->appends($request->all());

        return view('rekam_medis.data_pasien', compact('pasiens'));
    }

    public function searchPasien(Request $request)
    {
        $search = $request->get('search');

        $pasiens = Pasien::where(function ($query) use ($search) {
            $query->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                ->orWhereRaw('LOWER(nik) LIKE ?', ['%' . strtolower($search) . '%']);
        })
            ->limit(10)
            ->get(['id', 'nama', 'nik', 'tanggal_lahir']);

        return response()->json($pasiens);
    }

    public function create()
    {
        return view('pasiens.create');
    }

    public function store(Request $request)
    {
        Log::info('Request masuk', $request->all());

        $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens',
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'nullable|string',
        ]);

        Log::info('Validasi oke');

        $latestPasien = Pasien::latest('id')->first();
        $nextId = $latestPasien ? $latestPasien->id + 1 : 1;
        $no_erm = str_pad($nextId, 8, '0', STR_PAD_LEFT);

        $pasien = Pasien::create([
            'nama' => $request->nama_pasien,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_whatsapp' => $request->no_whatsapp,
            'no_erm' => $no_erm,
        ]);

        Log::info('Pasien berhasil dibuat', $pasien->toArray());

        return redirect()->route('pasiens.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function edit(Pasien $pasien)
    {
        return view('pasiens.edit', compact('pasien')); // disarankan gunakan view khusus edit
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|unique:pasiens,nik,' . $pasien->id,
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'nullable|string',
        ]);

        $pasien->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_whatsapp' => $request->no_whatsapp,
        ]);

        return redirect()->route('pasiens.index');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasiens.index');
    }

    public function laboranIndex()
    {
        $pasiens = Pasien::latest()->paginate(8);
        return view('laboran.hasil_uji', compact('pasiens'));
    }

    public function updateVerifikasi(Request $request, $id)
    {
        try {
            $pasien = Pasien::findOrFail($id);
            $pasien->verifikasi = $request->verifikasi ? true : false;
            $pasien->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
