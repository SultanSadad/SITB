{{-- Nama File = detail_hasil_uji.blade.php --}}
{{-- Deskripsi = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 16 April 2025 --}}

@extends('layout.rekam_medis')
<title>Detail Hasil Uji Laboratorium</title>
@section('rekam_medis')
    <div class="relative px-4 md:px-6 mt-1">
        <h1 class="font-bold text-xl md:text-2xl mb-4">Detail Hasil Uji Laboratorium</h1>

        <!-- Patient Info -->
        <div class="mb-4 md:mb-6">
            <span class="text-sm text-gray-500">Pasien:</span>
            <span class="text-lg md:text-xl font-bold text-gray-800 truncate">{{ $pasien->nama }}</span>
        </div>

        <div class="bg-white shadow-lg rounded-sm p-4 md:p-6">
            <!-- Tombol Kembali -->
            <div class="mb-4 md:mb-6">
                <a href="{{ url('/petugas/rekam-medis/hasil-uji') }}"
                    class="inline-flex items-center bg-gray-600 hover:bg-gray-700 text-white px-3 md:px-4 py-2 rounded-md text-sm font-medium transition">
                    <i class="fa-solid fa-arrow-left mr-1 md:mr-2"></i>
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Kembali</span>
                </a>
            </div>
            <!-- Mobile Card View (Hidden on larger screens) -->
            <div class="block md:hidden space-y-4">
                @forelse ($hasilUjiList as $hasil)
                    <div class="bg-gray-50 rounded-sm p-4 border hover:shadow-md transition">
                        <div class="space-y-3">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase font-medium">Tanggal Uji</div>
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($hasil->tanggal_uji)->format('d-m-Y') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500 uppercase font-medium">Tanggal Upload</div>
                                    <div class="text-sm font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($hasil->tanggal_upload)->format('d-m-Y') }}
                                    </div>
                                </div>
                            </div>

                            <div class="pt-3 border-t">
                                <div class="flex gap-2">
                                    {{-- Tombol LIHAT --}}
                                    <a href="{{ asset('storage/' . $hasil->file) }}"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2.5 rounded-lg text-sm font-medium inline-flex items-center justify-center transition-all duration-200"
                                        target="_blank">
                                        <i class="fas fa-eye mr-2"></i>
                                        Lihat
                                    </a>

                                    {{-- Tombol UNDUH --}}
                                    <a href="{{ asset('storage/' . $hasil->file) }}"
                                        class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2.5 rounded-lg text-sm font-medium inline-flex items-center justify-center transition-all duration-200"
                                        download>
                                        <i class="fas fa-download mr-2"></i>
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class=" py-8">
                        <div class="text-gray-400 mb-2">
                            <i class="fa-solid fa-file-medical text-3xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">Belum ada hasil uji.</p>
                    </div>
                @endforelse
            </div>
            <!-- Desktop Table View (Hidden on mobile) -->
            <div class="hidden md:block">
                <div class="overflow-x-auto rounded-sm border border-gray-200">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs uppercase bg-gray-100">
                            <thead class="bg-gray-100 text-xs uppercase font-semibold text-gray-700">
                                <tr>
                                    <th class="px-4 lg:px-6 py-4 font-semibold text-center whitespace-nowrap">Tanggal Uji
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 font-semibold text-center whitespace-nowrap">Tanggal Upload
                                    </th>
                                    <th class="px-4 lg:px-6 py-4 font-semibold text-center whitespace-nowrap">File</th>
                                </tr>
                            </thead>
                        <tbody>
                            @forelse ($hasilUjiList as $hasil)
                                <tr class="bg-white border">

                                    <td class="px-4 lg:px-6 py-4 text-center whitespace-nowrap font-medium">
                                        {{ \Carbon\Carbon::parse($hasil->tanggal_uji)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 lg:px-6 py-4 text-center whitespace-nowrap font-medium">
                                        {{ \Carbon\Carbon::parse($hasil->tanggal_upload)->format('d-m-Y') }}
                                    </td>
                                    <td class="px-4 lg:px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex justify-center gap-2">
                                            {{-- Tombol Lihat --}}
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


                                            {{-- Tombol Unduh --}}
                                            <a href="{{ asset('storage/' . $hasil->file) }}" download
                                                class="bg-gray-600 hover:bg-gray-700 text-white px-2.5 py-1 rounded-md text-xs font-medium inline-flex items-center transition">
                                                <i class="fas fa-download mr-1 text-xs"></i> Unduh
                                            </a>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="text-gray-400 mb-3">
                                            <i class="fa-solid fa-file-medical text-4xl"></i>
                                        </div>
                                        <p class="text-gray-500">Belum ada hasil uji.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
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
                        @for ($page = 1; $page <= $hasilUjiList->lastPage(); $page++)
                            @if ($page == 1 || $page == $hasilUjiList->lastPage() || ($page >= $hasilUjiList->currentPage() - 1 && $page <= $hasilUjiList->currentPage() + 1))
                                <a href="{{ $hasilUjiList->url($page) }}"
                                    class="join-item btn btn-sm border {{ $page == $hasilUjiList->currentPage() ? 'bg-blue-100 text-blue-600 border-blue-300' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">
                                    {{ $page }}
                                </a>
                            @elseif ($page == $hasilUjiList->currentPage() - 2 || $page == $hasilUjiList->currentPage() + 2)
                                <button class="join-item btn btn-sm btn-disabled border border-gray-300">...</button>
                            @endif
                        @endfor

                        {{-- Tombol Berikutnya --}}
                        @if ($hasilUjiList->hasMorePages())
                            <a href="{{ $hasilUjiList->nextPageUrl() }}"
                                class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>
            @endif
        </div>
        <style nonce="{{ $nonce }}">
            @media (max-width: 768px) {
                .truncate {
                    max-width: 250px;
                }
            }

            @media (max-width: 480px) {
                .truncate {
                    max-width: 200px;
                }
            }

            /* Smooth transitions for all interactive elements */
            .transition {
                transition: all 0.2s ease-in-out;
            }

            /* Enhanced hover effects */
            .hover\:shadow-md:hover {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
        </style>
@endsection