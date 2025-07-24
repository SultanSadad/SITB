<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Http\Controllers\Controller;
use App\Models\Staf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class DataStafController extends Controller
{
    public function index(Request $request)
    {
        $query = Staf::query();

        if ($request->has('q') && !empty($request->q)) {
            $searchTerm = strtolower($request->q);

            $query->where(function ($q) use ($searchTerm) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(email) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(nip) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ["%{$searchTerm}%"])
                    ->orWhereRaw('LOWER(peran) LIKE ?', ["%{$searchTerm}%"]);
            });
        }

        $stafs = $query->latest()->paginate(10);
        $stafs->appends(['q' => $request->q]);

        return view('petugas.rekam_medis.data_staf', compact('stafs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'nullable|string|max:255|unique:staf,nip',
            'email' => 'required|string|max:255|unique:staf,email',
            'no_whatsapp' => 'nullable|string|max:255',
            'peran' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        try {
            Staf::create([
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'email' => $validated['email'],
                'no_whatsapp' => $validated['no_whatsapp'],
                'peran' => $validated['peran'],
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()
                ->route('rekam-medis.staf.index')
                ->with([
                    'success_type' => 'success_add',
                    'success_message' => 'Data staf Berhasil ditambahkan.'
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal membuat staf: ' . $e->getMessage());

            return redirect()
                ->route('rekam-medis.staf.index')
                ->with([
                    'success_type' => 'error',
                    'success_message' => 'Gagal menambahkan data staf.'
                ]);
        }
    }

    public function update(Request $request, Staf $staf)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('staf')->ignore($staf->id),
            ],
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique('staf')->ignore($staf->id),
            ],
            'no_whatsapp' => 'nullable|string|max:255',
            'peran' => 'required|string',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        try {
            $staf->nama = $validated['nama'];
            $staf->nip = $validated['nip'];
            $staf->email = $validated['email'];
            $staf->no_whatsapp = $validated['no_whatsapp'];
            $staf->peran = $validated['peran'];

            if ($request->filled('password')) {
                $staf->password = Hash::make($request->password);
            }

            $staf->save();

            return redirect()
                ->route('rekam-medis.staf.index')
                ->with([
                    'success_type' => 'success_edit',
                    'success_message' => 'Data staf berhasil diperbarui.'
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal update staf: ' . $e->getMessage());

            return redirect()
                ->to('rekam-medis/data-staf')
                ->with([
                    'success_type' => 'error',
                    'success_message' => 'Gagal memperbarui data staf.'
                ]);
        }
    }

    public function destroy(Staf $staf)
    {
        try {
            $staf->delete();

            return redirect()
                ->route('rekam-medis.staf.index')
                ->with([
                    'success_type' => 'success_delete',
                    'success_message' => 'Data Staf berhasil dihapus.'
                ]);
        } catch (\Exception $e) {
            Log::error('Gagal menghapus staf: ' . $e->getMessage());

            return redirect()
                ->route('rekam-medis.staf.index')
                ->with([
                    'success_type' => 'error',
                    'success_message' => 'Terjadi kesalahan saat menghapus data staf.'
                ]);
        }
    }

    public function editData(Staf $staf)
    {
        return response()->json($staf);
    }

    public function searchStaf(Request $request)
    {
        $query = Staf::query();
        $searchTerm = $request->get('q');

        if (!empty($searchTerm)) {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('nip', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('no_whatsapp', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('peran', 'LIKE', "%{$searchTerm}%");
            });
        }

        $stafs = $query->latest()->paginate(10);
        $stafs->appends(['q' => $searchTerm]);

        return view('petugas.rekam_medis.partials.staf_table_rows', compact('stafs'))->render();
    }
}
