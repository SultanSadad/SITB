{{-- Nama File   = [riwayat_hasil_uji.blade.php] --}}
{{-- Deskripsi   = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal     = 16 April 2025 --}}


@extends('layout.laboran')
<title>Data Hasil Uji Laboratorium</title>
@section('laboran')
    <div class="px-4 md:px-6 mt-4"> {{-- Adjusted padding for mobile --}}
        <h1 class="font-bold text-2xl mb-4 text-center md:text-left">Data Hasil Laboratorium</h1>

        <div class="bg-white shadow-md rounded-lg p-4 md:p-6"> {{-- Adjusted padding for mobile --}}
            <form action="{{ url('/laboran/riwayat-hasil-uji') }}" method="GET"
                class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <div class="relative w-full md:w-64"> {{-- Full width on mobile, fixed width on desktop --}}
                    <input type="text" name="search" placeholder="Cari Pasien" value="{{ request('search') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm pl-10 bg-gray-50 hover:bg-gray-100 transition-all duration-200">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="flex flex-col md:flex-row gap-2">
                    <div class="relative w-full md:w-auto">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                        <input type="date" name="start" value="{{ request('start') }}" placeholder="Dari Tanggal"
                            class="pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm w-full md:w-auto bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:bg-gray-100">
                    </div>

                    <div class="relative w-full md:w-auto">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <i class="fas fa-calendar-alt text-gray-400 text-sm"></i>
                        </div>
                        <input type="date" name="end" value="{{ request('end') }}" placeholder="Ke Tanggal"
                            class="pl-10 pr-3 py-2 border border-gray-200 rounded-lg text-sm w-full md:w-auto bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 hover:bg-gray-100">
                    </div>

                    <button type="submit"
                        class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center w-full md:w-auto transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>

                    <a href="{{ url('/laboran/riwayat-hasil-uji') }}"
                        class="bg-white hover:bg-gray-50 text-gray-700 text-sm border border-gray-200 rounded-lg px-4 py-2 flex items-center justify-center w-full md:w-auto transition-all duration-200 shadow-sm hover:shadow-md">
                        <i class="fas fa-rotate-right mr-2"></i> Reset
                    </a>
                </div>
            </form>

            @if(session('success'))
                <div class="p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 flex justify-between items-center">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span class="text-sm font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.classList.add('hidden')" class="text-green-500 hover:text-green-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            {{-- Mobile Card View --}}
            <div class="block md:hidden"> {{-- This div is only visible on mobile (small screens) --}}
                @forelse($hasilUjiList as $index => $hasil)
                    <div class="bg-white shadow-md rounded-lg p-4 mb-4 border border-gray-200">
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">No.</p>
                            <p class="font-semibold text-gray-800">{{ $hasilUjiList->firstItem() + $index }}</p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">NIK:</p>
                            <p class="font-semibold text-gray-800">
                                @if($hasil->pasien->nik)
                                    {{ $hasil->pasien->nik }}
                                @else
                                    <span class="text-red-500">belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">Nama:</p>
                            <p class="font-semibold text-gray-800">
                                @if($hasil->pasien->nama)
                                    {{ $hasil->pasien->nama }}
                                @else
                                    <span class="text-red-500">belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">Tanggal Upload:</p>
                            <p class="font-semibold text-gray-800">
                                @if($hasil->tanggal_upload)
                                    {{ date('d-m-Y', strtotime($hasil->tanggal_upload)) }}
                                @else
                                    <span class="text-red-500">belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">No HP:</p>
                            <p class="font-semibold text-gray-800">
                                @if($hasil->pasien->no_whatsapp)
                                    @php
                                        $noWa = '62' . ltrim($hasil->pasien->no_whatsapp, '0');
                                    @endphp
                                    <a href="https://wa.me/{{ $noWa }}" target="_blank" class="text-green-600 hover:underline">
                                        {{ $hasil->pasien->no_whatsapp }}
                                    </a>
                                @else
                                    <span class="text-red-500">belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-2">
                            <p class="text-xs text-gray-500">Tanggal Uji:</p>
                            <p class="font-semibold text-gray-800">
                                @if($hasil->tanggal_uji)
                                    {{ date('d-m-Y', strtotime($hasil->tanggal_uji)) }}
                                @else
                                    <span class="text-red-500">belum diisi</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-gray-500">Hasil Uji:</p>
                            <div class="mt-1">
                                @if($hasil->file)
                                    <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank"
                                        class="text-white bg-blue-600 hover:bg-blue-700 text-xs px-3 py-2 rounded inline-flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat Hasil
                                    </a>
                                @else
                                    <span class="text-red-500 text-sm">belum diisi</span>
                                @endif
                            </div>
                        </div>

                        {{-- Actions for Mobile --}}
                        <div class="flex flex-col gap-2"> {{-- Stack buttons vertically on mobile --}}
                            <form action="{{ route('laboran.hasil-uji.destroy', $hasil->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold w-full">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white shadow-md rounded-lg p-4 text-center text-gray-500">
                        Tidak ada data hasil laboratorium
                    </div>
                @endforelse
            </div>

            {{-- Desktop Table View --}}
            <div class="hidden md:block overflow-x-auto"> {{-- This div is hidden on mobile, visible on medium screens and
                up --}}
                <table class="w-full text-sm text-left text-gray-700 whitespace-nowrap">
                    <thead class="bg-gray-100 text-xs uppercase">
                        <tr>
                            <th class="px-3 py-2">No</th>
                            <th class="px-3 py-2">NIK</th>
                            <th class="px-3 py-2">Nama</th>
                            <th class="px-3 py-2">Tanggal Upload</th>
                            <th class="px-3 py-2">No HP</th>
                            <th class="px-3 py-2">Tanggal Uji</th>
                            <th class="px-3 py-2">Hasil Uji</th>
                            <th class="px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilUjiList as $index => $hasil)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-3 py-2">{{ $hasilUjiList->firstItem() + $index }}</td>

                                <td class="px-3 py-2">
                                    @if($hasil->pasien->nik)
                                        {{ $hasil->pasien->nik }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2">
                                    @if($hasil->pasien->nama)
                                        {{ $hasil->pasien->nama }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2">
                                    @if($hasil->tanggal_upload)
                                        {{ date('d-m-Y', strtotime($hasil->tanggal_upload)) }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2">
                                    @if($hasil->pasien->no_whatsapp)
                                        @php
                                            $noWa = '62' . ltrim($hasil->pasien->no_whatsapp, '0');
                                        @endphp
                                        <a href="https://wa.me/{{ $noWa }}" target="_blank" class="text-green-600 hover:underline">
                                            {{ $hasil->pasien->no_whatsapp }}
                                        </a>
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2">
                                    @if($hasil->tanggal_uji)
                                        {{ date('d-m-Y', strtotime($hasil->tanggal_uji)) }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-3 py-2">
                                    @if($hasil->file)
                                        <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank"
                                            class="text-white bg-blue-600 hover:bg-blue-700 text-xs px-2 py-1 rounded inline-flex items-center">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-3 py-3">
                                    <form action="{{ route('laboran.hasil-uji.destroy', $hasil->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>

                        @empty
                            <tr class="bg-white">
                                <td colspan="8" class="px-3 py-2 text-center text-gray-500">Tidak ada data hasil laboratorium
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="w-full border-t border-gray-200 pt-4">
                <div class="flex justify-center">
                    <div class="join text-sm">
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

                        {{-- Tombol Sebelumnya --}}
                        @if ($hasilUjiList->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $hasilUjiList->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
                        @endif

                        {{-- Nomor Halaman --}}
                        @for ($page = $start; $page <= $end; $page++)
                            <a href="{{ $hasilUjiList->url($page) }}"
                                class="join-item btn btn-sm {{ $page == $current ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                                {{ $page }}
                            </a>
                        @endfor

                        {{-- Tombol Selanjutnya --}}
                        @if ($hasilUjiList->hasMorePages())
                            <a href="{{ $hasilUjiList->nextPageUrl() }}" class="join-item btn btn-sm">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi flatpickr untuk input tanggal mulai
            const startDatePicker = flatpickr("input[name='start']", {
                dateFormat: "Y-m-d", // Format tanggal ISO
                allowInput: true,    // Izinkan input manual oleh user
                onChange: function (selectedDates, dateStr) {
                    // Saat tanggal mulai dipilih, atur batas minimal tanggal akhir
                    if (selectedDates[0]) {
                        endDatePicker.set('minDate', dateStr);
                    }
                }
            });

            // Inisialisasi flatpickr untuk input tanggal akhir
            const endDatePicker = flatpickr("input[name='end']", {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function (selectedDates, dateStr) {
                    // Saat tanggal akhir dipilih, atur batas maksimal tanggal mulai
                    if (selectedDates[0]) {
                        startDatePicker.set('maxDate', dateStr);
                    }
                }
            });

            // Ambil elemen input yang sudah punya nilai awal
            const startInput = document.querySelector('input[name="start"]');
            const endInput = document.querySelector('input[name="end"]');

            // Jika ada tanggal mulai, atur batas minimum untuk tanggal akhir
            if (startInput && startInput.value) {
                endDatePicker.set('minDate', startInput.value);
            }

            // Jika ada tanggal akhir, atur batas maksimum untuk tanggal mulai
            if (endInput && endInput.value) {
                startDatePicker.set('maxDate', endInput.value);
            }

            // Fungsi untuk menyembunyikan notifikasi alert saat tombol 'X' diklik
            const dismissButton = document.querySelector('.p-4.mb-4 button');
            if (dismissButton) {
                dismissButton.addEventListener('click', () => {
                    dismissButton.parentElement.classList.add('hidden'); // Sembunyikan elemen induk
                });
            }
        });
    </script>
@endsection