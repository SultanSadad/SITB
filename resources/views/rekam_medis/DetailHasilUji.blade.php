@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="relative px-6 mt-1">
        <!-- Tombol Kembali -->
        <h1 class="font-bold text-2xl mb-4">Detail Hasil Uji Laboratorium</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Tombol Upload Hasil Uji -->
            <a href="/rekam-medis/hasil-uji" class="mt-2 inline-block bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
            <div class="overflow-x-auto mt-6">
            <div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead class="bg-primary text-white">
            <tr>
                <th class="text-center">Tanggal Uji</th>
                <th class="text-center">Tanggal Upload</th>
                <th class="text-center">File</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($hasilUjiList as $hasil)
                <tr>
                    <td class="text-center">{{ date('d-m-Y', strtotime($hasil->tanggal_uji)) }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($hasil->tanggal_upload)) }}</td>
                    <td class="text-center">
                        <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank" class="btn btn-sm btn-info">
                            <i class="fas fa-file-download"></i> Lihat Dokumen
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada hasil uji.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
            </div>
        </div>
    </div>

@endsection