@extends('layout.rekammedis')

@section('rekammedis')
    <div class="px-6 mt-1">
        <h1 class="font-bold text-2xl mb-2">Data Pasien</h1>
        {{-- Search Input dan Tombol Tambah Pasien --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="relative w-1/3 mb-4">
                    <input id="searchInput" type="search" placeholder="Cari Pasien"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="button" data-modal-toggle="modal-pasien"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium">
                    + Tambah Pasien
                </button>

            </div>
            {{-- MODAL TAMBAH PASIEN --}}
            <div id="modal-pasien"
                class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah Pasien</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="modal-pasien">&times;</button>
                    </div>
                    <form method="POST" action="{{ route('pasien.store') }}">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-900">Nama Pasien</label>
                                <input type="text" id="nama" name="nama" class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-900">NIK</label>
                                <input type="text" id="nik" name="nik" class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="no_whatsapp" class="block text-sm font-medium text-gray-900">No.
                                    WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-900">Tanggal
                                    Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" data-modal-toggle="modal-pasien"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm">Tambah
                                Pasien</button>
                        </div>
                    </form>
                </div>
            </div>
            {{-- MODAL EDIT PASIEN --}}
            <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Pasien</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="edit-modal">&times;</button>
                    </div>
                    <form id="form-pasien" class="space-y-4" method="POST" action="{{ url('/rekammedis/pasien/store') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="nama" class="block text-gray-700">Nama Pasien</label>
                            <input type="text" id="edit-nama" name="nama"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>
                        <div class="mb-4">
                            <label for="nik" class="block text-gray-700">NIK</label>
                            <input type="text" id="edit-nik" name="nik"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="no_wa" class="block text-gray-700">No WhatsApp Pasien</label>
                            <input type="text" id="edit-no_whatsapp" name="no_wa"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="tgl_lahir" class="block text-gray-700">Tanggal Lahir Pasien</label>
                            <input type="date" id="edit-tanggal_lahir" name="tgl_lahir"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" data-modal-hide="edit-modal"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit" id="submitBtn"
                                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm">Simpan</button>
                        </div>
                        </tr>
                    </form>

                </div>
            </div>

            {{-- MODAL HAPUS PASIEN --}}
            <div id="popup-modal" tabindex="-1"
                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <button type="button"
                            class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="popup-modal">
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
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to
                                delete this product?</h3>
                            <button id="confirmDeleteBtn" data-modal-hide="popup-modal" type="button"
                                class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            <button data-modal-hide="popup-modal" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- TABEL PASIEN --}}
            <div class="overflow-x-auto mt-6">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">NAMA</th>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">TANGGAL LAHIR</th>
                            <th class="px-6 py-3">NO. WHATSAPP</th>
                            <th class="px-6 py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                        @foreach($pasien as $item)
                            <tr class="bg-white border-b border-gray-200">
                                <th scope="row</button>" class="px-6 py-4 font-medium">
                                    {{ $item->nama }}
                                </th>
                                <td class="px-6 py-4">{{ $item->nik }}</td>
                                <td class="px-6 py-4">{{ $item->tanggal_lahir }}</td>
                                <td class="px-6 py-4">{{ $item->no_whatsapp }}</td>
                                <td class="px-6 py-4 flex gap-2">
                                    <button type="button" data-id="{{ $item->id }}" data-nama="{{ $item->nama }}"
                                        data-nik="{{ $item->nik }}" data-no_whatsapp="{{ $item->no_whatsapp }}"
                                        data-tanggal_lahir="{{ $item->tanggal_lahir }}" data-modal-toggle="edit-modal"
                                        data-modal-target="edit-modal"
                                        class="btn-edit bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                        Edit
                                    </button>



                                    <button data-modal-target="popup-modal" data-modal-toggle="popup-modal" type="button"
                                        data-id="{{ $item->id }}"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                        Hapus
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pagination" class="flex gap-2 mt-4"></div>
            </div>
        </div>
    </div>


    <script>
        // Buka/Tutup Modal
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', function () {
                const modalId = this.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });

        // Tutup modal jika klik di luar konten modal
        window.addEventListener('click', function (event) {
            document.querySelectorAll('.fixed.inset-0').forEach(modal => {
                if (!modal.classList.contains('hidden') && event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });

        // Handle form submit via AJAX (biar gak reload/pindah halaman)
        document.getElementById('form-pasien').addEventListener('submit', async function (e) {
            e.preventDefault(); // cegah reload halaman

            const formData = new FormData(this);

            try {
                const response = await fetch('/pasien', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (response.ok) {
                    // Kalau berhasil, tutup modal atau kasih feedback
                    alert('Data berhasil disimpan!');
                    this.reset(); // Reset isi form

                    // Tutup modal
                    const modal = this.closest('.fixed.inset-0');
                    modal.classList.add('hidden');
                } else {
                    const errorData = await response.json();
                    console.log(errorData.errors);
                    alert('Gagal menyimpan: ' + JSON.stringify(errorData.errors));
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan.');
            }
        });
        document.addEventListener('DOMContentLoaded', function () {
            const rows = Array.from(document.querySelectorAll('#pasien-table-body tr'));
            const rowsPerPage = 7;
            let currentPage = 1;

            function displayRows(page) {
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? '' : 'none';
                });
            }

            function setupPagination() {
                const pageCount = Math.ceil(rows.length / rowsPerPage);
                const paginationContainer = document.querySelector('#pagination-container');
                paginationContainer.innerHTML = '';

                for (let i = 1; i <= pageCount; i++) {
                    const btn = document.createElement('button');
                    btn.innerText = i;
                    btn.className = 'mx-1 px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm';
                    btn.addEventListener('click', () => {
                        currentPage = i;
                        displayRows(currentPage);
                    });
                    paginationContainer.appendChild(btn);
                }
            }

            displayRows(currentPage);
            setupPagination();
        });
    </script>
    <script>
        document.getElementById('searchInput').addEventListener('keyup', function () {
            let searchValue = this.value.toLowerCase();
            let rows = document.querySelectorAll('#tableBody tr');

            rows.forEach(function (row) {
                let name = row.querySelector('th').textContent.toLowerCase();
                if (name.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let selectedId = null;

            document.querySelectorAll('[data-modal-target="popup-modal"]').forEach(button => {
                button.addEventListener('click', function () {
                    selectedId = this.getAttribute('data-id');
                });
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                if (selectedId) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/rekammedis/pasien/delete/${selectedId}`;

                    const csrf = document.createElement('input');
                    csrf.type = 'hidden';
                    csrf.name = '_token';
                    csrf.value = '{{ csrf_token() }}';

                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';

                    form.appendChild(csrf);
                    form.appendChild(method);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButtons = document.querySelectorAll('.btn-edit');

            editButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Ambil data dari atribut data-*
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    const nik = this.getAttribute('data-nik');
                    const no_wa = this.getAttribute('data-no_whatsapp');
                    const tanggal_lahir = this.getAttribute('data-tanggal_lahir');

                    // Masukkan ke input di modal edit
                    document.getElementById('edit-nama').value = nama;
                    document.getElementById('edit-nik').value = nik;
                    document.getElementById('edit-no_whatsapp').value = no_wa;
                    document.getElementById('edit-tanggal_lahir').value = tanggal_lahir;

                    // Ubah action form (kalau kamu pakai route update pakai ID)
                    const form = document.getElementById('form-pasien');
                    form.action = `/rekammedis/pasien/update/${id}`;
                });
            });
        });
    </script>

@endsection