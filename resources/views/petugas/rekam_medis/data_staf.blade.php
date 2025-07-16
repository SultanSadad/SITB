{{-- Nama File   = modal.blade.php --}}
{{-- Deskripsi   = Template untuk modal notifikasi --}}
{{-- Dibuat oleh = Hafivah Tahta- 3312301100 --}}
{{-- Tanggal = 10 April 2025 --}}

{{-- Nama File   = [Berbagai file halaman rekam medis] --}}
{{-- Deskripsi   = Perbaiki semua layout rekam medis --}}
{{-- Dibuat oleh = Saskia Nadira - 3312301031 --}}
{{-- Tanggal     = 24 April 2025 --}}

{{-- Nama File   = [Berbagai file halaman] --}}
{{-- Deskripsi   = Update icon untuk semua aktor --}}
{{-- Dibuat oleh = Saskia Nadira - 3312301031 --}}
{{-- Tanggal     = 24 April 2025 --}}

{{-- Nama File   = data_staf.php --}}
{{-- Deskripsi   = Data staff --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal     = 16 April 2025 --}}


@extends('layout.rekam_medis')
<title>Data Akun</title>
@section('rekam_medis')
    <div class="px-3 sm:px-6 mt-4">
        <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Akun Staf</h1>
        <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <form action="{{ url('/rekam-medis/data-staf') }}" method="GET" class="w-full sm:w-auto">
                    <div class="relative w-full sm:w-60">
                        <input type="text" id="search-staf" name="q" placeholder="Cari Akun"
                            class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            value="{{ request('q') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>

                <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                    class="w-full sm:w-auto bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center sm:justify-start">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Tambah Akun
                </button>
            </div>

            <div id="crud-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Tambah Staf Baru
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
                        <form id="add-staf-form" action="{{ route('rekam-medis.staf.store') }}" method="POST"
                            class="p-4 md:p-5">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="nama"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nama" id="nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="" required pattern="[A-Za-z\s]+"
                                        title="Nama hanya boleh mengandung huruf dan spasi">
                                </div>
                                <div class="col-span-2">
                                    <label for="nip"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nip" id="nip"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="" required pattern="\d+" title="NIP hanya boleh mengandung angka"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                                <div class="col-span-2">
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="email" id="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        required>
                                </div>
                                <div class="col-span-2">
                                    <label for="no_whatsapp"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                                        WhatsApp<span class="text-red-600">*</span></label>
                                    <input type="text" name="no_whatsapp" id="no_whatsapp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                                        placeholder="" required pattern="^\+?[0-9]{10,14}$"
                                        title="Nomor WhatsApp harus angka atau dimulai dengan +, minimal 10 digit, maksimal 14 digit."
                                        minlength="10" maxlength="14"
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '');">
                                </div>
                                <div class="col-span-2">
                                    <label for="peran"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role<span
                                            class="text-red-600">*</span></label>
                                    <select name="peran" id="peran"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5"
                                        required>
                                        <option value="">Pilih Role</option>
                                        <option value="laboran">Laboran</option>
                                        <option value="rekam_medis">Rekam Medis</option>
                                    </select>
                                </div>
                                <div class="col-span-2 relative">
                                    <label for="password"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password<span
                                            class="text-red-600">*</span></label>
                                    <input type="password" name="password" id="password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10"
                                        required minlength="8">
                                    <i id="togglePassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                                <div class="col-span-2 relative">
                                    <label for="password_confirmation"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi
                                        Password<span class="text-red-600">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10"
                                        required>
                                    <i id="toggleKonfirmasiPassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-hide="crud-modal"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Tambah Akun
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
                                Edit Staf
                            </h3>
                            <button type="button"
                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                                onclick="editModalInstance.hide()">
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
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="edit_nama" class="block mb-2 text-sm font-medium text-gray-900">Nama<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nama" id="edit_nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        required>
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_nip" class="block mb-2 text-sm font-medium text-gray-900">NIP<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nip" id="edit_nip"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        required pattern="\d+" title="NIP hanya boleh mengandung angka"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_email"
                                        class="block mb-2 text-sm font-medium text-gray-900">Username<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="email" id="edit_email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        required>
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No.
                                        WhatsApp<span class="text-red-600">*</span></label>
                                    <input type="text" name="no_whatsapp" id="edit_no_whatsapp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        required pattern="^\+?[0-9]{10,14}$"
                                        title="Nomor WhatsApp harus angka atau dimulai dengan +, minimal 10 digit, maksimal 14 digit."
                                        minlength="10" maxlength="14"
                                        oninput="this.value = this.value.replace(/[^0-9+]/g, '');">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_peran" class="block mb-2 text-sm font-medium text-gray-900">Role<span
                                            class="text-red-600">*</span></label>
                                    <select name="peran" id="edit_peran"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                        required>
                                        <option value="laboran">Laboran</option>
                                        <option value="rekam_medis">Rekam Medis</option>
                                    </select>
                                </div>

                                <div class="col-span-2 relative">
                                    <label for="edit_password" class="block mb-2 text-sm font-medium text-gray-900">Password
                                        Baru
                                        (Opsional)</label>
                                    <input type="password" name="password" id="edit_password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pr-10"
                                        minlength="8">
                                    <i id="toggleEditPassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                                <div class="col-span-2 relative">
                                    <label for="edit_password_confirmation"
                                        class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi Password
                                        Baru</label>
                                    <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pr-10">
                                    <i id="toggleEditConfirmPassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" onclick="editModalInstance.hide()"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- START: MODAL HAPUS STAF (Diperbaiki) --}}
            <div id="delete-modal" tabindex="-1" aria-hidden="true"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4 bg-black/30 backdrop-blur-sm">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <div class="p-4 md:p-5 text-center">
                            {{-- Icon Warning --}}
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" fill="none"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-medium text-gray-700 dark:text-gray-300">
                                Yakin ingin menghapus data akun ini?
                            </h3>
                            <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
                                {{-- Tombol Batal dengan kelas yang sama persis seperti di data_pasien --}}
                                <button type="button" onclick="deleteModalInstance.hide()"
                                    class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 w-full sm:w-auto dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                    Batal
                                </button>
                                <form id="delete-form" method="POST" class="w-full sm:w-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END: MODAL HAPUS STAF --}}

            {{-- START: POPUP NOTIFIKASI UNIVERSAL (Tambahan) --}}
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
            {{-- END: POPUP NOTIFIKASI UNIVERSAL --}}


            <div id="table-container" class="mt-6">
                {{-- Bagian untuk tampilan mobile (kartu) --}}
                <div class="block md:hidden space-y-4">
                    @forelse($stafs as $staf)
                        <div class="bg-white rounded-lg p-4 border shadow-sm">
                            {{-- Bagian detail staf --}}
                            <div class="mb-3">
                                <h3 class="font-bold text-lg text-gray-900">{{ $staf->nama }}</h3>
                                <p class="text-sm text-gray-600">NIP: {{ $staf->nip }}</p>
                            </div>

                            <div class="grid grid-cols-1 gap-2 text-sm mb-4">
                                <p>
                                    <span class="font-semibold text-gray-600">Username:</span>
                                    <span class="ml-2 text-gray-800">{{ $staf->email }}</span>
                                </p>
                                <p>
                                    <span class="font-semibold text-gray-600">WhatsApp:</span>
                                    @if (!empty($staf->no_whatsapp))
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $staf->no_whatsapp) }}" target="_blank"
                                            class="ml-2 text-green-600 hover:underline">
                                            {{ $staf->no_whatsapp }}
                                        </a>
                                    @else
                                        <span class="ml-2 text-red-500">Belum diisi</span>
                                    @endif
                                </p>
                                <p>
                                    <span class="font-semibold text-gray-600">Role:</span>
                                    <span class="ml-2">
                                        @if ($staf->peran === 'laboran')
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-orange-800 bg-orange-200">
                                                Laboran
                                            </span>
                                        @elseif ($staf->peran === 'rekam_medis')
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-purple-800 bg-purple-200">
                                                Rekam Medis
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-gray-600">
                                                {{ ucfirst($staf->peran) }}
                                            </span>
                                        @endif
                                    </span>
                                </p>
                            </div>

                            <div class="flex gap-2">
                                <button data-id="{{ $staf->id }}"
                                    class="edit-btn bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 w-1/2">
                                    Edit
                                </button>
                                <button type="button"
                                    onclick="confirmDelete('{{ route('rekam-medis.staf.destroy', $staf->id) }}')"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold transition duration-200 w-1/2">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Tidak ada data staf yang ditemukan.</p>
                    @endforelse
                </div>

                {{-- Bagian untuk tampilan desktop (tabel) --}}
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700 border-collapse">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">NAMA</th>
                                <th scope="col" class="px-6 py-3">NIP</th>
                                <th scope="col" class="px-6 py-3">USERNAME</th>
                                <th scope="col" class="px-6 py-3">NO. WHATSAPP</th>
                                <th scope="col" class="px-6 py-3">ROLE</th>
                                <th scope="col" class="px-6 py-3">AKSI</th>
                            </tr>
                        </thead>
                        {{-- ID untuk tbody diperlukan untuk pembaruan AJAX --}}
                        <tbody id="staf-table-body">
                            {{-- Ini akan diisi oleh Blade atau AJAX --}}
                            @include('petugas.rekam_medis.partials.staf_table_rows')
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="pagination-links" class="flex justify-center items-center flex-col md:flex-row mt-6 gap-3">
                {{-- Info Data --}}
                {{-- Tombol Pagination --}}
                <div class="join text-sm">
                    {{-- Menggunakan Laravel Pagination Links --}}
                    {{ $stafs->links('pagination::tailwind') }}
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/flowbite@1.6.3/dist/flowbite.min.js"></script>

    <script>
        // Deklarasi variabel global untuk instance modal Flowbite
        let flowbitePopupModal; // Untuk notifikasi modal
        let crudModal; // Untuk modal "Tambah Akun"
        let editModalInstance; // Untuk modal "Edit Staf"
        let deleteModalInstance; // Untuk modal "Yakin ingin menghapus data akun ini?"

        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi modal popup notifikasi dari Flowbite
            const popupModalElement = document.getElementById('popup-modal');
            if (popupModalElement && typeof Modal !== 'undefined') {
                flowbitePopupModal = new Modal(popupModalElement);
            } else {
                console.error("Flowbite Modal atau elemen 'popup-modal' tidak ditemukan.");
            }

            // Inisialisasi modal Tambah Akun
            const crudModalElement = document.getElementById('crud-modal');
            if (crudModalElement && typeof Modal !== 'undefined') {
                crudModal = new Modal(crudModalElement);
            }

            // Inisialisasi modal Edit Staf
            const editModalEl = document.getElementById('edit-modal');
            if (editModalEl && typeof Modal !== 'undefined') {
                editModalInstance = new Modal(editModalEl);
            }

            // Inisialisasi modal Hapus
            const deleteModalEl = document.getElementById('delete-modal');
            if (deleteModalEl && typeof Modal !== 'undefined') {
                deleteModalInstance = new Modal(deleteModalEl);
            }

            // Cek apakah ada error validasi dari Laravel
            @if ($errors->any())
                const rawMessage = @json($errors->first()); // Ambil pesan error pertama
                const translated = {
                    "The nip has already been taken.": "NIP sudah digunakan.",
                    "The email has already been taken.": "Email sudah digunakan.",
                    "The password confirmation does not match.": "Konfirmasi password tidak cocok.",
                    "The password field must be at least 8 characters.": "Password minimal 8 karakter.",
                    "The nama field is required.": "Nama wajib diisi.",
                    "The peran field is required.": "Peran wajib diisi."
                };
                const finalMessage = translated[rawMessage] ?? rawMessage; // Gunakan terjemahan jika tersedia
                showNotification('error', finalMessage); // Tampilkan notifikasi error
            @endif

            // Cek apakah ada pesan sukses dari session
            @if (session('success_type') && session('success_message'))
                // Tampilkan notifikasi dengan tipe dan pesan sukses dari session
                showNotification("{{ session('success_type') }}", "{{ session('success_message') }}");
            @elseif (session('success'))
                const message = "{{ session('success') }}";
                let type = 'success_general';
                if (message.includes('ditambahkan')) type = 'success_add';
                else if (message.includes('diperbarui')) type = 'success_edit';
                else if (message.includes('dihapus')) type = 'success_delete';
                showNotification(type, message);
            @endif


            // --- FUNGSI-FUNGSI UTAMA ---

            // Fungsi untuk menampilkan notifikasi
            function showNotification(type, message) {
                if (!flowbitePopupModal) {
                    console.error("Modal Flowbite (popup) belum terinisialisasi.");
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
                } else if (type === 'success' || type === 'success_general') {
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
            window.confirmDelete = function (url) {
                if (!deleteModalInstance) {
                    console.error("Delete Modal Flowbite belum terinisialisasi.");
                    return;
                }
                const deleteForm = document.getElementById('delete-form');
                deleteForm.action = url;
                deleteModalInstance.show();
            };

            // Fungsi untuk menutup modal CRUD (Tambah)
            window.closeCrudModal = function () {
                if (crudModal) {
                    crudModal.hide();
                }
            }

            // Fungsi untuk menutup modal Edit
            window.closeEditModal = function () {
                if (editModalInstance) {
                    editModalInstance.hide();
                }
            }

            // Fungsi untuk menutup modal Delete
            window.closeDeleteModal = function () {
                if (deleteModalInstance) {
                    deleteModalInstance.hide();
                }
            }


            function setupPasswordToggle(toggleId, inputId) {
                const toggle = document.getElementById(toggleId);
                const input = document.getElementById(inputId);
                if (toggle && input) {
                    toggle.addEventListener('click', () => {
                        const isPassword = input.getAttribute('type') === 'password';
                        input.setAttribute('type', isPassword ? 'text' : 'password');
                        toggle.classList.toggle('fa-eye');
                        toggle.classList.toggle('fa-eye-slash');
                    });
                }
            }


            // Kode untuk Pencarian AJAX
            const searchInput = document.getElementById('search-staf');
            const tableBody = document.getElementById('staf-table-body');
            const mobileCardsContainer = document.querySelector('.block.md\\:hidden.space-y-4');
            const paginationLinksContainer = document.getElementById('pagination-links');

            if (searchInput && tableBody && mobileCardsContainer && paginationLinksContainer) {
                let searchTimeout;

                searchInput.addEventListener('input', function () {
                    clearTimeout(searchTimeout);
                    const query = this.value;

                    searchTimeout = setTimeout(() => {
                        const url = `{{ route('rekam-medis.staf.index') }}?q=${encodeURIComponent(query)}`;

                        fetch(url, {
                            method: 'GET',
                            headers: {
                                'Accept': 'text/html',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Network response was not ok: ' + response.statusText);
                                }
                                return response.text();
                            })
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');

                                // Perbarui tbody (desktop)
                                const newTableBody = doc.getElementById('staf-table-body');
                                if (tableBody && newTableBody) {
                                    tableBody.innerHTML = newTableBody.innerHTML;
                                }

                                // Perbarui card container (mobile)
                                const newMobileCards = doc.querySelector('.block.md\\:hidden.space-y-4');
                                if (mobileCardsContainer && newMobileCards) {
                                    mobileCardsContainer.innerHTML = newMobileCards.innerHTML;
                                }


                                // Perbarui pagination links
                                const newPagination = doc.getElementById('pagination-links');
                                if (paginationLinksContainer && newPagination) {
                                    paginationLinksContainer.innerHTML = newPagination.innerHTML;
                                }

                                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + `?q=${encodeURIComponent(query)}`;
                                window.history.pushState({ path: newUrl }, '', newUrl);

                            })
                            .catch(error => {
                                console.error('Error fetching staff search results:', error);
                                showNotification('error', 'Gagal mencari staf: ' + error.message);
                            });
                    }, 300);
                });
            }


            // Listener untuk Tombol Edit & Hapus (Menggunakan Event Delegation)
            const tableContainer = document.getElementById('table-container');
            if (tableContainer) {
                tableContainer.addEventListener('click', function (event) {
                    const editButton = event.target.closest('.edit-btn');
                    // Fungsi confirmDelete sudah dipanggil via onclick, jadi tidak perlu listener di sini

                    if (editButton) {
                        event.preventDefault();
                        const staffId = editButton.dataset.id;

                        fetch(`/rekam-medis/data-staf/${staffId}/edit-data`)
                            .then(response => {
                                if (!response.ok) throw new Error('Data staf tidak ditemukan.');
                                return response.json();
                            })
                            .then(data => {
                                document.getElementById('edit_nama').value = data.nama || '';
                                document.getElementById('edit_nip').value = data.nip || '';
                                document.getElementById('edit_no_whatsapp').value = data.no_whatsapp || '';
                                document.getElementById('edit_email').value = data.email || '';
                                document.getElementById('edit_peran').value = data.peran || '';
                                document.getElementById('edit_password').value = '';
                                document.getElementById('edit_password_confirmation').value = '';

                                const editForm = document.getElementById('edit-form');
                                editForm.action = `/rekam-medis/data-staf/${data.id}`;

                                if (editModalInstance) {
                                    editModalInstance.show();
                                }
                            })
                            .catch(error => {
                                console.error('Error fetching staff data for edit:', error);
                                showNotification('error', 'Error: ' + error.message);
                            });
                    }
                });
            }

            // --- VALIDASI CLIENT-SIDE SEDERHANA ---
            const addStafForm = document.getElementById('add-staf-form');
            if (addStafForm) {
                addStafForm.addEventListener('submit', function (e) {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('password_confirmation').value;
                    if (password !== confirmPassword) {
                        e.preventDefault();
                        showNotification('error', 'Password dan konfirmasi password tidak cocok!');
                    }
                });
            }

            const editForm = document.getElementById('edit-form');
            if (editForm) {
                editForm.addEventListener('submit', function (e) {
                    const password = document.getElementById('edit_password').value;
                    const confirmPassword = document.getElementById('edit_password_confirmation').value;
                    if (password && password !== confirmPassword) {
                        e.preventDefault();
                        showNotification('error', 'Password baru dan konfirmasi password baru tidak cocok!');
                    }
                });
            }

            // Setup semua tombol toggle password
            setupPasswordToggle('togglePassword', 'password');
            setupPasswordToggle('toggleKonfirmasiPassword', 'password_confirmation');
            setupPasswordToggle('toggleEditPassword', 'edit_password');
            setupPasswordToggle('toggleEditConfirmPassword', 'edit_password_confirmation');
        });
    </script>
@endsection