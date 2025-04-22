@extends('layout.laboran')

@section('laboran')
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
                        <th class="px-6 py-3 text-center">Nama Pasien</th>
                        <th class="px-6 py-3 text-center">Tanggal Uji TB</th>
                        <th class="px-6 py-3 text-center">Tanggal Upload TB</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">File</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data dummy --}}
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4 font-medium text-gray-900 text-center">Hafivah Tahta</td>
                        <td class="px-6 py-4 text-center">05 April 2025</td>
                        <td class="px-6 py-4 text-center">07 April 2025</td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ url('/laboran/detail_laboran') }}"
                               style="background-color: #F2E3D5;" class="text-red px-2 py-1 rounded text-xs font-medium ">
                               Positif
                            </a>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ url('/laboran/detail_laboran') }}"
                               style="background-color:rgb(42, 177, 92);" class="text-white px-2 py-1 rounded text-xs font-regular ">
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
