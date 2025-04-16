<?php

namespace App\Http\Controllers\RekamMedis;

use App\Models\Pasien;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PasienController extends Controller
{
    public function index(Request $request)
    {
        $query = Pasien::query();
    
        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
    
        $pasien = $query->get();
    
        return view('rekammedis.DataPasien', compact('pasien'));
    }
    public function destroy($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }

        public function edit($id)
    {
        $pasien = Pasien::findOrFail($id);
        return response()->json($pasien);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'tgl_lahir' => 'required|date',
            'no_wa' => 'required|string|max:20',
        ]);
        
        $pasien = Pasien::findOrFail($id);
        
        $pasien->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tgl_lahir,
            'no_whatsapp' => $request->no_wa,
        ]);
        
        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil diperbarui!');
    }
    


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16|unique:pasien,nik',
            'tanggal_lahir' => 'required|date',
            'no_whatsapp' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pasien::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_whatsapp' => $request->no_whatsapp,
        ]);

        return redirect()->route('pasien.index')->with('success', 'Data pasien berhasil ditambahkan!');
    }
}
