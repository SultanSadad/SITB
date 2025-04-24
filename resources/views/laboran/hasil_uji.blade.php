@extends('layout.laboran')

@section('laboran')
<div class="px-6 mt-4">
    <h1 class="font-bold text-2xl mb-4">Hasil Uji TB</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
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
                        <th class="px-6 py-3 text-center">No WhatsApp</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data dummy --}}
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4 font-medium text-gray-900 text-center">Hafivah Tahta</td>
                        <td class="px-6 py-4 text-center">080808080808</td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ url('/laboran/detail_laboran') }}"
                               style="background-color: #E650BE;" class="text-white px-2 py-1 rounded text-xs font-regular ">
                               Detail
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
