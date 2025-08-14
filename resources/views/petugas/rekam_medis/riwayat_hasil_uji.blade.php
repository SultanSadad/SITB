{{-- Nama File = [riwayat_hasil_uji.blade,php] --}}
{{-- Deskripsi = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 16 April 2025 --}}

@extends('layout.rekam_medis')
<title>Riwayat Hasil Uji Laboratorium</title>
@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Hasil Laboratorium</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('rekam-medis.hasil-uji.data') }}" method="GET"
                class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                <div class="flex relative">
                    <input type="text" name="search" placeholder="Cari Nama" value="{{ request('search') }}"
                        class="border border-gray-200 rounded-lg text-gray-500 px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="flex gap-2">
                    <input type="date" name="start" value="{{ request('start') }}"
                        class="p-2 border rounded-lg text-sm border-gray-200 text-gray-700">
                    <input type="date" name="end" value="{{ request('end') }}"
                        class="p-2 border rounded-lg text-sm border-gray-200 text-gray-700">
                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <a href="{{ route('rekam-medis.hasil-uji.data') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-800 text-sm border border-gray-300 rounded-lg px-4 py-2 flex items-center">
                        <i class="fas fa-sync-alt mr-2"></i> Reset
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

            <div class="overflow-x-auto rounded-lg">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase">
                        <tr>
                            <th class="px-6 py-3">No</th>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Tanggal Upload</th>
                            <th class="px-6 py-3">No HP</th>
                            <th class="px-6 py-3">Tanggal Uji</th>
                            <th class="px-6 py-3">Hasil Uji</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($hasilUjiList as $index => $hasil)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-6 py-4">{{ $hasilUjiList->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    @if($hasil->pasien->nik)
                                        {{ $hasil->pasien->nik }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    @if($hasil->pasien->nama)
                                        {{ $hasil->pasien->nama }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    {{ $hasil->tanggal_upload ? date('d-m-Y', strtotime($hasil->tanggal_upload)) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
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
                                <td class="px-6 py-4">
                                    {{ $hasil->tanggal_uji ? date('d-m-Y', strtotime($hasil->tanggal_uji)) : 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($hasil->file)
                                        <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank"
                                            class="text-white bg-blue-600 hover:bg-blue-700 text-xs px-3 py-1.5 rounded inline-flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7s-8.268-2.943-9.542-7z" />
                                            </svg>
                                            Lihat
                                        </a>
                                    @else
                                        <span class="text-gray-400">Tidak ada file</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr class="bg-white">
                                <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data hasil laboratorium
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
            <div class="flex justify-center mt-6">
                <div class="join text-sm">
                    {{-- Previous Page --}}
                    @if ($hasilUjiList->onFirstPage())
                        <button class="join-item btn btn-sm btn-disabled text-gray-400">&laquo;</button>
                    @else
                        <a href="{{ $hasilUjiList->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
                    @endif
                    {{-- Page Numbers --}}
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
                    @for ($page = $start; $page <= $end; $page++)
                        <a href="{{ $hasilUjiList->url($page) }}"
                            class="join-item btn btn-sm {{ $page == $current ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                            {{ $page }}
                        </a>
                    @endfor
                    {{-- Next Page --}}
                    @if ($hasilUjiList->hasMorePages())
                        <a href="{{ $hasilUjiList->nextPageUrl() }}" class="join-item btn btn-sm">&raquo;</a>
                    @else
                        <button class="join-item btn btn-sm btn-disabled text-gray-400">&raquo;</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/pages/rekam_medis/flatpickr_range.js')
@endsection