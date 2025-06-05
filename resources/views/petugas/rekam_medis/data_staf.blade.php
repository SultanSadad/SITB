@extends('layout.rekam_medis')
<title>Data Akun</title>
@section('rekam_medis')
    {{-- Ini adalah modal notifikasi universal yang akan digunakan oleh JS --}}
    {{-- Pastikan @include('alert.modal') Anda berisi div#popup-modal yang sudah Flowbite-ready --}}

    <div class="px-3 sm:px-6 mt-4">
        <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Akun Staf</h1>
        <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
                <form action="{{ url('/rekam-medis/data-staf') }}" method="GET" class="w-full sm:w-auto">
                    <div class="relative w-full sm:w-60">
                        <input type="text" id="search-staf" name="search" placeholder="Cari Akun"
                            class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            value="{{ request('search') }}">
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
                        <form id="add-staf-form" action="{{ route('rekam-medis.stafs.store') }}" method="POST"
                            class="p-4 md:p-5">
                            @csrf
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="nama"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nama" id="nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="" required pattern="[A-Za-z\s]+"
                                        title="Nama hanya boleh mengandung huruf dan spasi">
                                </div>
                                <div class="col-span-2">
                                    <label for="nip"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nip" id="nip"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="" required pattern="\d+"
                                        title="NIP hanya boleh mengandung angka">
                                </div>
                                <div class="col-span-2">
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="email" id="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="" required>
                                </div>
                                <div class="col-span-2">
                                    <label for="no_whatsapp"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                                        WhatsApp<span class="text-red-600">*</span></label>
                                    <input type="text" name="no_whatsapp" id="no_whatsapp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="" required pattern="\d+"
                                        title="Nomor WhatsApp hanya boleh mengandung angka">
                                </div>
                                <div class="col-span-2">
                                    <label for="peran"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role<span
                                            class="text-red-600">*</span></label>
                                    <select name="peran" id="peran"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
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
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 pr-10"
                                        required minlength="6">
                                    <i id="togglePassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                                <div class="col-span-2 relative">
                                    <label for="password_confirmation"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi
                                        Password<span class="text-red-600">*</span></label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 pr-10"
                                        required>
                                    <i id="toggleKonfirmasiPassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                {{-- Tombol Batal di kiri --}}
                                <button type="button" data-modal-hide="crud-modal"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                                    Batal
                                </button>

                                {{-- Tombol Tambah di kanan --}}
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
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

                        </div>
                        <form id="edit-form" method="POST" class="p-4 md:p-5">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-4 mb-4 grid-cols-2">
                                <div class="col-span-2">
                                    <label for="edit_nama"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nama" id="edit_nama"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required pattern="[A-Za-z\s]+" title="Nama hanya boleh mengandung huruf dan spasi">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_nip"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="nip" id="edit_nip"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required pattern="\d+" title="NIP hanya boleh mengandung angka">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_email"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username<span
                                            class="text-red-600">*</span></label>
                                    <input type="text" name="email" id="edit_email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required>
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_no_whatsapp"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.
                                        WhatsApp<span class="text-red-600">*</span></label>
                                    <input type="text" name="no_whatsapp" id="edit_no_whatsapp"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required pattern="\d+" title="Nomor WhatsApp hanya boleh mengandung angka">
                                </div>
                                <div class="col-span-2">
                                    <label for="edit_peran"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role<span
                                            class="text-red-600">*</span></label>
                                    <select name="peran" id="edit_peran"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        required>
                                        <option value="laboran">Laboran</option>
                                        <option value="rekam_medis">Rekam Medis</option>
                                    </select>
                                </div>
                                <div class="col-span-2 relative">
                                    <label for="edit_password"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password Baru
                                        (Opsional)</label>
                                    <input type="password" name="password" id="edit_password"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 pr-10">
                                    <i id="toggleEditPassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                                <div class="col-span-2 relative">
                                    <label for="edit_password_confirmation"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Konfirmasi
                                        Password Baru</label>
                                    <input type="password" name="password_confirmation" id="edit_password_confirmation"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 pr-10">
                                    <i id="toggleEditConfirmPassword"
                                        class="fa-solid fa-eye absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer text-gray-600 mt-2"></i>
                                </div>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-hide="edit-modal"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="delete-modal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4 bg-black/30 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-4 md:p-5 text-center">
                <h3 class="mb-5 text-lg text-gray-900 dark:text-white">Yakin ingin menghapus data akun ini?</h3>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <button type="button" data-modal-hide="delete-modal"
                        class="bg-gray-600 hover:bg-gray-700 text-white px-5 py-2.5 rounded-lg text-sm w-full sm:w-auto">
                        Batal
                    </button>
                    <form id="delete-form" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center w-full sm:w-auto">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


                <div id="table-container" class="mt-6">
                    <div class="block md:hidden space-y-4">
                        @forelse($stafs as $staf)
                            <div class="bg-white rounded-lg p-4 border shadow-sm">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <h3 class="font-bold text-lg text-gray-900">{{ $staf->nama }}</h3>
                                        <p class="text-sm text-gray-600">NIP: {{ $staf->nip }}</p>
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <button data-id="{{ $staf->id }}"
                                            class="edit-btn bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                                            Edit
                                        </button>
                                        <button type="button"
                                            onclick="confirmDelete('{{ route('rekam-medis.stafs.destroy', $staf->id) }}')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                                            Hapus
                                        </button>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-2 text-sm">
                                    <p>
                                        <span class="font-semibold text-gray-600">Username:</span>
                                        <span class="ml-2 text-gray-800">{{ $staf->email }}</span>
                                    </p>
                                    <p>
                                        <span class="font-semibold text-gray-600">WhatsApp:</span>
                                        @if (!empty($staf->no_whatsapp))
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $staf->no_whatsapp) }}"
                                                target="_blank" class="ml-2 text-green-600 hover:underline">
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
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-4">Tidak ada data staf yang ditemukan.</p>
                        @endforelse
                    </div>

                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700 border-collapse"> {{-- Added min-w-full and
                            border-collapse --}}
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
                            <tbody>
                                @forelse($stafs as $staf)
                                    <tr class="bg-white border-b">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $staf->nama }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $staf->nip }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $staf->email }}</td>
                                        <td class="px-6 py-4 text-green-600 font-sm whitespace-nowrap">
                                            @if (!empty($staf->no_whatsapp))
                                                <a href="https://wa.me/{{ preg_replace('/^0/', '62', $staf->no_whatsapp) }}"
                                                    target="_blank" class="hover:underline">
                                                    {{ $staf->no_whatsapp }}
                                                </a>
                                            @else
                                                <span class="text-red-500">Belum diisi</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($staf->peran === 'laboran')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-orange-800 bg-orange-200">
                                                    Laboran
                                                </span>
                                            @elseif ($staf->peran === 'rekam_medis')
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-purple-800 bg-purple-200">
                                                    Rekam Medis
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white bg-gray-600">
                                                    {{ ucfirst($staf->peran) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 flex space-x-2 whitespace-nowrap">
                                            <button data-id="{{ $staf->id }}"
                                                class="edit-btn bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                                                Edit
                                            </button>
                                            <button type="button"
                                                onclick="confirmDelete('{{ route('rekam-medis.stafs.destroy', $staf->id) }}')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition duration-200">
                                                Hapus
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data staf yang
                                            ditemukan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-center items-center flex-col md:flex-row mt-6 gap-3">
                    {{-- Info Data --}}


                    {{-- Tombol Pagination --}}
                    <div class="join text-sm">
                        {{-- Tombol Sebelumnya --}}
                        @if ($stafs->onFirstPage())
                            <button
                                class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $stafs->previousPageUrl() . '&search=' . request('search') }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&laquo;</a>
                        @endif

                        {{-- Halaman --}}
                        @for ($page = 1; $page <= $stafs->lastPage(); $page++)
                            @if ($page == 1 || $page == $stafs->lastPage() || ($page >= $stafs->currentPage() - 1 && $page <= $stafs->currentPage() + 1))
                                <a href="{{ $stafs->url($page) . '&search=' . request('search') }}"
                                    class="join-item btn btn-sm border {{ $page == $stafs->currentPage() ? 'bg-blue-100 text-blue-600 border-blue-300' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                                    {{ $page }}
                                </a>
                            @elseif ($page == $stafs->currentPage() - 2 || $page == $stafs->currentPage() + 2)
                                <button class="join-item btn btn-sm btn-disabled border border-gray-200">...</button>
                            @endif
                        @endfor

                        {{-- Tombol Berikutnya --}}
                        @if ($stafs->hasMorePages())
                            <a href="{{ $stafs->nextPageUrl() . '&search=' . request('search') }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
                        @else
                            <button
                                class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/flowbite@1.6.3/dist/flowbite.min.js"></script>
   
        <script>
            let editModal = null;
            let deleteModal = null;

            let flowbitePopupModal; // Global instance for general notifications

            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Flowbite Modal for general notifications
                const popupModalElement = document.getElementById('popup-modal');
                if (popupModalElement && window.Modal) {
                    flowbitePopupModal = new window.Modal(popupModalElement, {
                        backdrop: 'static',
                        closable: true
                    });
                } else {
                    console.error("Flowbite Modal atau elemen 'popup-modal' tidak ditemukan/dimuat.");
                }
                // Tombol Cancel Edit
                document.querySelectorAll('[data-modal-hide="edit-modal"]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (editModal) editModal.hide();
                    });
                });

                // Tombol Cancel Delete
                document.querySelectorAll('[data-modal-hide="delete-modal"]').forEach(btn => {
                    btn.addEventListener('click', () => {
                        if (deleteModal) deleteModal.hide();
                    });
                });

                
                function showNotification(type, message) {
                    if (!flowbitePopupModal) {
                        alert(`${type}: ${message}`); 
                        return;
                    }

                    const iconElement = document.getElementById('modal-icon');
                    const messageElement = document.getElementById('modal-message');
                    const checkmarkPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                    const xmarkPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />`;
                    const infoPath = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`;

                    iconElement.className = 'mx-auto mb-4 w-12 h-12'; // Reset classes
                    iconElement.innerHTML = ''; // Clear previous SVG path
                    messageElement.innerText = message;

                    if (type.startsWith('success')) {
                        iconElement.innerHTML = checkmarkPath;
                        iconElement.classList.remove('text-green-500', 'text-blue-500', 'text-red-500'); // Reset colors
                        if (message.toLowerCase().includes('diperbarui')) {
                            iconElement.classList.add('text-blue-500');
                        } else if (message.toLowerCase().includes('dihapus')) {
                            iconElement.classList.add('text-red-500');
                        } else { // Default success
                            iconElement.classList.add('text-green-500');
                        }
                    } else if (type === 'error') {
                        iconElement.innerHTML = xmarkPath;
                        iconElement.classList.remove('text-green-500', 'text-blue-500', 'text-red-500');
                        iconElement.classList.add('text-red-500');
                    } else { // info or default
                        iconElement.innerHTML = infoPath;
                        iconElement.classList.remove('text-green-500', 'text-blue-500', 'text-red-500');
                        iconElement.classList.add('text-blue-500');
                    }

                    // Hide other modals if they are open (e.g., Add/Edit modal)
                    document.getElementById('crud-modal')?.classList.add('hidden');
                    document.getElementById('edit-modal')?.classList.add('hidden');
                    document.getElementById('delete-modal')?.classList.add('hidden'); // Ensure delete modal also hides

                    flowbitePopupModal.show();
                    setTimeout(() => flowbitePopupModal.hide(), 2500); // Auto hide after 2.5 seconds
                }

                // --- Handle Laravel Flash Messages & Validation Errors ---
                @if ($errors->any())
                    const rawMessage = @json($errors->first());
                    const translated = {
                        "The email has already been taken.": "Username sudah digunakan.",
                        "The nip has already been taken.": "NIP sudah digunakan.",
                        "The no whatsapp has already been taken.": "Nomor WhatsApp sudah digunakan.",
                        "The password confirmation does not match.": "Password dan konfirmasi password tidak cocok.",
                        "The password field must be at least 6 characters.": "Password minimal 6 karakter.",
                        "The nama field is required.": "Nama wajib diisi.",
                        "The nip field is required.": "NIP wajib diisi.",
                        "The no whatsapp field is required.": "Nomor WhatsApp wajib diisi.",
                        "The email field is required.": "Username wajib diisi.",
                        "The peran field is required.": "Role wajib diisi.",
                        // Add more translations as needed
                    };
                    const finalMessage = translated[rawMessage] ?? rawMessage;

                   
                    setTimeout(() => {
                        showNotification('error', finalMessage);
                        // If validation failed, re-open the appropriate modal (add or edit)
                        @if(old('is_edit_form')) // Assuming you set a hidden input 'is_edit_form' in edit modal
                            document.getElementById('edit-modal').classList.remove('hidden');
                        @else
                            document.getElementById('crud-modal').classList.remove('hidden');
                        @endif
                                }, 100);
                @endif

                @if (session('success') || session('error'))
                    setTimeout(() => {
                        showNotification(
                            "{{ session('success') ? 'success' : 'error' }}",
                            "{{ session('success') ?? session('error') }}"
                        );
                    }, 100);
                @endif


                // --- Password Toggle Functionality ---
                function setupPasswordToggle(toggleId, inputId) {
                    const toggle = document.getElementById(toggleId);
                    const input = document.getElementById(inputId);
                    if (toggle && input) {
                        toggle.addEventListener('click', () => {
                            const isPassword = input.getAttribute('type') === 'password';
                            input.setAttribute('type', isPassword ? 'text' : 'password');
                            toggle.classList.toggle('fa-eye');
                            toggle.classList.toggle('fa-eye-slash');
                            toggle.classList.toggle('text-gray-600'); // Optional: change color on toggle
                            toggle.classList.toggle('text-blue-600'); // Optional: change color on toggle
                        });
                    }
                }
                setupPasswordToggle('togglePassword', 'password');
                setupPasswordToggle('toggleKonfirmasiPassword', 'password_confirmation');
                setupPasswordToggle('toggleEditPassword', 'edit_password');
                setupPasswordToggle('toggleEditConfirmPassword', 'edit_password_confirmation');

                
                window.confirmDelete = function (url) {
                    const deleteForm = document.getElementById('delete-form');
                    deleteForm.action = url;
                    const deleteModalElement = document.getElementById('delete-modal');
                    deleteModal = new Modal(deleteModalElement); // SIMPAN ke variabel global
                    deleteModal.show();
                };


               
                document.querySelector('#table-container').addEventListener('click', function (event) {
                    const editButton = event.target.closest('.edit-btn');
                    if (editButton) {
                        event.preventDefault();
                        const staffId = editButton.dataset.id; // Get data-id

                        fetch(`/rekam-medis/data-staf/${staffId}/edit-data`)

                            .then(response => {
                                if (!response.ok) {
                                    if (response.status === 404) {
                                        throw new Error('Data staf tidak ditemukan.');
                                    }
                                    throw new Error('Gagal memuat data staf.');
                                }
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
                                editForm.action = `/rekam-medis/data-staf/${staffId}`;

                                const editModalElement = document.getElementById('edit-modal');
                                editModal = new Modal(editModalElement); 
                                editModal.show();
                            })
                            .catch(error => {
                                console.error('Error fetching staff data for edit:', error);
                                showNotification('error', error.message || 'Terjadi kesalahan saat memuat data staf.');
                            });
                    }
                });

                // --- Form Validations ---
                const addStafForm = document.getElementById('add-staf-form');
                if (addStafForm) {
                    addStafForm.addEventListener('submit', function (e) {
                        const password = document.getElementById('password').value;
                        const confirmPassword = document.getElementById('password_confirmation').value;
                        if (password !== confirmPassword) {
                            e.preventDefault();
                            showNotification('error', 'Password dan konfirmasi password tidak cocok!');
                            // Re-open modal if validation fails
                            const crudModalElement = document.getElementById('crud-modal');
                            const crudModal = new Modal(crudModalElement);
                            crudModal.show();
                        }
                    });
                }

                const editForm = document.getElementById('edit-form');
                if (editForm) {
                    editForm.addEventListener('submit', function (e) {
                        const password = document.getElementById('edit_password').value;
                        const confirmPassword = document.getElementById('edit_password_confirmation').value;
                        if (password && password !== confirmPassword) { // Only check if new password is provided
                            e.preventDefault();
                            showNotification('error', 'Password baru dan konfirmasi password baru tidak cocok!');
                            // Re-open modal if validation fails
                            const editModalElement = document.getElementById('edit-modal');
                            const editModal = new Modal(editModalElement);
                            editModal.show();
                        }
                    });
                }

                // --- AJAX Live Search & Pagination/Sorting Update ---
                const searchInput = document.getElementById('search-staf');
                const mobileCardsContainer = document.querySelector('.block.md:hidden.space-y-4');
                const desktopTableContainer = document.querySelector('.hidden.md:block.overflow-x-auto');
                const paginationNav = document.querySelector('nav[aria-label="Page navigation"]');

                if (searchInput && mobileCardsContainer && desktopTableContainer && paginationNav) {
                    let searchTimeoutId;

                    searchInput.addEventListener('input', function () {
                        clearTimeout(searchTimeoutId);
                        const query = this.value.trim();

                        searchTimeoutId = setTimeout(() => {
                            const url = new URL(window.location.origin + window.location.pathname);
                            if (query) url.searchParams.set('search', query);
                            // No sorting params here since we don't have them in this view
                            url.searchParams.delete('page'); // Reset to first page on new search

                            performAjaxUpdate(url.toString());
                        }, 300);
                    });
                    // Event delegation for pagination links (since they are replaced by AJAX)
                    paginationNav.addEventListener('click', function (event) {
                        const link = event.target.closest('a');
                        if (link && link.href) {
                            event.preventDefault(); // Prevent full page reload
                            performAjaxUpdate(link.href);
                        }
                    });

                    function performAjaxUpdate(url) {
                        fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'text/html'
                            }
                        })
                            .then(response => {
                                if (!response.ok) throw new Error('Network response was not ok');
                                return response.text();
                            })
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');

                                // Update Mobile Cards View
                                const newMobileCardsContent = doc.querySelector('.block.md:hidden.space-y-4');
                                if (newMobileCardsContent) {
                                    mobileCardsContainer.innerHTML = newMobileCardsContent.innerHTML;
                                } else {
                                    mobileCardsContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Tidak ada data staf yang ditemukan.</p>';
                                }

                                // Update Desktop Table View
                                const newDesktopTableContent = doc.querySelector('.hidden.md:block.overflow-x-auto');
                                if (newDesktopTableContent) {
                                    desktopTableContainer.innerHTML = newDesktopTableContent.innerHTML;
                                } else {
                                    desktopTableContainer.innerHTML = '<p class="text-gray-500 text-center py-4">Tidak ada data staf yang ditemukan.</p>';
                                }

                                // Update Pagination
                                const newPaginationNav = doc.querySelector('nav[aria-label="Page navigation"]');
                                if (newPaginationNav) {
                                    paginationNav.innerHTML = newPaginationNav.innerHTML;
                                } else {
                                    paginationNav.innerHTML = ''; // Clear pagination if no pages
                                }

                                // Update browser URL
                                window.history.pushState({ path: url }, '', url);
                            })
                            .catch(error => {
                                console.error('AJAX update error:', error);
                                showNotification('error', 'Gagal memuat data. Silakan coba lagi.');
                            });
                    }
                }
            });
        </script>
@endsection