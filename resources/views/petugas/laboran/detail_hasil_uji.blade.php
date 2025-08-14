{{-- Nama File = detail_hasil_uji.blade.php] --}}
{{-- Deskripsi = Update modal data hasil uji --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 10 April 2025 --}}

{{-- Nama File = [detail_hasil_uji.blade.php] --}}
{{-- Deskripsi = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 16 April 2025 --}}

@extends('layout.laboran')
<title>Detail Hasil Uji Laboratorium</title>
@section('content')
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

                <button type="button" data-modal-target="modalUpload" data-modal-toggle="modalUpload"
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
                                <button type="button" data-modal-hide="delete-modal"
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
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition btn-open-delete"
                                            data-delete-url="{{ route('laboran.hasil-uji.destroy', $hasil->id) }}">
                                            Hapus
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
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold transition w-full btn-open-delete"
                                data-delete-url="{{ route('laboran.hasil-uji.destroy', $hasil->id) }}">
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
                    <button type="button" data-modal-hide="modalUpload"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center">
                        <!-- icon -->
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <form id="uploadForm" action="{{ route('laboran.hasil-uji.store', $pasien->id) }}" method="POST"
                    enctype="multipart/form-data" class="p-5 space-y-5">
                    @csrf

                    {{-- Tanggal Uji --}}
                    <div>
                        <label for="tanggal_uji" class="block mb-2 text-base font-medium text-gray-900">Tanggal Uji</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input type="date" id="tanggal_uji" name="tanggal_uji"
                                class="bg-gray-50 border border-gray-300 text-base rounded-lg block w-full pl-10 pr-3 py-2.5"
                                required>
                        </div>
                    </div>

                    <input type="hidden" id="tanggal_upload" name="tanggal_upload">

                    {{-- File Upload --}}
                    <div>
                        <label class="block mb-2 text-base font-medium text-gray-900">File Hasil Uji</label>

                        {{-- Tampilan awal --}}
                        <div id="file-input-initial" class="flex w-full">
                            <label for="file_upload"
                                class="cursor-pointer px-4 py-2 bg-white border border-gray-300 rounded-l-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Pilih File
                            </label>
                            <div
                                class="flex-grow bg-gray-50 border border-l-0 border-gray-300 rounded-r-lg py-2 px-3 text-sm text-gray-500 truncate">
                                Tidak ada file yang dipilih
                            </div>
                        </div>

                        {{-- Tampilan setelah file dipilih --}}
                        <div id="file-input-selected"
                            class="hidden items-center justify-between bg-gray-50 border border-gray-300 rounded-lg py-2 px-3 mt-1">
                            <div class="text-sm text-gray-900 truncate" id="selected-filename">filename.pdf</div>
                            <button type="button" id="change-file-btn"
                                class="ml-2 text-sm text-blue-600 hover:text-blue-800 font-medium flex-shrink-0">
                                Ganti File
                            </button>
                        </div>

                        <input id="file_upload" type="file" name="file" class="hidden" accept=".pdf" required>
                        <p class="mt-2 text-sm text-gray-500">Format: PDF (Maksimal 10MB)</p>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="flex justify-end space-x-2 pt-3">
                        <button type="button" data-modal-hide="modalUpload"
                            class="btn-cancel px-5 py-2.5 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium text-gray-800">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm">
                            Upload
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.3/dist/flowbite.min.js"></script>
    <script nonce="{{ request()->attributes->get('csp_nonce') }}">
        document.addEventListener('DOMContentLoaded', function () {
            try { window.initFlowbite && window.initFlowbite(); } catch (e) { }

            const deleteEl = document.getElementById('delete-modal');
            const uploadEl = document.getElementById('modalUpload');
            const popupEl = document.getElementById('popup-modal');

            const DeleteModal = (typeof Modal !== 'undefined' && deleteEl) ? new Modal(deleteEl) : null;
            const UploadModal = (typeof Modal !== 'undefined' && uploadEl) ? new Modal(uploadEl) : null;
            const PopupModal = (typeof Modal !== 'undefined' && popupEl) ? new Modal(popupEl) : null;

            /* ✅ Perbaikan: agar semua tombol close modal berfungsi */
            if (DeleteModal) {
                document.querySelectorAll('[data-modal-hide="delete-modal"]').forEach(btn => {
                    btn.addEventListener('click', () => DeleteModal.hide());
                });
            }
            if (UploadModal) {
                document.querySelectorAll('[data-modal-hide="modalUpload"]').forEach(btn => {
                    btn.addEventListener('click', () => UploadModal.hide());
                });
            }
            // Tombol batal di form upload
            document.querySelectorAll('#modalUpload .btn-cancel').forEach(btn => {
                btn.addEventListener('click', () => {
                    if (UploadModal) UploadModal.hide();
                });
            });

            // 🔽 sisanya script kamu seperti semula...


            // ----- OPEN delete modal via delegation -----
            document.addEventListener('click', (e) => {
                const btn = e.target.closest('.btn-open-delete');
                if (!btn) return;

                const url = btn.getAttribute('data-delete-url');
                const form = document.getElementById('delete-form');
                if (form && url) form.action = url;

                if (DeleteModal) DeleteModal.show();
            });

            // ----- Auto-set tanggal + reset file ketika modal upload tampak -----
            if (uploadEl) {
                const fileInput = document.getElementById('file_upload');
                const initialBox = document.getElementById('file-input-initial');
                const selectedBox = document.getElementById('file-input-selected');
                const fileNameEl = document.getElementById('selected-filename');
                const tUji = document.getElementById('tanggal_uji');
                const tUpload = document.getElementById('tanggal_upload');

                const onOpen = () => {
                    const today = new Date().toISOString().slice(0, 10);
                    if (tUji) tUji.value = today;
                    if (tUpload) tUpload.value = today;

                    if (fileInput) fileInput.value = '';
                    if (fileNameEl) fileNameEl.textContent = 'Tidak ada file yang dipilih';
                    if (initialBox && selectedBox) { initialBox.classList.remove('hidden'); selectedBox.classList.add('hidden'); }
                };

                // observer untuk perubahan class (Flowbite toggle hidden/flex)
                const obs = new MutationObserver(() => {
                    const open = uploadEl.classList.contains('flex') && !uploadEl.classList.contains('hidden');
                    if (open) onOpen();
                });
                obs.observe(uploadEl, { attributes: true, attributeFilter: ['class'] });

                // UI "ganti file"
                const changeBtn = document.getElementById('change-file-btn');
                if (changeBtn && fileInput) {
                    changeBtn.addEventListener('click', (ev) => { ev.preventDefault(); fileInput.click(); });
                }
                if (fileInput && fileNameEl && initialBox && selectedBox) {
                    fileInput.addEventListener('change', () => {
                        const f = fileInput.files[0];
                        if (f) {
                            fileNameEl.textContent = f.name;
                            initialBox.classList.add('hidden');
                            selectedBox.classList.remove('hidden');
                        } else {
                            initialBox.classList.remove('hidden');
                            selectedBox.classList.add('hidden');
                        }
                    });
                }
            }

            // ----- Validasi ringan sebelum submit upload -----
            const uploadForm = document.getElementById('uploadForm');
            if (uploadForm) {
                const fileInput = document.getElementById('file_upload');
                uploadForm.addEventListener('submit', (e) => {
                    const file = fileInput && fileInput.files[0];
                    const tUjiVal = (document.getElementById('tanggal_uji') || {}).value || '';
                    if (!tUjiVal) { showNotif('error', 'Tanggal Uji wajib diisi.'); e.preventDefault(); return; }
                    if (!file) { showNotif('error', 'Silakan pilih file terlebih dahulu.'); e.preventDefault(); return; }
                    if (file.size > 10 * 1024 * 1024) { showNotif('error', 'Ukuran file terlalu besar. Maksimal 10MB.'); e.preventDefault(); return; }
                    const tUpload = document.getElementById('tanggal_upload');
                    if (tUpload) tUpload.value = new Date().toISOString().slice(0, 10);
                });
            }

            // ----- Flash dari Laravel (error/success) -> modal notif -----
            @if ($errors->any())
                showNotif('error', @json($errors->first()));
            @endif
            @if (session('success'))
                showNotif('success', @json(session('success')));
            @elseif (session('error'))
                showNotif('error', @json(session('error')));
            @endif

            function showNotif(type, msg) {
                if (!PopupModal) return;
                const icon = document.getElementById('modal-icon');
                const text = document.getElementById('modal-message');
                if (text) text.textContent = msg || 'Informasi';
                if (icon) {
                    icon.className = 'mx-auto mb-4 w-12 h-12';
                    const paths = {
                        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
                    };
                    icon.innerHTML = paths[type] || paths.info;
                }
                PopupModal.show();
                setTimeout(() => PopupModal.hide(), 2500);
            }
        });
    </script>

@endsection