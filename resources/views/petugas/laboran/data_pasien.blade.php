@extends('layout.laboran')
<title>Data Pasien</title>
@section('laboran')

    @include('alert.modal')

    <div class="px-3 sm:px-6 mt-4">
        <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Pasien</h1>

        <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center  space-y-3 sm:space-y-0">
                <form action="{{ url('/laboran/data-pasien') }}" method="GET" class="w-64 sm:w-auto">
                    <div class="relative w-full sm:w-64 lg:w-64">
                        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
                <button type="button"
                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto whitespace-nowrap"
                    data-modal-target="crud-modal" data-modal-toggle="crud-modal">
                    + Tambah Pasien
                </button>
            </div>

            <div id="delete-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="delete-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Yakin ingin menghapus data
                                pasien ini?</h3>

                            <button data-modal-hide="delete-modal" type="button"
                                class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                Batal
                            </button>
                            <form id="delete-form" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center me-2">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div id="crud-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Tambah Pasien Baru
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                data-modal-hide="crud-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form action="{{ route('laboran.data-pasien.store') }}" method="POST" class="p-4 md:p-5">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="no_erm"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. ERM<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="no_erm" id="no_erm"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. ERM001" required="">
                                </div>
                                <div class="col-span-2">
                                    <label for="nama"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                        Pasien<span class="text-red-600">*</span></label>
                                    <input type="text" name="nama" id="nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. John Doe" required="">
                                </div>
                                <div class="col-span-2">
                                    <label for="nik"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                                    <input type="number" name="nik" id="nik"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. 1234567890123456">
                                </div>
                                <div class="col-span-2">
                                    <label for="no_whatsapp"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                                        WhatsApp</label>
                                    <input type="text" name="no_whatsapp" id="no_whatsapp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. 081234567890">
                                </div>
                                <div class="col-span-2">
                                    <label for="tanggal_lahir"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-hide="crud-modal"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                                    <svg class="me-1 -ml-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    Tambah Pasien
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="edit-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Edit Pasien
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                onclick="closeEditModal()">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <form id="edit-form" method="POST" class="p-4 md:p-5">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="pasien_id" name="pasien_id">
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="edit_no_erm"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No. ERM<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="no_erm" id="edit_no_erm"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. ERM001" required="">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_nama"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama
                                        Pasien<span class="text-red-600">*</span></label>
                                    <input type="text" name="nama" id="edit_nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. John Doe" required="">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_nik"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIK</label>
                                    <input type="number" name="nik" id="edit_nik"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. 1234567890123456">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_no_whatsapp"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                                        WhatsApp</label>
                                    <input type="text" name="no_whatsapp" id="edit_no_whatsapp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="e.g. 081234567890">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_tanggal_lahir"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal
                                        Lahir</label>
                                    <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="closeEditModal()"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Batal</button>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="block lg:hidden space-y-4 mt-6" id="mobile-cards-container">
                @forelse ($pasiens as $pasien)
                    <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm relative"> {{-- Added relative for
                        absolute positioning of checkbox --}}
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-900">
                                {{ $pasien->nama ?? 'Nama Belum diisi' }}
                            </h3>
                            {{-- Checkbox Verifikasi --}}

                        </div>

                        <div class="text-sm text-gray-700 space-y-1.5"> {{-- Reduced space-y --}}
                            <p>
                                <span class="font-semibold text-gray-600">ERM: </span>
                                <span class="{{ empty($pasien->no_erm) ? 'text-red-500' : 'text-gray-800' }}">
                                    {{ $pasien->no_erm ?? 'Belum diisi' }}
                                </span>
                            </p>
                            <p>
                                <span class="font-semibold text-gray-600">NIK: </span>
                                <span class="{{ empty($pasien->nik) ? 'text-red-500' : 'text-gray-800' }}">
                                    {{ $pasien->nik ?? 'Belum diisi' }}
                                </span>
                            </p>
                            <p>
                                <span class="font-semibold text-gray-600">Tanggal Lahir: </span>
                                <span class="{{ empty($pasien->tanggal_lahir) ? 'text-red-500' : 'text-gray-800' }}">
                                    {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d M Y') : 'Belum diisi' }}
                                </span>
                            </p>
                            <p>
                                <span class="font-semibold text-gray-600">WhatsApp: </span>
                                @if (!empty($pasien->no_whatsapp))
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pasien->no_whatsapp) }}" target="_blank"
                                        class="text-green-600 hover:underline">
                                        {{ $pasien->no_whatsapp }}
                                    </a>
                                @else
                                    <span class="text-red-500">Belum diisi</span>
                                @endif
                            </p>
                        </div>

                        <div class="flex justify-end gap-3 mt-4"> {{-- Adjusted gap and justified to end --}}
                            <button onclick="editPasien(
                                                    '{{ $pasien->id }}',
                                                    '{{ $pasien->nama }}',
                                                    '{{ $pasien->nik }}',
                                                    '{{ $pasien->no_whatsapp }}',
                                                    '{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}',
                                                    '{{ $pasien->no_erm ?? '' }}'
                                                )"
                                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded text-sm font-semibold w-full transition duration-200">
                                {{-- Wider buttons --}}
                                Edit
                            </button>
                            <button onclick="confirmDelete('{{ route('laboran.data-pasien.destroy', $pasien->id) }}')"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold w-full transition duration-200">
                                {{-- Wider buttons --}}
                                Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">Tidak ada data pasien yang ditemukan.</p>
                @endforelse
            </div>

            <div id="table-container" class="hidden lg:block overflow-x-auto mt-6">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            @php
                                $fields = [
                                    'no_erm' => 'NO.ERM',
                                    'nama' => 'NAMA',
                                    'nik' => 'NIK',
                                    'tanggal_lahir' => 'TANGGAL LAHIR',
                                    'no_whatsapp' => 'NO. WHATSAPP',
                                ];
                            @endphp

                            @foreach ($fields as $field => $label)
                                <th scope="col" class="px-6 py-3">
                                    <div class="flex items-center">
                                        <span>{{ $label }}</span>
                                        <a
                                            href="{{ route('laboran.data-pasien', array_merge(request()->except(['sort', 'direction', 'page']), ['sort' => $field, 'direction' => request('sort') == $field && request('direction') == 'asc' ? 'desc' : 'asc'])) }}">
                                            <svg class="w-3 h-3 ml-1 {{ request('sort') == $field ? (request('direction') == 'asc' ? 'rotate-180' : '') : 'opacity-30' }}"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                            @endforeach


                            <th scope="col" class="px-6 py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $pasien)
                            <tr class="bg-white border-b">
                                <td
                                    class="px-6 py-4 font-medium {{ empty($pasien->no_erm) ? 'text-red-500' : 'text-gray-900' }}">
                                    {{ $pasien->no_erm ?? 'Belum ada' }}
                                </td>
                                <td class="px-6 py-4 font-medium {{ empty($pasien->nama) ? 'text-red-500' : 'text-gray-900' }}">
                                    {{ $pasien->nama ?? 'Belum diisi' }}
                                </td>
                                <td class="px-6 py-4 {{ empty($pasien->nik) ? 'text-red-500' : '' }}">
                                    {{ $pasien->nik ?? 'Belum diisi' }}
                                </td>
                                <td class="px-6 py-4 {{ empty($pasien->tanggal_lahir) ? 'text-red-500' : '' }}">
                                    {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diisi' }}
                                </td>
                                <td class="px-6 py-4 {{ empty($pasien->no_whatsapp) ? 'text-red-500' : 'text-green-600' }}">
                                    @if (!empty($pasien->no_whatsapp))
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pasien->no_whatsapp) }}"
                                            target="_blank" class="hover:underline">
                                            {{ $pasien->no_whatsapp }}
                                        </a>
                                    @else
                                        Belum diisi
                                    @endif
                                </td>

                                <td class="px-6 py-4 flex space-x-2">
                                    <button onclick="editPasien(
                                                            '{{ $pasien->id }}',
                                                            '{{ $pasien->nama }}',
                                                            '{{ $pasien->nik }}',
                                                            '{{ $pasien->no_whatsapp }}',
                                                            '{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}',
                                                            '{{ $pasien->no_erm ?? '' }}'
                                                        )"
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-md text-xs font-semibold transition duration-200">
                                        Edit
                                    </button>
                                    <button onclick="confirmDelete('{{ route('laboran.data-pasien.destroy', $pasien->id) }}')"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Tidak ada data pasien yang
                                    ditemukan.</td> {{-- Update colspan --}}
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="flex justify-center mt-6">
                <div class="join text-sm">
                    {{-- Previous Button --}}
                    @if ($pasiens->onFirstPage())
                        <button class="join-item btn btn-sm btn-disabled">&laquo;</button>
                    @else
                        <a href="{{ $pasiens->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
                    @endif

                    {{-- Dynamic Pages --}}
                    @php
                        $current = $pasiens->currentPage();
                        $last = $pasiens->lastPage();
                        $start = max($current - 2, 1);
                        $end = min($current + 2, $last);

                        if ($last > 5) {
                            if ($current <= 3) {
                                $start = 1;
                                $end = 5;
                            } elseif ($current >= $last - 2) {
                                $start = $last - 4;
                                $end = $last;
                            }
                        }
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $pasiens->url(1) }}" class="join-item btn btn-sm">1</a>
                        @if ($start > 2)
                            <button class="join-item btn btn-sm btn-disabled">...</button>
                        @endif
                    @endif

                    @for ($i = $start; $i <= $end; $i++)
                        <a href="{{ $pasiens->url($i) }}"
                            class="join-item btn btn-sm {{ $i == $current ? 'bg-blue-100 text-blue-600' : '' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    @if ($end < $last)
                        @if ($end < $last - 1)
                            <button class="join-item btn btn-sm btn-disabled">...</button>
                        @endif
                        <a href="{{ $pasiens->url($last) }}" class="join-item btn btn-sm">{{ $last }}</a>
                    @endif

                    {{-- Next Button --}}
                    @if ($pasiens->hasMorePages())
                        <a href="{{ $pasiens->nextPageUrl() }}" class="join-item btn btn-sm">&raquo;</a>
                    @else
                        <button class="join-item btn btn-sm btn-disabled">&raquo;</button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- Universal Popup Modal for alerts --}}
    {{-- This modal is now handled by Flowbite's Modal component --}}
    <div id="popup-modal" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
        <div class="relative w-full max-w-sm sm:max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <svg id="modal-icon" class="mx-auto mb-4 w-10 h-10 sm:w-12 sm:h-12" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {{-- SVG Path will be set by Javascript --}}
                    </svg>
                    <h3 class="mb-2 text-base sm:text-lg font-normal text-gray-500 dark:text-gray-400">
                        <span id="modal-message">Pesan</span>
                    </h3>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.3/dist/flowbite.min.js"></script>
    <script>
        // Variabel global untuk menyimpan instance modal
        let flowbitePopupModal;
        let flowbiteDeleteModal;
        let flowbiteEditModal;

        document.addEventListener('DOMContentLoaded', function () {
            // =========================
            // Inisialisasi Modal
            // =========================

            // Inisialisasi modal notifikasi
            const popupModalElement = document.getElementById('popup-modal');
            if (popupModalElement && typeof Modal !== 'undefined') {
                flowbitePopupModal = new Modal(popupModalElement, {
                    backdrop: 'static', // Tidak bisa tutup klik luar
                    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                    closable: true
                });
            }

            // Inisialisasi modal konfirmasi hapus
            const deleteModalElement = document.getElementById('delete-modal');
            if (deleteModalElement && typeof Modal !== 'undefined') {
                flowbiteDeleteModal = new Modal(deleteModalElement);
            }

            // Inisialisasi modal edit pasien
            const editModalElement = document.getElementById('edit-modal');
            if (editModalElement && typeof Modal !== 'undefined') {
                flowbiteEditModal = new Modal(editModalElement);
            }

            // =========================
            // Tampilkan Notifikasi Flash dari Laravel
            // =========================
            function showNotification(type, message) {
                if (!flowbitePopupModal) return;

                const iconElement = document.getElementById('modal-icon');
                const messageElement = document.getElementById('modal-message');

                // Reset konten ikon dan pesan
                iconElement.className = 'mx-auto mb-4 w-10 h-10 sm:w-12 sm:h-12';
                iconElement.innerHTML = '';
                messageElement.innerText = message;

                // Path ikon SVG
                const checkmarkPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                const xmarkPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />`;
                const infoPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />`;

                // Tentukan jenis ikon dan warna berdasarkan tipe
                if (type.includes('success')) {
                    iconElement.innerHTML = checkmarkPath;
                    iconElement.classList.add('text-green-500', 'stroke-green-500');
                } else if (type === 'error') {
                    iconElement.innerHTML = xmarkPath;
                    iconElement.classList.add('text-red-500', 'stroke-red-500');
                } else {
                    iconElement.innerHTML = infoPath;
                    iconElement.classList.add('text-blue-500', 'stroke-blue-500');
                }

                flowbitePopupModal.show(); // Tampilkan modal
                setTimeout(() => flowbitePopupModal.hide(), 2500); // Auto-tutup setelah 2.5 detik
            }

            // Tampilkan error validasi Laravel (jika ada)
            @if ($errors->any())
                const rawMessage = @json($errors->first());
                const translated = {
                    "The nik has already been taken.": "NIK sudah digunakan.",
                    "The no whatsapp has already been taken.": "Nomor WhatsApp sudah digunakan.",
                    "The no erm has already been taken.": "Nomor ERM sudah digunakan.",
                };
                const finalMessage = translated[rawMessage] ?? rawMessage;
                showNotification('error', finalMessage);
            @endif

            // Tampilkan notifikasi sukses dari session
            @if (session('success'))
                showNotification('success', "{{ session('success') }}");
            @endif

            // =========================
            // AJAX Live Search
            // =========================

            const searchInput = document.getElementById('search-pasien');
            const tableContainer = document.getElementById('table-container');
            const mobileCardsContainer = document.getElementById('mobile-cards-container');
            const paginationContainer = document.querySelector('.flex.justify-center.mt-6 nav');
            let timeoutId;

            // AJAX pencarian dinamis saat user mengetik
            if (searchInput) {
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeoutId); // Reset delay sebelumnya
                    const query = this.value.trim();

                    timeoutId = setTimeout(() => {
                        // Ambil parameter sorting dari URL
                        const sortParam = new URLSearchParams(window.location.search).get('sort') || '';
                        const directionParam = new URLSearchParams(window.location.search).get('direction') || '';

                        // Kirim request pencarian
                        fetch(`/laboran/data-pasien?search=${encodeURIComponent(query)}&sort=${sortParam}&direction=${directionParam}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                            .then(response => response.text())
                            .then(html => {
                                const doc = new DOMParser().parseFromString(html, 'text/html');
                                tableContainer.innerHTML = doc.getElementById('table-container')?.innerHTML ?? '';
                                mobileCardsContainer.innerHTML = doc.getElementById('mobile-cards-container')?.innerHTML ?? '';
                                paginationContainer.innerHTML = doc.querySelector('.flex.justify-center.mt-6 nav')?.innerHTML ?? '';
                            })
                            .catch(error => console.error('Live search error:', error));
                    }, 300); // Delay 300ms
                });
            }

            // =========================
            // AJAX Sorting & Pagination
            // =========================

            // Intersep klik pada link sorting atau pagination
            document.addEventListener('click', function (event) {
                const link = event.target.closest('a');
                if (!link || !link.href) return;

                if (link.closest('#table-container') || link.closest('.flex.justify-center.mt-6 nav')) {
                    event.preventDefault(); // Stop reload halaman

                    fetch(link.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(response => response.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            tableContainer.innerHTML = doc.getElementById('table-container')?.innerHTML ?? '';
                            mobileCardsContainer.innerHTML = doc.getElementById('mobile-cards-container')?.innerHTML ?? '';
                            paginationContainer.innerHTML = doc.querySelector('.flex.justify-center.mt-6 nav')?.innerHTML ?? '';
                            window.history.pushState({ path: link.href }, '', link.href); // Update URL tanpa reload
                        })
                        .catch(error => console.error('Pagination/Sorting error:', error));
                }
            });
        });

        // =========================
        // Fungsi Modal CRUD
        // =========================

        // Menampilkan modal konfirmasi hapus
        function confirmDelete(url) {
            const form = document.getElementById('delete-form');
            form.action = url; // Set action form
            if (flowbiteDeleteModal) flowbiteDeleteModal.show();
        }

        // Menampilkan modal edit pasien dengan data yang sudah diisi
        function editPasien(id, nama, nik, no_whatsapp, tanggal_lahir, no_erm) {
            document.getElementById('pasien_id').value = id;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nik').value = nik;
            document.getElementById('edit_no_whatsapp').value = no_whatsapp;
            document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
            document.getElementById('edit_no_erm').value = no_erm;
            document.getElementById('edit-form').action = `/laboran/data-pasien/${id}`;
            if (flowbiteEditModal) flowbiteEditModal.show();
        }

        // Menutup modal edit pasien
        function closeEditModal() {
            if (flowbiteEditModal) flowbiteEditModal.hide();
        }
    </script>


@endsection