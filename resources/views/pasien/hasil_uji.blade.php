@extends('layout.pasien')

@section('pasien')
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
                    <tr class="bg-white border-b text-center">
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
                    <tr class="bg-white border-b text-center">
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

        <!-- Pagination -->
        <div class="flex justify-center mt-6">
            <nav aria-label="Page navigation">
                <ul class="inline-flex items-center -space-x-px text-sm">
                    <li>
                        <a href="#"
                            class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                            &lt;
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                    </li>
                    <li>
                        <a href="#"
                            class="px-3 py-2 leading-tight text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">2</a>
                    </li>
                    <li>
                        <a href="#"
                            class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">3</a>
                    </li>
                    <li>
                        <a href="#"
                            class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">4</a>
                    </li>
                    <li>
                        <a href="#"
                            class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">5</a>
                    </li>
                    <li>
                        <a href="#"
                            class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                            &gt;
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
        <!-- End Pagination -->
    </div>
</div>
@endsection
