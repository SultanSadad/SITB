{{-- Nama File   = detail_hasil_uji.blade.php] --}}
{{-- Deskripsi   = Update modal data hasil uji --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal     = 10 April 2025 --}}

{{-- Nama File   = [detail_hasil_uji.blade.php] --}}
{{-- Deskripsi   = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal     = 16 April 2025 --}}

@extends('layout.laboran')
<title>Detail Hasil Uji Laboratorium</title>
@section('laboran')
    <div class="relative px-6 mt-1">
        <h1 class="font-bold text-2xl mb-4">Detail Hasil Uji Laboratorium</h1>
        <div class="mb-4 md:mb-6">
            <span class="text-sm text-gray-500">Pasien:</span>
            <span class="text-lg md:text-xl font-bold text-gray-800 truncate">{{ $pasien->nama }}</span>
        </div>
        <div class="bg-white shadow-xl rounded-sm p-6">

            <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 sm:gap-0">
                <a href="{{ route('laboran.hasil-uji.index') }}"
                    class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition w-full sm:w-auto text-center">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>

                <button onclick="toggleModal(true)"
                    class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">
                    + Tambah Hasil Uji
                </button>
            </div>

            {{-- Modal Notifikasi (Satu definisi yang universal) --}}
            <div id="popup-modal" tabindex="-1"
                class="hidden fixed top-0 left-0 right-0 z-50  items-center justify-center w-full h-full bg-black bg-opacity-50 p-4">
                <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md text-center">
                    <svg id="modal-icon" class="mx-auto mb-4 w-12 h-12" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        {{-- Path akan diatur via JS sesuai tipe notifikasi --}}
                    </svg>
                    <h3 class="text-lg font-medium text-gray-800" id="modal-message">Pesan Notifikasi</h3>
                </div>
            </div>

            <div id="delete-modal" tabindex="-1"
                class="hidden fixed inset-0 z-50  items-center justify-center bg-black bg-opacity-50 p-4">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-6">
                    <div class="text-center">
                        <h3 class="mb-4 text-lg font-normal text-gray-700">Yakin ingin menghapus data ini?</h3>
                        <form id="delete-form" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-center gap-4 mt-6">
                                <button type="button" onclick="closeDeleteModal()"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">Hapus</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table View (Desktop & Tablet) --}}
            <div class="hidden md:block overflow-x-auto rounded-sm border border-gray-200">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-100">

                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">
                                <div class="flex items-center gap-1 relative">
                                    Tanggal Uji
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-4 font-semibold">
                                <div class="flex items-center gap-1 relative">
                                    Tanggal Upload
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-4 font-semibold">File</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($hasilUjiList as $hasil)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $hasil->tanggal_uji }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $hasil->tanggal_upload }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex gap-2">
                                        <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank"
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded-md text-xs font-medium inline-flex items-center justify-center transition-all duration-200">
                                            <i class="fas fa-eye mr-1 text-xs"></i>
                                            Lihat
                                        </a>
                                        <a href="{{ asset('storage/' . $hasil->file) }}" download
                                            class="bg-gray-600 hover:bg-gray-700 text-white px-2.5 py-1 rounded-md text-xs font-medium inline-flex items-center justify-center transition-all duration-200">
                                            <i class="fas fa-download mr-1 text-xs"></i>
                                            Unduh
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">

                                        <button type="button"
                                            onclick="confirmDelete('{{ route('laboran.hasil-uji.destroy', $hasil->id) }}')"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition">
                                            </i> Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Belum ada hasil uji.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>
            @if ($hasilUjiList->hasPages())
                <div class="flex justify-center mt-6">
                    <div class="join text-sm">
                        {{-- Tombol Sebelumnya --}}
                        @if ($hasilUjiList->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $hasilUjiList->previousPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&laquo;</a>
                        @endif

                        {{-- Nomor Halaman --}}
                        @php
                            $current = $hasilUjiList->currentPage();
                            $last = $hasilUjiList->lastPage();
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
                            <a href="{{ $hasilUjiList->url(1) }}"
                                class="join-item btn btn-sm border border-gray-300 text-gray-600">1</a>
                            @if ($start > 2)
                                <button class="join-item btn btn-sm btn-disabled border border-gray-300">...</button>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $hasilUjiList->url($i) }}"
                                class="join-item btn btn-sm border {{ $i == $current ? 'bg-blue-100 text-blue-600 border-blue-300' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <button class="join-item btn btn-sm btn-disabled border border-gray-300">...</button>
                            @endif
                            <a href="{{ $hasilUjiList->url($last) }}"
                                class="join-item btn btn-sm border border-gray-300 text-gray-600">{{ $last }}</a>
                        @endif

                        {{-- Next Button --}}
                        @if ($hasilUjiList->hasMorePages())
                            <a href="{{ $hasilUjiList->nextPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>
            @endif

            {{-- Card View (Mobile) --}}
            <div class="md:hidden space-y-4 mt-6">
                @forelse ($hasilUjiList as $hasil)
                    <div class="bg-white border border-gray-200 rounded-xl shadow p-4">
                        <p class="text-xs text-gray-500 font-semibold">Tanggal Uji</p>
                        <p class="text-base font-bold mb-2 text-gray-900">{{ $hasil->tanggal_uji }}</p>

                        <p class="text-xs text-gray-500 font-semibold">Tanggal Upload</p>
                        <p class="text-base font-bold mb-4 text-gray-900">{{ $hasil->tanggal_upload }}</p>

                        <div class="flex flex-col sm:flex-row sm:justify-between gap-2">
                            <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-semibold text-center transition w-full">
                                <i class="fa-solid fa-download mr-1"></i> Cetak Hasil
                            </a>
                            <button type="button"
                                onclick="confirmDelete('{{ route('laboran.hasil-uji.destroy', $hasil->id) }}')"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition w-full">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">Belum ada hasil uji.</p>
                @endforelse

            </div>

        </div>
    </div>
    {{-- Modal Upload --}}
    <div id="modalUpload"
        class="hidden fixed top-0 right-0 left-0 z-50  justify-center items-center w-full md:inset-0 h-full bg-black bg-opacity-50 p-4">
        <div class="relative p-4 w-full max-w-md"> {{-- Mengubah p-0 menjadi p-4 untuk konsistensi --}}
            <div class="relative bg-white rounded-lg shadow-md overflow-hidden">
                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="text-xl font-medium text-gray-900">
                        Upload Hasil Uji
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                        onclick="toggleModal(false)">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <form id="uploadForm" action="{{ route('laboran.hasil-uji.store', $pasien->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-5">
                    @csrf

                    <div class="mb-5">
                        <label for="tanggal_uji" class="block mb-2 text-base font-medium text-gray-900">Tanggal Uji</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input type="date" id="tanggal_uji" name="tanggal_uji"
                                class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full ps-10 p-3"
                                required>
                        </div>
                    </div>

                    <input type="hidden" id="tanggal_upload" name="tanggal_upload">

                    <div class="mb-5">
                        <label class="block mb-2 text-base font-medium text-gray-900" for="file_upload">File Hasil
                            Uji</label>

                        <div id="file-input-initial" class="flex items-center">
                            <label for="file_upload"
                                class="flex cursor-pointer items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-l-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Pilih File
                            </label>
                            <div
                                class="flex-grow bg-gray-50 border border-l-0 border-gray-300 rounded-r-lg py-2 px-3 text-sm text-gray-500 truncate">
                                Tidak ada file yang dipilih
                            </div>
                        </div>

                        <div id="file-input-selected"
                            class="hidden items-center justify-between bg-gray-50 border border-gray-300 rounded-lg py-2 px-3">
                            <div class="text-sm text-gray-900 truncate" id="selected-filename">filename.pdf</div>
                            <button type="button" id="change-file-btn"
                                class="ml-2 text-sm text-blue-600 hover:text-blue-800 font-medium flex-shrink-0">
                                Ganti File
                            </button>
                        </div>

                        <input id="file_upload" type="file" style="display: none;" name="file" accept=".pdf" required>
                        <div class="mt-2 text-sm text-gray-500">Format: PDF (Maksimal 10MB)</div>
                    </div>

                    <div class="flex justify-end space-x-2 mt-8">
                        <button type="button" onclick="toggleModal(false)"
                            class="px-5 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium text-gray-800">Batal</button>
                        <button type="submit"
                            class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.3/dist/flowbite.min.js"></script>
    <script nonce="{{ $nonce }}">
        // Variabel global untuk menyimpan instance modal
        let flowbitePopupModal;
        let flowbiteDeleteModal;
        let flowbiteCrudModal; // Jika ada modal crud di halaman ini
        let flowbiteModalUploadInstance; // Deklarasikan di sini agar global dan terinisialisasi sekali

        document.addEventListener('DOMContentLoaded', function () {
            // =========================
            // Inisialisasi Modal Flowbite (HANYA SEKALI per modal)
            // =========================
            const popupModalElement = document.getElementById('popup-modal');
            if (popupModalElement && typeof Modal !== 'undefined') {
                flowbitePopupModal = new Modal(popupModalElement, {
                    backdrop: 'static',
                    backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                    closable: true
                });
            } else {
                console.error("Flowbite Modal Notifikasi tidak ditemukan.");
            }

            const deleteModalElement = document.getElementById('delete-modal');
            if (deleteModalElement && typeof Modal !== 'undefined') {
                flowbiteDeleteModal = new Modal(deleteModalElement);
            } else {
                console.error("Flowbite Modal Konfirmasi Hapus tidak ditemukan.");
            }

            const crudModalElement = document.getElementById('crud-modal'); // Jika ada crud modal di halaman ini
            if (crudModalElement && typeof Modal !== 'undefined') {
                 // Inisialisasi jika diperlukan, atau hapus jika tidak ada di halaman ini
                 // flowbiteCrudModal = new Modal(crudModalElement);
            }

            const modalUploadElement = document.getElementById('modalUpload');
            if (modalUploadElement && typeof Modal !== 'undefined') {
                flowbiteModalUploadInstance = new Modal(modalUploadElement);
            } else {
                console.error("Flowbite Modal Upload tidak ditemukan.");
            }


            // =========================
            // Tampilkan Notifikasi Flash dari Laravel (ini bagian yang memanggil pop-up)
            // =========================
            @if ($errors->any())
                const rawMessage = @json($errors->first());
                const translated = {
                    "The tanggal uji field is required.": "Tanggal uji wajib diisi.",
                    "The tanggal upload field is required.": "Tanggal upload wajib diisi.",
                    "The file field is required.": "File hasil uji wajib diupload.",
                    "The tanggal upload must be a date before or equal to today.": "Tanggal upload tidak boleh melebihi hari ini.",
                    "The file must be a file of type: pdf.": "Format file tidak didukung. Gunakan PDF.",
                    "The file must not be greater than 10240 kilobytes.": "Ukuran file terlalu besar (maks 10MB)."
                };
                const finalMessage = translated[rawMessage] ?? rawMessage;
                showNotification('error', finalMessage);
            @endif

            @if (session('success_type') && session('success_message'))
                showNotification("{{ session('success_type') }}", "{{ session('success_message') }}");
            @elseif (session('success'))
                const message = "{{ session('success') }}";
                let type = 'success_general';
                if (message.includes('ditambahkan')) type = 'success_add';
                else if (message.includes('diperbarui')) type = 'success_edit';
                else if (message.includes('dihapus')) type = 'success_delete';
                showNotification(type, message);
            @elseif (session('error'))
                showNotification('error', "{{ session('error') }}");
            @endif


            // =========================
            // Event Listener untuk Form Upload (digabungkan ke dalam DOMContentLoaded utama)
            // =========================
            const fileInput = document.getElementById('file_upload');
            const uploadForm = document.getElementById('uploadForm');
            const initialFileInputState = document.getElementById('file-input-initial');
            const selectedFileInputState = document.getElementById('file-input-selected');
            const selectedFilenameDisplay = document.getElementById('selected-filename');
            const changeFileButton = document.getElementById('change-file-btn');

            if (fileInput) { // Pastikan elemen ada
                fileInput.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        selectedFilenameDisplay.textContent = file.name;
                        initialFileInputState.classList.add('hidden');
                        selectedFileInputState.classList.remove('hidden');
                    } else {
                        initialFileInputState.classList.remove('hidden');
                        selectedFileInputState.classList.add('hidden');
                    }
                });
            }

            if (changeFileButton) { // Pastikan elemen ada
                changeFileButton.addEventListener('click', e => {
                    e.preventDefault();
                    fileInput.click();
                });
            }

            if (uploadForm) { // Pastikan elemen ada
                uploadForm.addEventListener('submit', function (e) {
                    const file = fileInput.files[0];
                    const tanggalUji = document.getElementById('tanggal_uji').value;

                    if (!tanggalUji) {
                        showNotification('error', "Tanggal Uji wajib diisi.");
                        e.preventDefault();
                        return;
                    }

                    if (!file) {
                        showNotification('error', "Silakan pilih file terlebih dahulu.");
                        e.preventDefault();
                        return;
                    }

                    if (file.size > 10 * 1024 * 1024) { // Batas 10MB
                        showNotification('error', "Ukuran file terlalu besar. Maksimal 10MB.");
                        e.preventDefault();
                        return;
                    }

                    document.getElementById('tanggal_upload').value = new Date().toISOString().substr(0, 10);
                });
            }

        }); // END of the single, main DOMContentLoaded

        // =========================
        // Fungsi-fungsi Global (di luar DOMContentLoaded)
        // =========================

        // Fungsi untuk menampilkan notifikasi modal
        function showNotification(type, message) {
            if (!flowbitePopupModal) {
                console.error("Modal Notifikasi Flowbite belum terinisialisasi.");
                return;
            }

            const icon = document.getElementById('modal-icon');
            const msg = document.getElementById('modal-message');

            icon.className = 'mx-auto mb-4 w-12 h-12';
            icon.innerHTML = '';
            msg.innerText = message;

            const icons = {
                success: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />`,
                error: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />`,
                info: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                         d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />`
            };

            const colorMap = {
                success_add: 'green',
                success_edit: 'blue',
                success_delete: 'red',
                success_general: 'green',
                error: 'red',
                info: 'blue'
            };

            const color = colorMap[type] ?? 'blue';
            const path = icons[type.startsWith('success') ? 'success' : type] ?? icons.info;

            icon.classList.add(`text-${color}-500`, `stroke-${color}-500`);
            icon.innerHTML = path;

            flowbitePopupModal.show();
            // Tidak perlu manipulasi class 'flex'/'hidden' secara manual, biarkan Flowbite yang mengurusnya
            setTimeout(() => {
                flowbitePopupModal.hide();
            }, 2500);
        }

        // Fungsi untuk menampilkan modal konfirmasi hapus
        function confirmDelete(url) {
            if (!flowbiteDeleteModal) {
                console.error("Modal Konfirmasi Hapus Flowbite belum terinisialisasi.");
                return;
            }
            document.getElementById('delete-form').action = url;
            flowbiteDeleteModal.show();
            // Tidak perlu manipulasi class 'flex'/'hidden' secara manual
        }

        // Menutup modal konfirmasi hapus
        function closeDeleteModal() {
            if (flowbiteDeleteModal) {
                flowbiteDeleteModal.hide();
                // Tidak perlu manipulasi class 'flex'/'hidden' secara manual
            }
        }

        // Fungsi untuk menampilkan atau menyembunyikan modal upload file
        function toggleModal(show) {
            if (!flowbiteModalUploadInstance) {
                console.error("Modal Upload Flowbite belum terinisialisasi.");
                return;
            }

            if (show) {
                const today = new Date().toISOString().substr(0, 10);
                document.getElementById('tanggal_uji').value = today;
                document.getElementById('tanggal_upload').value = today;

                document.getElementById('file_upload').value = '';
                document.getElementById('selected-filename').textContent = 'Tidak ada file yang dipilih';
                document.getElementById('file-input-initial').classList.remove('hidden');
                document.getElementById('file-input-selected').classList.add('hidden');

                flowbiteModalUploadInstance.show();
                // Tidak perlu manipulasi class 'flex'/'hidden' secara manual
            } else {
                flowbiteModalUploadInstance.hide();
                // Tidak perlu manipulasi class 'flex'/'hidden' secara manual
            }
        }
    </script>
@endsection