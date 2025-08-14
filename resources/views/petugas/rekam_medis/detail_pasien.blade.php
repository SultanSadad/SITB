@extends('layout.rekam_medis') {{-- Sesuaikan jika layout berbeda --}}
<title>Detail Pasien: {{ $pasien->nama ?? 'Tidak Ada Nama' }}</title>
@section('rekam_medis')
    <div class="px-3 sm:px-6 mt-4">
        <h1 class="font-bold text-xl sm:text-2xl mb-4">Detail Pasien</h1>
        <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
            <p><strong>No. ERM:</strong> {{ $pasien->no_erm ?? '-' }}</p>
            <p><strong>Nama Pasien:</strong> {{ $pasien->nama ?? '-' }}</p>
            <p><strong>NIK:</strong> {{ $pasien->nik ?? '-' }}</p>
            <p><strong>No. WhatsApp:</strong> {{ $pasien->no_whatsapp ?? '-' }}</p>
            <p><strong>Tanggal Lahir:</strong>
                {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') ?? '-' }}</p>
            <p><strong>Verifikasi:</strong> {{ $pasien->verifikasi ? 'Sudah Diverifikasi' : 'Belum Diverifikasi' }}</p>
            <a href="{{ route('pasiens.index') }}"
                class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">Kembali ke
                Daftar</a>
        </div>
    </div>
@endsection