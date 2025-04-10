@extends('layout.rekam_medis')

@section('rekam_medis')
<div class="px-6 mt-4">
    <h1 class="font-bold text-2xl mb-4">Hasil Uji TB</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <!-- Input Pencarian -->
            <div class="relative w-1/3">
                <input type="text" placeholder="Cari Pasien"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th class="px-6 py-3">Nama Pasien</th>
                        <th class="px-6 py-3">Tanggal Uji TB</th>
                        <th class="px-6 py-3">Tanggal Upload TB</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">File</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data dummy --}}
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4 font-medium text-gray-900">Hafivah Tahta</td>
                        <td class="px-6 py-4">5 April 2025</td>
                        <td class="px-6 py-4">6 April 2025</td>
                        <td class="px-6 py-4">
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Positif</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#"
                               class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-semibold">
                               Cetak Hasil
                            </a>
                        </td>
                    </tr>
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4 font-medium text-gray-900">Saskia Nadira</td>
                        <td class="px-6 py-4">5 April 2025</td>
                        <td class="px-6 py-4">6 April 2025</td>
                        <td class="px-6 py-4">
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">Negatif</span>
                        </td>
                        <td class="px-6 py-4">
                            <a href="#"
                               class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-semibold">
                               Cetak Hasil
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
