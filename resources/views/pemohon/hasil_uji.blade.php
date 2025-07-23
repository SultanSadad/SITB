@extends('layout.pasien')

@section('pasien')
    <div class="px-4 md:px-6 py-5">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h1 class="font-bold text-xl md:text-2xl text-gray-800">
                <i class="fas fa-flask mr-2 text-blue-600"></i>Hasil Uji Laboratorium
            </h1>
            @php
                // Ambil data 'updated_at' terbaru dari list
                $lastUpdate = $hasilUjiList->isNotEmpty() ? $hasilUjiList->max('updated_at') : null;
            @endphp

            <div class="text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-1"></i>
                <span class="hidden sm:inline">Update terakhir:</span>
                <span class="sm:hidden">Update:</span>
                {{ $lastUpdate ? \Carbon\Carbon::parse($lastUpdate)->translatedFormat('d M Y') : '-' }}
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl p-4 md:p-6 border border-gray-100">
            <div class="mb-6">
                <form action="{{ route('pasien.hasil-uji.index') }}" method="GET"
                    class="flex flex-col sm:flex-row sm:items-end gap-4 w-full">

                    <div class="relative flex-1 sm:max-w-xs">
                        <input type="text" id="search" name="search"
                            class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            placeholder="Cari berdasarkan tanggal uji" value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="h-[42px] bg-blue-600 hover:bg-blue-700 text-white px-4 rounded-lg text-sm flex items-center whitespace-nowrap">
                            <i class="fas fa-search mr-2"></i>
                            <span class="hidden sm:inline">Cari</span>
                            <span class="sm:hidden">Cari</span>
                        </button>
                        <a href="{{ route('pasien.hasil-uji.index') }}"
                            class="h-[42px] bg-gray-100 hover:bg-gray-200 text-gray-800 border border-gray-300 px-4 rounded-lg text-sm flex items-center whitespace-nowrap">
                            <i class="fas fa-sync-alt mr-2"></i>
                            <span class="hidden sm:inline">Reset</span>
                            <span class="sm:hidden">Reset</span>
                        </a>
                    </div>
                </form>
            </div>

            <div class="block md:hidden space-y-4">
                @forelse($hasilUjiList as $hasil)
                    <div class="bg-gray-50 rounded-lg p-4 border hover:shadow-md transition-all duration-200">
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase font-medium flex items-center">
                                        <i class="fas fa-calendar-day mr-1 text-blue-600"></i>
                                        Tanggal Uji
                                    </div>
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($hasil->tanggal_uji)->format('d F Y') }}
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-xs text-gray-500 uppercase font-medium flex items-center justify-end">
                                        <i class="fas fa-cloud-upload-alt mr-1 text-blue-600"></i>
                                        Upload
                                    </div>
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ $hasil->tanggal_upload ? \Carbon\Carbon::parse($hasil->tanggal_upload)->translatedFormat('d M Y') : '-' }}
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t">
                                <div class="flex gap-2">
                                    <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}" target="_blank"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-2.5 py-1 rounded-md text-xs font-medium inline-flex items-center justify-center transition-all duration-200">
                                        <i class="fas fa-eye mr-1 text-xs"></i>
                                        Lihat
                                    </a>

                                    <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}?download=true"
                                        class="bg-gray-600 hover:bg-gray-700 text-white px-2.5 py-1 rounded-md text-xs font-medium inline-flex items-center justify-center transition-all duration-200">
                                        <i class="fas fa-download mr-1 text-xs"></i>
                                        Unduh
                                    </a>
                                    <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}?download=true">
    🔽 Unduh PDF Hasil
