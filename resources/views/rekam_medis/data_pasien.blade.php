@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Pasien</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <form action="{{ url('/rekam_medis/data_pasien') }}" method="GET">
                    <div class="relative w-full">
                        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm"
                    style="min-width: 150px; white-space: nowrap;" data-modal-toggle="crud-modal">
                    + Tambah Pasien
                </button>

            </div>
            <div id="crud-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah Pasien</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="crud-modal">&times;</button>
                    </div>
                    <form action="{{ route('pasiens.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="nama_pasien" class="block text-sm font-medium text-gray-900">Nama Pasien</label>
                                <input type="text" id="nama_pasien" name="nama_pasien"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-900">NIK</label>
                                <input type="number" id="nik" name="nik" class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="no_whatsapp" class="block text-sm font-medium text-gray-900">No.
                                    WhatsApp</label>
                                <input type="number" id="no_whatsapp" name="no_whatsapp"
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
                            <button type="button" data-modal-toggle="crud-modal"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm">Tambah
                                Pasien</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Pasien (Contoh) -->
            <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Pasien</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            onclick="closeEditModal()">&times;</button>
                    </div>

                    <!-- Form dengan ID yang dapat diakses JavaScript -->
                    <form id="edit-form" action="{{ route('pasiens.update', 0) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Form fields dengan ID yang dapat diakses JavaScript -->
                        <div class="mb-4">
                            <label for="edit_nama" class="block text-gray-700">Nama Pasien</label>
                            <input type="text" id="edit_nama" name="nama"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_nik" class="block text-gray-700">NIK</label>
                            <input type="text" id="edit_nik" name="nik"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_no_whatsapp" class="block text-gray-700">No WhatsApp Pasien</label>
                            <input type="number" id="edit_no_whatsapp" name="no_whatsapp"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_tanggal_lahir" class="block text-gray-700">Tanggal Lahir Pasien</label>
                            <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <input type="hidden" id="pasien_id" name="pasien_id" value="">

                        <!-- Tombol Batal dan Simpan -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" onclick="closeEditModal()"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

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
                    <tbody>
                        @foreach ($pasiens as $pasien)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $pasien->nama }}</td>
                                <td class="px-6 py-4">{{ $pasien->nik }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') }}
                                </td>
                                <td class="px-6 py-4 text-green-600 font-semibold">{{ $pasien->no_whatsapp }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <button onclick="editPasien(
                                        '{{ $pasien->id }}', 
                                        '{{ $pasien->nama }}', 
                                        '{{ $pasien->nik }}', 
                                        '{{ $pasien->no_whatsapp }}', 
                                        '{{ $pasien->tanggal_lahir->format('Y-m-d') }}'
                                    )"
                                        class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-md text-xs font-semibold">
                                        Edit
                                    </button>

                                    <form action="{{ route('pasiens.destroy', $pasien->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center mt-6">
                <nav aria-label="Page navigation">
                    <ul class="inline-flex items-center -space-x-px text-sm">
                        {{-- Previous Page --}}
                        @if ($pasiens->onFirstPage())
                            <li>
                                <span
                                    class="px-3 py-2 ml-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                                    &lt;
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $pasiens->previousPageUrl() }}"
                                    class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                    &lt;
                                </a>
                            </li>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($pasiens->getUrlRange(1, $pasiens->lastPage()) as $page => $url)
                            <li>
                                <a href="{{ $url }}"
                                    class="px-3 py-2 leading-tight {{ $page == $pasiens->currentPage() ? 'text-blue-600 bg-blue-50 border border-gray-300' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        {{-- Next Page --}}
                        @if ($pasiens->hasMorePages())
                            <li>
                                <a href="{{ $pasiens->nextPageUrl() }}"
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                    &gt;
                                </a>
                            </li>
                        @else
                            <li>
                                <span
                                    class="px-3 py-2 leading-tight text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                                    &gt;
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
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
    </script>
    <script>
        function editPasien(id, nama, nik, no_whatsapp, tanggal_lahir) {
            // Set ID pasien pada hidden field
            document.getElementById('pasien_id').value = id;

            // Update form action URL
            const form = document.getElementById('edit-form');
            form.action = `/pasiens/${id}`;

            // Isi form dengan data
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_nik').value = nik;
            document.getElementById('edit_no_whatsapp').value = no_whatsapp;
            document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;

            // Tampilkan modal
            document.getElementById('edit-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        // Mencegah form dikirim dengan URL action yang kosong
        document.getElementById('edit-form').addEventListener('submit', function (event) {
            const formAction = this.getAttribute('action');
            if (!formAction || formAction === "") {
                event.preventDefault();
                alert('Error: Form action URL tidak valid');
                return false;
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-pasien');
            let timeoutId;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                const query = this.value.trim();

                // Set delay untuk menghindari terlalu banyak request
                timeoutId = setTimeout(() => {
                    // Update URL agar bisa di-bookmark
                    const url = new URL(window.location);
                    if (query) {
                        url.searchParams.set('search', query);
                    } else {
                        url.searchParams.delete('search');
                    }
                    window.history.pushState({}, '', url);

                    // Fetch data dari server dengan query
                    fetch(`/rekam_medis/data_pasien?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            // Update konten tabel dengan hasil pencarian
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Sesuaikan selector ini dengan struktur tabel Anda
                            const tableContainer = document.querySelector('.table-container');
                            const newTableContainer = doc.querySelector('.table-container');

                            if (tableContainer && newTableContainer) {
                                tableContainer.innerHTML = newTableContainer.innerHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }, 300);
            });
        });
    </script>
@endsection