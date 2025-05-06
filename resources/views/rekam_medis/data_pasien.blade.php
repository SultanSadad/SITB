@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Pasien</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <form action="{{ url('/rekam-medis/data-pasien') }}" method="GET">
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
            <!-- Modal Tambah Pasien -->
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
                <!-- No. ERM field is not included in the form as it will be auto-generated -->
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

<!-- Modal Edit pasien -->



<div class="overflow-x-auto mt-6">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th class="px-6 py-3">NO.ERM</th>
                <th class="px-6 py-3">NAMA</th>
                <th class="px-6 py-3">NIK</th>
                <th class="px-6 py-3">TANGGAL LAHIR</th>
                <th class="px-6 py-3">NO. WHATSAPP</th>
                <th class="px-6 py-3">AKSI</th>
                <th class="px-6 py-3">VERIFIKASI</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pasiens as $pasien)
                <tr class="bg-white border-b">
                    <td class="px-6 py-4 font-medium text-gray-900">
                        {{ $pasien->no_erm ?? 'Belum ada' }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $pasien->nama }}</td>
                    <td class="px-6 py-4">{{ $pasien->nik }}</td>
                    <td class="px-6 py-4">
                        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y') : 'Belum diisi' }}
                    </td>
                    <td class="px-6 py-4 text-green-600 font-sm">{{ $pasien->no_whatsapp }}</td>
                    <td class="px-6 py-4 flex space-x-2">
                        <button onclick="editPasien(
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
                    <td class="px-6 py-4 text-center">
                        <input 
                            type="checkbox" 
                            class="verifikasi-checkbox"
                            data-id="{{ $pasien->id }}" 
                            {{ $pasien->verifikasi ? 'checked' : '' }}>
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
    <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-green-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                    <span id="modal-message">Data pasien telah berhasil diverifikasi</span>
                </h3>
            </div>
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
        // JavaScript function to populate the edit modal
function editPasien(id, nama, nik, no_whatsapp, tanggal_lahir, no_erm) {
    // Populate form fields
    document.getElementById('pasien_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nik').value = nik;
    document.getElementById('edit_no_whatsapp').value = no_whatsapp;
    document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
    document.getElementById('edit_no_erm').value = no_erm;
    
    // Update form action URL
    document.getElementById('edit-form').action = `/pasiens/${id}`;
    
    // Show the modal
    document.getElementById('edit-modal').classList.remove('hidden');
}

// Function to close the edit modal
function closeEditModal() {
    document.getElementById('edit-modal').classList.add('hidden');
}

// Add event listeners to the modal toggle buttons
document.addEventListener('DOMContentLoaded', function() {
    // For add modal
    const modalToggles = document.querySelectorAll('[data-modal-toggle="crud-modal"]');
    modalToggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const modal = document.getElementById('crud-modal');
            modal.classList.toggle('hidden');
        });
    });
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
    <script>
    function toggleVerifikasi(pasienId, isChecked) {
        fetch(`/pasiens/${pasienId}/verifikasi`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                verifikasi: isChecked
            })
        }).then(response => {
            if (!response.ok) {
                alert('Gagal memperbarui status verifikasi.');
            }
        });
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.3/dist/flowbite.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi modal
    const modal = new Modal(document.getElementById('popup-modal'));
    
    // Ketika checkbox verifikasi diubah
    $('.verifikasi-checkbox').change(function() {
        const id = $(this).data('id');
        const isChecked = $(this).prop('checked');
        const checkbox = $(this);
        
        $.ajax({
            url: `/pasien/${id}/verifikasi`,
            type: 'POST',
            data: {
                verifikasi: isChecked ? 1 : 0,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Set pesan di modal
                    if (isChecked) {
                        $('#modal-message').text('Data pasien telah berhasil diverifikasi');
                    } else {
                        $('#modal-message').text('Verifikasi data pasien telah dibatalkan');
                    }
                    
                    // Tampilkan modal
                    modal.show();
                } else {
                    console.error('Gagal update verifikasi');
                    alert('Gagal memperbarui status verifikasi');
                    // Kembalikan status checkbox karena update gagal
                    checkbox.prop('checked', !isChecked);
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                alert('Terjadi kesalahan saat update verifikasi');
                // Kembalikan status checkbox karena update gagal
                checkbox.prop('checked', !isChecked);
            }
        });
    });
    
    // Handle tombol close modal
    $('[data-modal-hide="popup-modal"]').click(function() {
        modal.hide();
    });
});
// Inisialisasi modal dengan opsi closable false
const modal = new Modal(document.getElementById('popup-modal'), {
    closable: false // Matikan kemampuan untuk ditutup dengan ESC atau klik luar
});

// Setelah berhasil update
if (response.success) {
    // Set pesan sesuai tindakan
    if (isChecked) {
        $('#modal-message').text('Data pasien telah berhasil diverifikasi');
    } else {
        $('#modal-message').text('Verifikasi data pasien telah dibatalkan');
    }
    
    // Tampilkan modal
    modal.show();
    
    // Secara otomatis sembunyikan modal setelah 1.5 detik
    setTimeout(function() {
        modal.hide();
    }, 1500);
}
</script>
</script>

@endsection