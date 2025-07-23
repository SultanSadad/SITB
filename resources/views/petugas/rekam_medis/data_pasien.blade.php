{{-- Nama File = data_pasien.blade.php --}}
{{-- Deskripsi = Update modal data pasien --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 10 April 2025 --}}
{{--
Perbaikan tambahan:
- Deskripsi = Perbaikan layout dan jarak
- Dibuat oleh = Saskia Nadira - 3312301031
- Tanggal = 16 April 2025
--}}

{{-- Nama File = data_pasien.blade.php --}}
{{-- Deskripsi = Update modal data pasien --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 10 April 2025 --}}
@extends('layout.rekam_medis')
<title>Data Pasien</title>
@section('rekam_medis')

    <div class="px-3 sm:px-6 mt-4">
        <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Pasien</h1>

        <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
            <div class="mb-4 sm:mb-6">
                <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4 mb-4">
                    <form action="{{ url('petugas/rekam-medis/data-pasien') }}" method="GET" class="flex-grow">
                        <div class="relative flex flex-col sm:flex-row gap-2 items-stretch sm:items-center w-full">
                            <div class="relative flex">
                                <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
                                    class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                                    value="{{ request('search') }}">
                                <i
                                    class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>

                            <div class="hidden lg:flex space-x-2 flex-shrink-0">
                                <a href="{{ route('rekam-medis.pasien.index') }}"
                                    class="px-3 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition flex items-center {{ !request()->has('verification_status') ? 'ring-1 ring-blue-300 bg-blue-50' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    Semua
                                </a>

                                <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'verified']) }}"
                                    class="px-3 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition flex items-center {{ request()->get('verification_status') == 'verified' ? 'ring-1 ring-green-300 bg-green-50' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terverifikasi
                                </a>

                                <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'unverified']) }}"
                                    class="px-3 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition flex items-center {{ request()->get('verification_status') == 'unverified' ? 'ring-1 ring-yellow-300 bg-yellow-50' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Belum
                                </a>
                            </div>
                        </div>
                    </form>
                    <button type="button"
                        class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center lg:ml-3 flex-shrink-0 w-full sm:w-auto"
                        data-modal-toggle="crud-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Tambah Pasien
                    </button>
                </div>

                <div class="flex lg:hidden space-x-2 mb-2">
                    <a href="{{ route('rekam-medis.pasien.index') }}"
                        class="flex-1 px-2 py-2 text-xs font-medium text-center text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition flex items-center justify-center {{ !request()->has('verification_status') ? 'ring-1 ring-blue-300 bg-blue-50' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        <span class="hidden sm:inline">Semua</span>
                    </a>

                    <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'verified']) }}"
                        class="flex-1 px-2 py-2 text-xs font-medium text-center text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition flex items-center justify-center {{ request()->get('verification_status') == 'verified' ? 'ring-1 ring-green-300 bg-green-50' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="hidden sm:inline">Terverifikasi</span>
                    </a>

                    <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'unverified']) }}"
                        class="flex-1 px-2 py-2 text-xs font-medium text-center text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition flex items-center justify-center {{ request()->get('verification_status') == 'unverified' ? 'ring-1 ring-yellow-300 bg-yellow-50' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span class="hidden sm:inline">Belum</span>
                    </a>
                </div>
            </div>

            <div id="crud-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50 p-4">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md max-h-[90vh] overflow-y-auto">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Tambah Pasien</h3>
                            {{-- Gunakan data-modal-toggle untuk menutup --}}
                            <button type="button" class="text-gray-400 hover:text-gray-900 text-2xl leading-none"
                                data-modal-toggle="crud-modal">&times;</button>
                        </div>
                        <form action="{{ route('rekam-medis.pasien.store') }}" method="POST">
                            @csrf
                            <div class="grid gap-4 mb-4">
                                <div>
                                    <label for="no_erm" class="block text-sm font-medium text-gray-900 mb-1">No. ERM<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" id="no_erm" name="no_erm"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" required>
                                </div>
                                <div>
                                    <label for="nama_pasien" class="block text-sm font-medium text-gray-900 mb-1">Nama
                                        Pasien<span class="text-red-600">*</span></label>
                                    <input type="text" id="nama_pasien" name="nama_pasien"
                                        class="w-full border border-gray-300  rounded-lg p-2.5 text-sm" required>
                                </div>
                                <div>
                                    <label for="nik" class="block text-sm font-medium text-gray-900 mb-1">NIK</label>
                                    <input type="text" id="nik" name="nik"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" maxlength="16"
                                        inputmode="numeric" pattern="^\d{16}$" title="NIK harus 16 digit angka."
                                        oninput="this.setCustomValidity('')"
                                        oninvalid="this.setCustomValidity('NIK harus 16 digit angka.')">


                                </div>
                                <div>
                                    <label for="no_whatsapp" class="block text-sm font-medium text-gray-900 mb-1">No.
                                        WhatsApp</label>
                                    <input type="tel" id="no_whatsapp" name="no_whatsapp"
                                        class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" pattern="^\d{10}$"
                                        maxlength="10" inputmode="numeric" title="Nomor WhatsApp harus 10 digit angka."
                                        oninput="this.setCustomValidity('')"
                                        oninvalid="this.setCustomValidity('Nomor WhatsApp harus 10 digit angka.')">


                                </div>
                                <div>
                                    <label for="tanggal_lahir" class="block text-sm font-medium text-gray-900 mb-1">Tanggal
                                        Lahir</label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                        class="w-full border rounded-lg p-2.5 text-sm border-gray-300 ">
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row justify-end gap-2">
                                {{-- Gunakan data-modal-toggle untuk menutup --}}
                                <button type="button" data-modal-toggle="crud-modal"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto order-2 sm:order-1">Batal</button>
                                <button type="submit"
                                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto order-1 sm:order-2">Tambah
                                    Pasien</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="edit-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md max-h-[90vh] overflow-y-auto">
                    <div class="p-4 sm:p-5">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Edit Data Pasien</h3>
                            {{-- Panggil closeEditModal() --}}
                            <button type="button" class="text-gray-400 hover:text-gray-900 text-2xl leading-none"
                                onclick="closeEditModal()">&times;</button>
                        </div>
                        <form id="edit-form" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" id="pasien_id" name="pasien_id">
                            <div class="grid gap-4 mb-4">
                                <div>
                                    <label for="edit_no_erm" class="block text-sm font-medium text-gray-900 mb-1">No.
                                        ERM</label>
                                    <input type="text" id="edit_no_erm" name="no_erm"
                                        class="w-full border rounded-lg p-2.5 text-sm border-gray-300" required>
                                </div>
                                <div>
                                    <label for="edit_nama" class="block text-sm font-medium text-gray-900 mb-1">Nama</label>
                                    <input type="text" id="edit_nama" name="nama"
                                        class="w-full border rounded-lg p-2.5 text-sm border-gray-300" required>
                                </div>
                                <div>
                                    <label for="edit_nik" class="block text-sm font-medium text-gray-900 mb-1">NIK</label>
                                    <input type="text" id="edit_nik" name="nik"
                                        class="w-full border rounded-lg p-2.5 text-sm border-gray-300" pattern="[0-9]{16}"
                                        maxlength="16" title="Nomor Induk Kependudukan (NIK) harus 16 digit angka."
                                        inputmode="numeric"> {{-- 'required' DIHAPUS di sini --}}
                                </div>
                                <div>
                                    <label for="edit_no_whatsapp" class="block text-sm font-medium text-gray-900 mb-1">No.
                                        WhatsApp</label>
                                    <input type="tel" id="edit_no_whatsapp" name="no_whatsapp"
                                        class="w-full border rounded-lg p-2.5 text-sm border-gray-300"
                                        pattern="^\+?[0-9]{10,14}$" maxlength="14"
                                        title="Masukkan nomor WhatsApp yang valid (contoh: +6281234567890). Minimal 10 digit, maksimal 14 digit."
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '');"> {{-- 'required' DIHAPUS
                                    di sini --}}
                                </div>
                                <div>
                                    <label for="edit_tanggal_lahir"
                                        class="block text-sm font-medium text-gray-900 mb-1">Tanggal
                                        Lahir</label>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
                                        class="w-full border rounded-lg p-2.5 text-sm border-gray-300">
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row justify-end gap-2">
                                {{-- Panggil closeEditModal() --}}
                                <button type="button" onclick="closeEditModal()"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto order-2 sm:order-1">Batal</button>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto order-1 sm:order-2">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="delete-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black bg-opacity-50">
                <div class="relative w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        {{-- Panggil closeDeleteModal() --}}
                        <button type="button"
                            class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white"
                            onclick="closeDeleteModal()">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg"
                                aria-hidden="true">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>

                        <div class="p-6 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" fill="none"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-medium text-gray-700 dark:text-gray-300">
                                Yakin ingin menghapus data pasien ini?
                            </h3>

                            <form id="delete-form" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
                                    {{-- Panggil closeDeleteModal() --}}
                                    <button type="button" onclick="closeDeleteModal()"
                                        class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 w-full sm:w-auto dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Batal
                                    </button>
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto">
                                        Hapus
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="table-container" class="mt-6">
                <div class="block md:hidden space-y-4">
                    @foreach ($pasiens as $pasien)
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">
                                        @if($pasien->nama)
                                            {{ $pasien->nama }}
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </h4>
                                    <p class="text-xs text-gray-600 mt-1">
                                        ERM: @if($pasien->no_erm)
                                            {{ $pasien->no_erm }}
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" class="verifikasi-checkbox accent-blue-600"
                                        data-id="{{ $pasien->id }}" {{ $pasien->verifikasi ? 'checked' : '' }}>
                                    <label class="text-xs text-gray-600">Verifikasi</label>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-2 text-xs text-gray-600 mb-4"> {{-- Ubah mb-3 menjadi mb-4 untuk
                                jarak ke tombol --}}
                                <div>
                                    <span class="font-medium">NIK:</span>
                                    @if($pasien->nik)
                                        {{ $pasien->nik }}
                                    @else
                                        <span class="text-red-500">Belum diisi</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-medium">Tanggal Lahir:</span>
                                    @if($pasien->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d-m-Y') }}
                                    @else
                                        <span class="text-red-500">Belum diisi</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-medium">WhatsApp:</span>
                                    @if($pasien->no_whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pasien->no_whatsapp) }}"
                                            target="_blank" class="text-green-600 hover:underline">
                                            {{ $pasien->no_whatsapp }}
                                        </a>
                                    @else
                                        <span class="text-red-500">Belum diisi</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Bagian ini yang diubah untuk layout tombol --}}
                            <div class="flex gap-2"> {{-- Gunakan flex dan gap-2 untuk jarak antar tombol --}}
                                <button
                                    onclick="editPasien({{ $pasien->id }}, '{{ $pasien->nama }}', '{{ $pasien->nik }}', '{{ $pasien->no_whatsapp }}', '{{ $pasien->tanggal_lahir }}', '{{ $pasien->no_erm }}')"
                                    class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 w-1/2">
                                    {{-- Kelas disesuaikan agar sama dengan tombol staf --}}
                                    Edit
                                </button>

                                <button onclick="confirmDelete('{{ route('rekam-medis.pasien.destroy', $pasien->id) }}')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 w-1/2">
                                    {{-- Kelas disesuaikan agar sama dengan tombol staf --}}
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="hidden md:block overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-3 lg:px-6 py-3">
                                    <div class="flex items-center">
                                        <span>NO.ERM</span>
                                        <a
                                            href="{{ route('rekam-medis.pasien.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'no_erm', 'direction' => $sortField == 'no_erm' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}">
                                            <svg class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="px-3 lg:px-6 py-3">
                                    <div class="flex items-center">
                                        <span>NAMA</span>
                                        <a
                                            href="{{ route('rekam-medis.pasien.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'nama', 'direction' => $sortField == 'nama' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}">
                                            <svg class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="px-3 lg:px-6 py-3 hidden lg:table-cell">
                                    <div class="flex items-center">
                                        <span>NIK</span>
                                        <a
                                            href="{{ route('rekam-medis.pasien.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'nik', 'direction' => $sortField == 'nik' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}">
                                            <svg class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="px-6 py-3">
                                    <div class="flex items-center">
                                        <span>TGL LAHIR</span>
                                        <a
                                            href="{{ route('rekam-medis.pasien.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'tanggal_lahir', 'direction' => $sortField == 'tanggal_lahir' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}">
                                            <svg class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>
                                <th class="px-6 py-3">
                                    <div class="flex items-center">
                                        <span>NO. WA</span>
                                        <a
                                            href="{{ route('rekam-medis.pasien.index', array_merge(request()->except(['sort', 'direction']), ['sort' => 'no_whatsapp', 'direction' => $sortField == 'no_whatsapp' && $sortDirection == 'asc' ? 'desc' : 'asc'])) }}">
                                            <svg class="w-3 h-3 ml-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z" />
                                            </svg>
                                        </a>
                                    </div>
                                </th>

                                <th class="px-6 py-3">
                                    <div class="flex items-center justify-center">
                                        <span>VERIFIKASI</span>

                                    </div>
                                </th>
                                <th class="px-6 py-3">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pasiens as $pasien)
                                <tr class="bg-white border-b">
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        @if($pasien->no_erm)
                                            {{ $pasien->no_erm }}
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        @if($pasien->nama)
                                            {{ $pasien->nama }}
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($pasien->nik)
                                            {{ $pasien->nik }}
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($pasien->tanggal_lahir)
                                            {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d-m-Y') }}
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-green-600 font-sm">
                                        @if($pasien->no_whatsapp)
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pasien->no_whatsapp) }}"
                                                target="_blank" class="hover:underline">
                                                {{ $pasien->no_whatsapp }}
                                            </a>
                                        @else
                                            <span class="text-red-500">Belum diisi</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center">
                                            <input type="checkbox" class="verifikasi-checkbox accent-blue-600"
                                                data-id="{{ $pasien->id }}" {{ $pasien->verifikasi ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <button
                                            onclick="editPasien(
                                                                                                                                                                                                        '{{ $pasien->id }}',
                                                                                                                                                                                                        '{{ $pasien->nama }}',
                                                                                                                                                                                                        '{{ $pasien->nik }}',
                                                                                                                                                                                                        '{{ $pasien->no_whatsapp }}',
                                                                                                                                                                                                        '{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}',
                                                                                                                                                                                                        '{{ $pasien->no_erm ?? '' }}'
                                                                                                                                                                                )"
                                            class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-md text-xs font-semibold">
                                            Edit
                                        </button>

                                        <button
                                            onclick="confirmDelete('{{ route('rekam-medis.pasien.destroy', $pasien->id) }}')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                            Hapus
                                        </button>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Hitung range halaman --}}
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
                    } else {
                        $start = 1;
                        $end = $last;
                    }
                @endphp

                <div class="flex justify-center mt-6">
                    <div class="join text-sm">
                        {{-- Tombol Sebelumnya --}}
                        @if ($pasiens->onFirstPage())
                            <button
                                class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $pasiens->previousPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&laquo;</a>
                        @endif

                        {{-- Halaman --}}
                        @for ($page = 1; $page <= $last; $page++)
                            @if ($page == 1 || $page == $last || ($page >= $current - 1 && $page <= $current + 1))
                                <a href="{{ $pasiens->url($page) }}"
                                    class="join-item btn btn-sm border {{ $page == $current ? 'bg-blue-100 text-blue-600 border-blue-300' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                                    {{ $page }}
                                </a>
                            @elseif ($page == $current - 2 || $page == $current + 2)
                                <button class="join-item btn btn-sm btn-disabled border border-gray-200">...</button>
                            @endif
                        @endfor

                        {{-- Tombol Berikutnya --}}
                        @if ($pasiens->hasMorePages())
                            <a href="{{ $pasiens->nextPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
                        @else
                            <button
                                class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div id="popup-modal" tabindex="-1"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <div class="p-4 md:p-5 text-center">
                        <svg id="modal-icon" class="mx-auto mb-4 w-12 h-12" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            {{-- Path akan diatur via JS sesuai tipe notifikasi --}}
                        </svg>
                        <h3 class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                            <span id="modal-message">Pesan</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pastikan Flowbite JS dimuat setelah elemen-elemen modal --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.3/dist/flowbite.min.js"></script>
        <script>
            let flowbitePopupModal; // Untuk notifikasi modal
            let crudModal; // Untuk modal "Tambah Pasien"
            let editModal; // Untuk modal "Edit Data Pasien"
            let deleteModal; // Untuk modal "Yakin ingin menghapus data akun ini?"

            document.addEventListener('DOMContentLoaded', function () {
                // Inisialisasi modal popup notifikasi dari Flowbite
                const popupModalElement = document.getElementById('popup-modal');
                if (popupModalElement && typeof Modal !== 'undefined') {
                    flowbitePopupModal = new Modal(popupModalElement);
                } else {
                    console.error("Flowbite Modal atau elemen 'popup-modal' tidak ditemukan.");
                }
                // Inisialisasi modal Tambah Pasien
                const crudModalElement = document.getElementById('crud-modal');
                if (crudModalElement && typeof Modal !== 'undefined') {
                    crudModal = new Modal(crudModalElement);
                }

                // Inisialisasi modal Edit Data Pasien (jangan pakai data-modal-toggle untuk pembukaan, hanya penutupan)
                const editModalElement = document.getElementById('edit-modal');
                if (editModalElement && typeof Modal !== 'undefined') {
                    editModal = new Modal(editModalElement);
                }

                // Inisialisasi modal Hapus
                const deleteModalElement = document.getElementById('delete-modal');
                if (deleteModalElement && typeof Modal !== 'undefined') {
                    deleteModal = new Modal(deleteModalElement);
                }
                // Cek apakah ada error validasi dari Laravel
                @if ($errors->any())
                    const rawMessage = @json($errors->first()); // Ambil pesan error pertama
                    const translated = {
                        "The nik has already been taken.": "NIK sudah digunakan.",
                        "The no whatsapp has already been taken.": "Nomor WhatsApp sudah digunakan.",
                        "The no erm has already been taken.": "Nomor ERM sudah digunakan.",
                        "The nama pasien field is required.": "Nama pasien wajib diisi.",
                    };
                    const finalMessage = translated[rawMessage] ?? rawMessage; // Gunakan terjemahan jika tersedia
                    showNotification('error', finalMessage); // Tampilkan notifikasi error
                @endif

                // Cek apakah ada pesan sukses dari session
                @if (session('success_type') && session('success_message'))
                    // Tampilkan notifikasi dengan tipe dan pesan sukses dari session
                    showNotification("{{ session('success_type') }}", "{{ session('success_message') }}");
                @elseif (session('success'))
                    // Jika hanya ada pesan sukses umum, deteksi jenisnya dari kata kunci
                    const message = "{{ session('success') }}";
                    let type = 'success_general';
                    if (message.includes('ditambahkan')) type = 'success_add';
                    else if (message.includes('diperbarui')) type = 'success_edit';
                    else if (message.includes('dihapus')) type = 'success_delete';
                    showNotification(type, message); // Tampilkan notifikasi sukses
                @endif

                // --- Penanganan Input NIK (Gabungan) ---
                function setupNikInput(inputElement) {
                    if (!inputElement) return;

                    inputElement.addEventListener('input', function () {
                        let value = this.value.replace(/\D/g, ''); // Hapus karakter non-digit
                        if (value.length > 16) {
                            value = value.slice(0, 16);
                        }
                        this.value = value;
                    });

                    inputElement.addEventListener('paste', function (event) {
                        const pasteData = event.clipboardData.getData('text');
                        const sanitizedData = pasteData.replace(/\D/g, ''); // Hapus non-digit
                        const currentValue = this.value.replace(/\D/g, ''); // Ambil hanya digit dari nilai saat ini

                        let newValue = (currentValue + sanitizedData).slice(0, 16);

                        event.preventDefault();
                        this.value = newValue;
                    });

                    // Tambahkan event listener untuk validasi kustom NIK
                    inputElement.addEventListener('invalid', function (event) {
                        // Pesan error hanya jika ada input DAN TIDAK 16 digit
                        if (this.value && this.value.length !== 16) {
                            event.target.setCustomValidity("NIK harus terdiri dari 16 digit angka.");
                        } else {
                            // Reset pesan validasi jika input kosong atau sudah benar (16 digit)
                            event.target.setCustomValidity("");
                        }
                    });

                    inputElement.addEventListener('input', function (event) {
                        // Hapus pesan validasi kustom saat pengguna mulai mengetik lagi
                        event.target.setCustomValidity("");
                    });
                }

                // Pastikan pemanggilan ini ada:
                setupNikInput(document.getElementById('nik')); // Untuk modal Tambah Pasien (jika di sana juga opsional, hapus 'required' di HTMLnya)
                setupNikInput(document.getElementById('edit_nik')); // Untuk modal Edit Pasien (sekarang opsional)


            }); // End DOMContentLoaded

            // Fungsi untuk menampilkan notifikasi
            function showNotification(type, message) {
                if (!flowbitePopupModal) {
                    console.error("Modal Flowbite belum terinisialisasi.");
                    return;
                }

                const icon = document.getElementById('modal-icon');
                const msg = document.getElementById('modal-message');

                icon.className = 'mx-auto mb-4 w-12 h-12';
                icon.innerHTML = '';
                msg.innerText = message;

                const checkmark = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                const xmark = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                const info = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`;

                if (type === 'success_add') {
                    icon.classList.add('text-green-500');
                    icon.innerHTML = checkmark;
                } else if (type === 'success_edit') {
                    icon.classList.add('text-blue-500');
                    icon.innerHTML = checkmark;
                } else if (type === 'success_delete') {
                    icon.classList.add('text-red-500');
                    icon.innerHTML = checkmark;
                } else if (type === 'success_general') {
                    icon.classList.add('text-green-500');
                    icon.innerHTML = checkmark;
                } else if (type === 'error') {
                    icon.classList.add('text-red-500');
                    icon.innerHTML = xmark;
                } else if (type === 'info') {
                    icon.classList.add('text-blue-500');
                    icon.innerHTML = info;
                }

                flowbitePopupModal.show();
                setTimeout(() => {
                    flowbitePopupModal.hide();
                }, 2500);
            }

            // Fungsi untuk konfirmasi hapus
            function confirmDelete(url) {
                if (!deleteModal) {
                    console.error("Delete Modal Flowbite belum terinisialisasi.");
                    return;
                }
                document.getElementById('delete-form').action = url;
                deleteModal.show(); // Tampilkan modal hapus
            }

            // Fungsi untuk menutup modal hapus
            function closeDeleteModal() {
                if (deleteModal) {
                    deleteModal.hide(); // Sembunyikan modal hapus
                }
            }

            // Fungsi untuk mengisi data ke modal edit pasien dan menampilkannya
            function editPasien(id, nama, nik, no_whatsapp, tanggal_lahir, no_erm) {
                if (!editModal) {
                    console.error("Edit Modal Flowbite belum terinisialisasi.");
                    return;
                }
                document.getElementById('pasien_id').value = id;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_nik').value = nik || '';
                document.getElementById('edit_no_whatsapp').value = no_whatsapp || '';
                document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
                document.getElementById('edit_no_erm').value = no_erm;

                let updateUrl = "{{ route('rekam-medis.pasien.update', ['pasien' => ':id']) }}";
                updateUrl = updateUrl.replace(':id', id);
                document.getElementById('edit-form').action = updateUrl;

                editModal.show(); // Tampilkan modal edit
            }

            // Fungsi untuk menutup modal edit pasien
            function closeEditModal() {
                if (editModal) {
                    editModal.hide(); // Sembunyikan modal edit
                }
            }

            // Fungsi live search pasien
            document.addEventListener('DOMContentLoaded', function () { // Pindah ke dalam DOMContentLoaded
                const searchInput = document.getElementById('search-pasien');
                let timeoutId;
                searchInput.addEventListener('input', function () {
                    clearTimeout(timeoutId);
                    const query = this.value.trim();

                    timeoutId = setTimeout(() => {
                        const url = new URL(window.location);
                        if (query) {
                            url.searchParams.set('search', query);
                        } else {
                            url.searchParams.delete('search');
                        }
                        window.history.pushState({}, '', url);

                        fetch(`/rekam_medis/data-pasien?search=${encodeURIComponent(query)}`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(res => res.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const container = document.getElementById('table-container');
                                const newContainer = doc.getElementById('table-container');
                                if (container && newContainer) {
                                    container.innerHTML = newContainer.innerHTML;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    }, 300);
                });
            });

            // Checkbox toggle verifikasi pasien (pakai jQuery)
            $(document).ready(function () {
                $('#table-container').on('change', '.verifikasi-checkbox', function () {
                    const id = $(this).data('id');
                    const isChecked = $(this).prop('checked');
                    const checkbox = $(this);

                    const url = "{{ route('rekam-medis.pasien.verifikasi', ['id' => ':id']) }}".replace(':id', id);

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            verifikasi: isChecked ? 1 : 0,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            if (response.success) {
                                const msg = isChecked ? 'Data pasien telah berhasil diverifikasi.' : 'Verifikasi dibatalkan.';
                                showNotification('success_general', msg);
                            } else {
                                showNotification('error', 'Gagal memperbarui status verifikasi.');
                                checkbox.prop('checked', !isChecked);
                            }
                        },
                        error: function () {
                            showNotification('error', 'Terjadi kesalahan saat update verifikasi.');
                            checkbox.prop('checked', !isChecked);
                        }
                    });
                });
            });
        </script>
        <script>
            document.getElementById('no_whatsapp').addEventListener('invalid', function (event) {
                if (event.target.validity.patternMismatch) {
                    event.target.setCustomValidity("Nomor WhatsApp harus berupa angka dan bisa diawali dengan '+'. Minimal 6 digit, maksimal 15 digit.");
                }
            });

            document.getElementById('no_whatsapp').addEventListener('input', function (event) {
                // Hapus pesan validasi kustom saat pengguna mulai mengetik lagi
                event.target.setCustomValidity("");
            });
        </script>
        <script>
            document.getElementById('edit_no_whatsapp').addEventListener('invalid', function (event) {
                // Pesan error hanya jika ada input (this.value tidak kosong)
                if (this.value) {
                    if (event.target.validity.patternMismatch || event.target.validity.tooShort || event.target.validity.tooLong) {
                        event.target.setCustomValidity("Nomor WhatsApp harus berupa angka dan bisa diawali dengan '+'. Minimal 10 digit, maksimal 14 digit.");
                    } else {
                        // Reset pesan validasi jika input valid
                        event.target.setCustomValidity("");
                    }
                } else {
                    // Jika input kosong, tidak ada pesan error kustom (dianggap valid)
                    event.target.setCustomValidity("");
                }
            });

            document.getElementById('edit_no_whatsapp').addEventListener('input', function (event) {
                // Hapus pesan validasi kustom saat pengguna mulai mengetik lagi
                event.target.setCustomValidity("");
            });

        </script>
        <script>
            // Validasi untuk NIK
            ['nik', 'edit_nik'].forEach(function (id) {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('invalid', function () {
                        if (this.value && this.value.length !== 16) {
                            this.setCustomValidity('NIK harus 16 digit angka.');
                        } else {
                            this.setCustomValidity('');
                        }
                    });
                }
            });

            // Validasi untuk No WhatsApp
            ['no_whatsapp', 'edit_no_whatsapp'].forEach(function (id) {
                const input = document.getElementById(id);
                if (input) {
                    input.addEventListener('invalid', function () {
                        if (this.value && !/^\d{10}$/.test(this.value)) {
                            this.setCustomValidity('Nomor WhatsApp harus 10 digit angka.');
                        } else {
                            this.setCustomValidity('');
                        }
                    });
                }
            });
        </script>
@endsection