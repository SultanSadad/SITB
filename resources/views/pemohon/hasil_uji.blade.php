{{-- resources/views/pemohon/hasil_uji.blade.php --}}
@extends('layout.pasien')

@section('pasien')
    @php
        // Guard agar tidak undefined
        $lastUpdate = $lastUpdate ?? ($hasilUjiList->isNotEmpty() ? $hasilUjiList->max('updated_at') : null);
    @endphp

    <div class="px-4 md:px-6 py-5">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-6 gap-4">
            <h1 class="font-bold text-xl md:text-2xl text-gray-800">
                <i class="fas fa-flask mr-2 text-blue-600"></i>Hasil Uji Laboratorium
            </h1>

            <div class="text-sm text-gray-500">
                <i class="fas fa-calendar-alt mr-1"></i>
                <span class="hidden sm:inline">Update terakhir:</span>
                <span class="sm:hidden">Update:</span>
                {{ $lastUpdate ? \Carbon\Carbon::parse($lastUpdate)->translatedFormat('d M Y') : '-' }}
            </div>
        </div>

        {{-- Card utama --}}
        <div class="bg-white shadow-lg rounded-xl p-4 md:p-6 border border-gray-100">

            {{-- Search and Reset Form --}}
            <div class="mb-6">
                <form action="{{ route('pasien.hasil-uji.index') }}" method="GET" class="flex flex-col md:flex-row items-stretch md:items-center gap-3">
                    <div class="relative flex-none md:w-auto w-full">
                        <input type="date" id="search" name="search"
                            class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full md:w-[220px] focus:outline-none focus:ring focus:border-blue-300 text-sm text-gray-700"
                            value="{{ request('search') }}">
                    </div>
                    <div class="flex gap-3 w-full md:w-auto">
                        <button type="submit"
                            class="flex-1 h-[42px] px-4 rounded-lg text-sm flex items-center justify-center !bg-[#2F59D1] !text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-[#2F59D1]/30">
                            <i class="fas fa-search mr-2"></i> Cari
                        </button>
                        <a href="{{ route('pasien.hasil-uji.index') }}"
                            class="flex-1 h-[42px] px-4 rounded-lg text-sm flex items-center justify-center bg-gray-100 text-gray-800 border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-gray-300/40">
                            <i class="fas fa-sync-alt mr-2"></i> Reset
                        </a>
                    </div>
                </form>
            </div>


            {{-- Mobile list --}}
            <div class="block md:hidden space-y-4">
                @forelse($hasilUjiList as $hasil)
                    <div
                        class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 p-5 border border-gray-200">
                        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center">
                            <div class="mb-4 sm:mb-0 flex-grow">
                                <div class="text-xs text-gray-500 uppercase font-medium mb-1">Hasil Uji Laboratorium</div>

                                <div class="mt-2 text-sm text-gray-600">
                                    <div class="flex items-center mb-1">
                                        <i class="fas fa-calendar-day text-sm text-gray-400 mr-2"></i>
                                        Tanggal Uji: <span
                                            class="font-medium ml-1">{{ \Carbon\Carbon::parse($hasil->tanggal_uji)->translatedFormat('d F Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-cloud-upload-alt text-sm text-gray-400 mr-2"></i>
                                        Diunggah: <span
                                            class="font-medium ml-1">{{ $hasil->tanggal_upload ? \Carbon\Carbon::parse($hasil->tanggal_upload)->translatedFormat('d M Y') : 'Menunggu' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}" target="_blank"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center justify-center transition-all duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    Lihat
                                </a>

                                <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}?download=true"
                                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center justify-center transition-all duration-200">
                                    <i class="fas fa-download mr-2"></i>
                                    Unduh
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-16 px-4 bg-gray-50 rounded-xl">
                        <div class="text-gray-400 mb-4">
                            <i class="fas fa-folder-open text-6xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum ada hasil tes yang tersedia</h3>
                        <p class="text-gray-500 text-sm">Hasil tes Anda akan muncul di sini setelah selesai diproses.</p>
                    </div>
                @endforelse
            </div>

            {{-- Desktop table --}}
            <div class="hidden md:block">
                <div class="overflow-x-auto bg-white rounded-xl border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700 min-w-full">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
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
                                <tr class="bg-white hover:bg-blue-50 transition-all duration-200 text-center">
                                    <td class="px-4 lg:px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium">
                                            {{ \Carbon\Carbon::parse($hasil->tanggal_uji)->translatedFormat('d F Y') }}
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
                                            <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center transition-all duration-200 whitespace-nowrap"
                                                target="_blank">
                                                <i class="fas fa-eye mr-1.5"></i>
                                                <span class="hidden lg:inline">Lihat</span>
                                                <span class="lg:hidden">View</span>
                                            </a>

                                            <a href="{{ route('pasien.hasil-uji.show', $hasil->id) }}?download=true"
                                                class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium inline-flex items-center transition-all duration-200 whitespace-nowrap">
                                                <i class="fas fa-download mr-1.5"></i>
                                                <span class="hidden lg:inline">Unduh</span>
                                                <span class="lg:hidden">Download</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white text-center">
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

            {{-- Pagination --}}
            @if ($hasilUjiList->hasPages())
                <div class="flex justify-center mt-6">
                    <div class="join text-sm">
                        {{-- Prev --}}
                        @if ($hasilUjiList->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $hasilUjiList->previousPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&laquo;</a>
                        @endif

                        {{-- Numbers --}}
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

                        {{-- Next --}}
                        @if ($hasilUjiList->hasMorePages())
                            <a href="{{ $hasilUjiList->nextPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>
            @endif
            {{-- /Pagination --}}
        </div>

        {{-- Info box --}}
        <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4 text-sm">
            <div class="flex items-start">
                <i class="fas fa-info-circle text-blue-600 mt-0.5 mr-3 text-lg flex-shrink-0"></i>
                <div>
                    <p class="font-medium text-blue-800 mb-1">Informasi Hasil Uji Laboratorium</p>
                    <p class="text-blue-700">
                        Apabila Anda memiliki pertanyaan tentang hasil uji laboratorium, silakan hubungi dokter di
                        Puskesmas.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection