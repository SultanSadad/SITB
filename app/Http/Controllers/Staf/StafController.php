<?php

namespace App\Http\Controllers\Staf;

use App\Models\Staf;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class StafController extends Controller
{
    // Tampilkan semua data staf dengan pencarian
    public function index(Request $request)
    {
        $query = Staf::query();

        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(nip) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $stafs = $query->paginate(7);
        $stafs->appends($request->all());

        return view('rekam_medis.data_staf', compact('stafs'));
    }

    public function create()
    {
        return view('rekam_medis.create_staf');
    }

    public function store(Request $request)
    {
        // Log received values to debug
        Log::info('Received staff creation request with params:', $request->all());
        
        // Validate the request
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:staf',
            'email' => 'required|email|unique:staf',
            'no_whatsapp' => 'required|string',
            'peran' => 'required|in:laboran,rekam_medis',
            'password' => 'required|min:6|confirmed',
        ]);

        try {
            // Create new staff record (without password)
            $staf = Staf::create([
                'nama' => $validated['nama'],
                'nip' => $validated['nip'],
                'email' => $validated['email'],
                'no_whatsapp' => $validated['no_whatsapp'],
                'peran' => $validated['peran'],
            ]);

            // Create corresponding user entry with password
            User::create([
                'name' => $validated['nama'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'staf',
                'profile_id' => $staf->id, // Link to staf record
            ]);

            Log::info('Staff created successfully with ID: ' . $staf->id);
            
            return redirect()->route('stafs.index')
                             ->with('success', 'Data staf berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Failed to create staff:', ['error' => $e->getMessage()]);
            
            return redirect()->route('stafs.index')
                             ->with('error', 'Gagal menambahkan data staf: ' . $e->getMessage());
        }
    }

    public function edit(Staf $staf)
    {
        return view('rekam_medis.edit_staf', compact('staf'));
    }

    public function update(Request $request, Staf $staf)
    {
        // Log received values to debug
        Log::info('Received staff update request for ID ' . $staf->id . ' with params:', $request->all());
        
        // Base validation
        $validationRules = [
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:staf,nip,' . $staf->id,
            'email' => 'required|email|unique:staf,email,' . $staf->id,
            'no_whatsapp' => 'required|string',
            'peran' => 'required|in:laboran,rekam_medis',
        ];
        
        // Add password validation if password is being updated
        if ($request->filled('password')) {
            $validationRules['password'] = 'required|min:6|confirmed';
        }
        
        $validated = $request->validate($validationRules);

        try {
            // Remove password from staf update data (if exists)
            $staffData = collect($validated)->except('password')->toArray();
            $staf->update($staffData);
            
            // Update the related user record
            $user = User::where('profile_id', $staf->id)
                         ->where('role', 'staf')
                         ->first();
            
            if ($user) {
                $userData = [
                    'name' => $validated['nama'],
                    'email' => $validated['email'],
                ];
                
                // Update password if provided
                if ($request->filled('password')) {
                    $userData['password'] = Hash::make($validated['password']);
                }
                
                $user->update($userData);
            }
            
            Log::info('Staff updated successfully: ' . $staf->id);
            
            return redirect()->route('stafs.index')
                             ->with('success', 'Data staf berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Failed to update staff:', ['error' => $e->getMessage()]);
            
            return redirect()->route('stafs.index')
                             ->with('error', 'Gagal memperbarui data staf: ' . $e->getMessage());
        }
    }

    public function destroy(Staf $staf)
    {
        try {
            // Also delete the related user
            User::where('profile_id', $staf->id)
                ->where('role', 'staf')
                ->delete();
                
            $staf->delete();
            return redirect()->route('stafs.index')
                             ->with('success', 'Data staf berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete staff:', ['error' => $e->getMessage()]);
            
            return redirect()->route('stafs.index')
                             ->with('error', 'Gagal menghapus data staf: ' . $e->getMessage());
        }
    }

    public function getEditData(Staf $staf)
    {
        return response()->json([
            'nama' => $staf->staf ? $staf->staf->nama : $staf->nama,
            'nip' => $staf->nip,
            'email' => $staf->email,
            'no_whatsapp' => $staf->no_whatsapp,
            'peran' => $staf->peran,
        ]);
    }
}