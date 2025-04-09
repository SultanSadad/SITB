@extends('layout.rekam_medis')

@section('rekam_medis')
<div class="px-6 mt-4 ">
    <h1 class="font-bold text-2xl mb-4">Data Pasien</h1>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <input type="text" placeholder="Cari Pasien"
                class="border border-gray-300 rounded-lg px-4 py-2 w-1/3 focus:outline-none focus:ring focus:border-blue-300 text-sm">
            <a href="/rekam_medis/data_pasien/create"
                class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium">
                + Tambah Pasien
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">NAMA</th>
                        <th scope="col" class="px-6 py-3">NIK</th>
                        <th scope="col" class="px-6 py-3">TANGGAL LAHIR</th>
                        <th scope="col" class="px-6 py-3">NO. WHATSAPP</th>
                        <th scope="col" class="px-6 py-3">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Contoh data pasien --}}
                    <tr class="bg-white border-b">
                        <td class="px-6 py-4 font-medium text-gray-900">Hafivah Tahta</td>
                        <td class="px-6 py-4">3576014403910003</td>
                        <td class="px-6 py-4">06 Maret 2005</td>
                        <td class="px-6 py-4 text-green-600 font-semibold">085210659598</td>
                        <td class="px-6 py-4 flex space-x-2">
                            <a href="#"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edit</a>
                            <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    {{-- Ulangi untuk setiap data pasien --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
