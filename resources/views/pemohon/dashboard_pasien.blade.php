@extends('layout.pasien')

@section('pasien')

    <div class="flex flex-col px-5 mt-6 mb-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-bold text-2xl">Selamat Datang di Sistem Informasi Pasien</h1>
        </div>

        <!-- Data Diri Pasien -->
        <div class="bg-blue-100 rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-center text-lg font-bold text-gray-700 mb-2 uppercase tracking-wide">Data Diri Pasien</h2>
            <hr class="mb-6 border-gray-300">

            <!-- Tabel Data -->
            <div class="space-y-2 text-base text-gray-800">
                <div class="flex">
                    <div class="w-40 font-semibold">NIK</div>
                    <div class="w-4">:</div>
                    <div>{{ $pasien->nik }}</div>
                </div>
                <div class="flex">
                    <div class="w-40 font-semibold">Nama</div>
                    <div class="w-4">:</div>
                    <div>{{ $pasien->nama }}</div>
                </div>
                <div class="flex">
                    <div class="w-40 font-semibold">No Telp/HP</div>
                    <div class="w-4">:</div>
                    <div>{{ $pasien->no_whatsapp }}</div>
                </div>
                <div class="flex">
                    <div class="w-40 font-semibold">NoERM</div>
                    <div class="w-4">:</div>
                    <div>{{ $pasien->no_erm }}</div>
                </div>
            </div>
        </div>

        <!-- Medical Records Info -->
        <div class="bg-blue-100 rounded-lg shadow-md p-6 mb-6">
    <h2 class="text-xl font-bold mb-4">Panduan Sistem Informasi Hasil Laboratorium</h2>
    
    <div class="aspect-w-16 aspect-h-9">
        <iframe 
            class="w-full h-64 rounded-md"
            src="https://www.youtube.com/embed/nrfrxLVEPPc"
            title="Panduan Sistem Informasi Hasil Laboratorium"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
        </iframe>
    </div>
</div>

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
@endsection