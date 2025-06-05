<?php

namespace App\Http\Controllers\Petugas\RekamMedis;

use App\Models\Staf;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class DataStafController extends Controller
{
    // Tampilkan semua data staf dengan pencarian
    public function index(Request $request)
    {
        // Inisialisasi query staf
        $query = Staf::query();

        // Jika terdapat input pencarian
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            // Pencarian berdasarkan nama, NIP, email, atau no WhatsApp (case-insensitive)
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(nip) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(no_whatsapp) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        // Ambil hasil query dengan pagination
        $stafs = $query->paginate(9);
        $stafs->appends($request->all());

        // Jika AJAX, render partial view tabel saja
        if ($request->ajax()) {
            return view('petugas.rekam_medis.partials.staf_table', compact('stafs'))->render();
        }

        // Tampilkan view utama
        return view('petugas.rekam_medis.data_staf', compact('stafs'));
    }


    public function create()
    {
        // Redirect karena form tambah staf menggunakan modal, bukan halaman terpisah
        return redirect()->route('rekam-medis.stafs.index');
    }


    public function store(Request $request)
    {
        Log::info('Received staff creation request with params:', $request->all());

        // Validasi input dari form tambah staf
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:staf,nip',
            'email' => 'required|string|unique:users,email',
            'no_whatsapp' => 'required|string|unique:staf,no_whatsapp',
            'peran' => 'required|in:laboran,rekam_medis',
            'password' => 'required|min:6|confirmed',
        ], [
            // Pesan validasi kustom
            'nip.unique' => 'NIP sudah digunakan.',
            'email.unique' => 'Username sudah digunakan.',
            'password.confirmed' => 'Password dan konfirmasi tidak cocok.',
            // dst...
        ]);

        // Debug password input
        Log::info('Password input check:', [
            'raw_password' => $request->input('password'),
            'confirmation' => $request->input('password_confirmation'),
        ]);

        try {
            // Simpan ke tabel staf
            $staf = Staf::create([
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'email' => $validated['email'],
                'no_whatsapp' => $validated['no_whatsapp'],
                'peran' => $validated['peran'],
            ]);

            // Simpan ke tabel user
            User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'staf',
                'staf_id' => $staf->id,
            ]);

            Log::info('Staff created successfully with ID: ' . $staf->id);

            return redirect()->route('rekam-medis.stafs.index')->with([
                'success_type' => 'success_add',
                'success_message' => 'Data staf berhasil ditambahkan.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create staff:', ['error' => $e->getMessage()]);
            return redirect()->route('rekam-medis.stafs.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal menambahkan data staf: ' . $e->getMessage()
            ]);
        }
    }


    public function editData(Staf $staf)
    {
        // Ambil user berdasarkan staf_id
        $user = User::where('staf_id', $staf->id)->first();

        // Set email dari tabel user (jika ada)
        $staf->email = $user ? $user->email : $staf->email;

        // Kirim data JSON untuk diisi di form modal edit
        return response()->json($staf);
    }


    public function update(Request $request, Staf $staf)
    {
        Log::info('Received staff update request for ID ' . $staf->id, $request->all());

        $user = User::where('staf_id', $staf->id)->first();

        // Validasi input dengan pengecualian untuk data yang sedang diedit
        $validationRules = [
            'nama' => 'required|string|max:255',
            'nip' => ['required', 'string', Rule::unique('staf', 'nip')->ignore($staf->id)],
            'email' => ['nullable', 'string', Rule::unique('users', 'email')->ignore($user->id ?? null)],
            'no_whatsapp' => ['required', 'string', Rule::unique('staf', 'no_whatsapp')->ignore($staf->id)],
            'peran' => 'required|in:laboran,rekam_medis',
        ];

        // Tambah validasi password jika diisi
        if ($request->filled('password')) {
            $validationRules['password'] = 'required|min:6|confirmed';
        }

        $validated = $request->validate($validationRules, [
            // Pesan kustom error validasi
        ]);

        try {
            // Update data staf
            $staf->update([
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'no_whatsapp' => $validated['no_whatsapp'],
                'peran' => $validated['peran'],
                'email' => $validated['email'] ?? null,
            ]);

            // Update atau buat user
            if (!empty($validated['email'])) {
                if ($user) {
                    $userData = [
                        'name' => $validated['nama'],
                        'email' => $validated['email'],
                        'role' => $validated['peran'],
                    ];

                    if ($request->filled('password')) {
                        $userData['password'] = Hash::make($validated['password']);
                    }

                    $user->update($userData);
                } else {
                    User::create([
                        'name' => $validated['nama'],
                        'email' => $validated['email'],
                        'password' => $request->filled('password') ? Hash::make($validated['password']) : Hash::make(Str::random(10)),
                        'role' => $validated['peran'],
                        'staf_id' => $staf->id,
                    ]);
                    Log::warning('User not found for Staf ID ' . $staf->id . '. Creating new user.');
                }
            } elseif ($user) {
                $user->delete(); // Hapus user jika email dikosongkan
            }

            Log::info('Staff updated successfully: ' . $staf->id);

            return redirect()->route('rekam-medis.stafs.index')->with([
                'success_type' => 'success_edit',
                'success_message' => 'Data staf berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to update staff:', ['error' => $e->getMessage()]);

            return redirect()->route('rekam-medis.stafs.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal memperbarui data staf: ' . $e->getMessage()
            ]);
        }
    }
    public function destroy(Staf $staf)
    {
        try {
            // Hapus user terkait staf
            User::where('staf_id', $staf->id)->delete();

            // Hapus data staf
            $staf->delete();

            return redirect()->route('rekam-medis.stafs.index')->with([
                'success_type' => 'success_delete',
                'success_message' => 'Data staf berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to delete staff:', ['error' => $e->getMessage()]);

            return redirect()->route('rekam-medis.stafs.index')->with([
                'success_type' => 'error',
                'success_message' => 'Gagal menghapus data staf: ' . $e->getMessage()
            ]);
        }
    }

}