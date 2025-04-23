<?php
// 1. Update Controller Staf
namespace App\Http\Controllers\Staf;

use App\Models\Staf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StafController extends Controller
{
    // Tampilkan semua data staf dengan pencarian
     // Tampilkan semua data staf dengan pencarian
     public function index(Request $request)
     {
         // Inisialisasi query
         $query = Staf::query();
 
         // Jika ada parameter pencarian
         if ($request->has('search') && !empty($request->search)) {
             $search = $request->search;
             
             // Terapkan pencarian ke seluruh data
             $query->where(function ($q) use ($search) {
                 $q->whereRaw('LOWER(nama) LIKE ?', ['%' . strtolower($search) . '%'])
                   ->orWhereRaw('LOWER(nip) LIKE ?', ['%' . strtolower($search) . '%'])
                   ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($search) . '%']);
             });
         }
 
         // Ambil data yang sudah difilter dan paginasi
         $stafs = $query->paginate(7);
         
         // Pertahankan parameter pencarian di URL pagination
         $stafs->appends($request->all());
 
         // Tampilkan view dengan data
         return view('rekam_medis.data_staf', compact('stafs'));
     }

    // Fungsi lainnya tetap sama
    public function create()
    {
        return view('rekam_medis.create_staf');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:staf',
            'email' => 'required|email|unique:staf',
            'no_whatsapp' => 'nullable|string',
            'role' => 'required|in:laboran,rekammedis',
        ]);

        Staf::create($request->all());

        return redirect()->route('stafs.index')->with('success', 'Data staf berhasil ditambahkan.');
    }

    public function edit(Staf $staf)
    {
        return view('rekam_medis.edit_staf', compact('staf'));
    }

    public function update(Request $request, Staf $staf)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|unique:staf,nip,' . $staf->id,
            'email' => 'required|email|unique:staf,email,' . $staf->id,
            'no_whatsapp' => 'nullable|string',
            'role' => 'required|in:laboran,rekammedis',
        ]);

        $staf->update($request->all());

        return redirect()->route('stafs.index')->with('success', 'Data staf berhasil diperbarui.');
    }

    public function destroy(Staf $staf)
    {
        $staf->delete();
        return redirect()->route('stafs.index')->with('success', 'Data staf berhasil dihapus.');
    }
}