</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-folder-open text-5xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">Tidak ada hasil uji laboratorium yang tersedia</p>
                    </div>
                @endforelse
            </div>

            <div class="hidden md:block">
                <div class="overflow-x-auto bg-white rounded-xl border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700 min-w-full">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-4 lg:px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-calendar-day mr-2 text-blue-600"></i>
                                        Tanggal Uji
                                    </div>
                                </th>
                                <th class="px-4 lg:px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-cloud-upload-alt mr-2 text-blue-600"></i>
                                        Tanggal Upload
                                    </div>
                                </th>
                                <th class="px-4 lg:px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center">
                                        <i class="fas fa-file-medical mr-2 text-blue-600"></i>
                                        File
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($hasilUjiList as $hasil)
                                <tr class="bg-white border-b hover:bg-blue-50 transition-all duration-200 text-center">
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium">
                                            {{ \Carbon\Carbon::parse($hasil->tanggal_uji)->format('d F Y') }}
                                        </div>

                                    </td>
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        @if($hasil->tanggal_upload)
                                            <div class="font-medium">
                                                {{ \Carbon\Carbon::parse($hasil->tanggal_upload)->translatedFormat('d F Y') }}
                                            </div>

                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 lg:px-6 py-4">
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ asset('storage/' . $hasil->file) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center transition-all duration-200 whitespace-nowrap"
                                                target="_blank">
                                                <i class="fas fa-eye mr-1.5"></i>
                                                <span class="hidden lg:inline">Lihat</span>
                                                <span class="lg:hidden">View</span>
                                            </a>

                                            <a href="{{ asset('storage/' . $hasil->file) }}"
                                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center transition-all duration-200 whitespace-nowrap"
                                                download>
                                                <i class="fas fa-download mr-1.5"></i>
                                                <span class="hidden lg:inline">Unduh</span>
                                                <span class="lg:hidden">Download</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border-b text-center">
                                    <td colspan="3" class="px-6 py-12 text-gray-500">
                                        <div class="flex flex-col items-center justify-center">
                                            <i class="fas fa-folder-open text-4xl text-gray-400 mb-3"></i>
                                            <p>Tidak ada hasil uji laboratorium yang tersedia</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="sm:items-center mt-6 gap-4">
                {{-- AWAL KODE PAGINATION KUSTOM --}}
                @if ($hasilUjiList->hasPages())
                    <div class="flex justify-center mt-6 sm:mt-0">
                        <div class="join text-sm">
                            {{-- Tombol Sebelumnya --}}
                            @if ($hasilUjiList->onFirstPage())
                                <button
                                    class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&laquo;</button>
                            @else
                                <a href="{{ $hasilUjiList->previousPageUrl() }}"
                                    class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&laquo;</a>
                            @endif

                            {{-- Halaman --}}
                            @php
                                $current = $hasilUjiList->currentPage();
                                $last = $hasilUjiList->lastPage();
                            @endphp
                            @for ($page = 1; $page <= $last; $page++)
                                @if ($page == 1 || $page == $last || ($page >= $current - 1 && $page <= $current + 1))
                                    <a href="{{ $hasilUjiList->url($page) }}"
                                        class="join-item btn btn-sm border {{ $page == $current ? 'bg-blue-100 text-blue-600 border-blue-300' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                                        {{ $page }}
                                    </a>
                                @elseif ($page == $current - 2 || $page == $current + 2)
                                    <button class="join-item btn btn-sm btn-disabled border border-gray-200">...</button>
                                @endif
                            @endfor

                            {{-- Tombol Berikutnya --}}
                            @if ($hasilUjiList->hasMorePages())
                                <a href="{{ $hasilUjiList->nextPageUrl() }}"
                                    class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
                            @else
                                <button
                                    class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
                            @endif
                        </div>
                    </div>
                @endif
                {{-- AKHIR KODE PAGINATION KUSTOM --}}
            </div>
        </div>

        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3 text-lg flex-shrink-0"></i>
                <div>
                    <p class="font-medium text-blue-800 mb-1">Informasi Hasil Uji Laboratorium</p>
                    <p class="text-blue-700">Apabila anda memiliki pertanyaan tentang hasil uji laboratorium, silahkan
                        hubungi dokter di Puskesmas.</p>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <script>
        flatpickr("#search", {
            locale: "id",
            altInput: true,
            altFormat: "d F Y",     // Ini tampilan: 23 Februari 2005
            dateFormat: "Y-m-d",    // Ini yang dikirim ke controller: 2005-02-23
            disableMobile: "true" // Optional: untuk tampilan desktop picker di mobile
        });
    </script>

    <style>
        @media (max-width: 640px) {
            .flex-1 {
                min-width: 0;
            }
        }

        /* Enhanced transitions */
        .transition-all {
            transition: all 0.2s ease-in-out;
        }

        /* Better hover effects for mobile */
        @media (hover: hover) {
            .hover\:shadow-md:hover {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
        }
    </style>

@endsection