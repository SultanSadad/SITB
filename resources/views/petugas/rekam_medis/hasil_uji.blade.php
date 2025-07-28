{{-- Nama File = [hasil_uji.blade.php] --}}
{{-- Deskripsi = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal = 16 April 2025 --}}

@extends('layout.rekam_medis')
<title>Hasil Uji Laboratorium</title>
@section('rekam_medis')

    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Hasil Uji Laboratorium</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6">
                <form action="{{ url('petugas/rekam-medis/hasil-uji') }}" method="GET" class="w-full sm:w-64">
                    <div class="relative w-full">
                        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
                            class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
            </div>

            {{-- Table View (Desktop & Tablet) --}}
            <div id="desktop-table-container" class="hidden md:block overflow-x-auto mt-6">
                <table class="min-w-full divide-y divide-gray-200 text-sm text-left text-gray-700">
                    <thead class="bg-gray-100 text-xs uppercase font-semibold text-gray-700">
                        <tr>
                            <th class="px-6 py-3">NO.ERM</th>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">Nama Pasien</th>
                            <th class="px-6 py-3">Tanggal Lahir</th>
                            <th class="px-6 py-3">No WhatsApp</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="desktop-table-body">
                        @forelse ($hasilUjiList->unique('pasien_id') as $hasil)
                                        <tr class="bg-white">
                                            <td
                                                class="px-6 py-4 font-medium {{ $hasil->pasien->no_erm ? 'text-gray-900' : 'text-red-500' }}">
                                                {{ $hasil->pasien->no_erm ?? 'Belum diisi' }}
                                            </td>
                                            <td class="px-6 py-4 font-medium {{ $hasil->pasien->nik ? 'text-gray-900' : 'text-red-500' }}">
                                                {{ $hasil->pasien->nik ?? 'Belum diisi' }}
                                            </td>
                                            <td class="px-6 py-4 font-medium {{ $hasil->pasien->nama ? 'text-gray-900' : 'text-red-500' }}">
                                                {{ $hasil->pasien->nama ?? 'Belum diisi' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium {{ $hasil->pasien->tanggal_lahir ? 'text-gray-900' : 'text-red-500' }}">
                                                {{ $hasil->pasien->tanggal_lahir
                            ? \Carbon\Carbon::parse($hasil->pasien->tanggal_lahir)->translatedFormat('d-m-Y')
                            : 'Belum diisi' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium {{ $hasil->pasien->no_whatsapp ? 'text-gray-900' : 'text-red-500' }}">
                                                @if($hasil->pasien->no_whatsapp)
                                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $hasil->pasien->no_whatsapp) }}"
                                                        target="_blank" class="text-green-600 hover:underline">
                                                        {{ $hasil->pasien->no_whatsapp }}
                                                    </a>
                                                @else
                                                    Belum diisi
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                {{-- Perubahan di sini: Kondisi diganti menjadi $hasil->pasien->id --}}
                                                @if($hasil->pasien && $hasil->pasien->id)
                                                    <a href="{{ route('rekam-medis.hasil-uji.show', ['pasienId' => $hasil->pasien->id]) }}"
                                                        class="inline-block bg-pink-500 hover:bg-pink-600 text-white text-xs font-medium px-3 py-1 rounded transition">
                                                        Detail
                                                    </a>
                                                @else
                                                    <span class="text-xs italic text-red-500">Pasien Tidak Ditemukan</span> {{-- Ubah pesan --}}
                                                @endif
                                            </td>
                                        </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pasien.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Card View (Mobile) --}}
            <div id="mobile-cards-container" class="md:hidden space-y-4 mt-6">
                @forelse ($hasilUjiList->unique('pasien_id') as $hasil)
                        <div class="bg-white border border-gray-200 rounded-xl shadow p-4">
                            @php $p = $hasil->pasien; @endphp

                            <p class="text-xs text-gray-500 font-semibold">NO.ERM</p>
                            <p class="text-base font-bold {{ $p->no_erm ? 'text-gray-900' : 'text-red-500' }} mb-2">
                                {{ $p->no_erm ?? 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold">NIK</p>
                            <p class="text-base font-bold {{ $p->nik ? 'text-gray-900' : 'text-red-500' }} mb-2">
                                {{ $p->nik ?? 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold">Nama Pasien</p>
                            <p class="text-base font-bold {{ $p->nama ? 'text-gray-900' : 'text-red-500' }} mb-2">
                                {{ $p->nama ?? 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold">Tanggal Lahir</p>
                            <p class="text-base font-bold {{ $p->tanggal_lahir ? 'text-gray-900' : 'text-red-500' }} mb-2">
                                {{ $p->tanggal_lahir
                    ? \Carbon\Carbon::parse($p->tanggal_lahir)->translatedFormat('d F Y')
                    : 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold">No WhatsApp</p>
                            <p class="text-base font-bold {{ $p->no_whatsapp ? 'text-green-500' : 'text-red-500' }} mb-4">
                                @if($p->no_whatsapp)
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', $p->no_whatsapp) }}" class="text-green-500"
                                        target="_blank" rel="noopener noreferrer">
                                        {{ $p->no_whatsapp }}
                                    </a>
                                @else
                                    Belum diisi
                                @endif
                            </p>

                            {{-- Perubahan di sini: Kondisi diganti menjadi $p->id atau $p && $p->id --}}
                            @if($p && $p->id)
                                <a href="{{ route('rekam-medis.hasil-uji.show', ['pasienId' => $p->id]) }}" {{-- Menggunakan $p->id --}}
                                    class="inline-block bg-pink-500 hover:bg-pink-600 text-white text-base font-semibold px-4 py-2
                                    rounded-lg transition w-full text-center">
                                    Detail
                                </a>
                            @else
                                <span class="text-xs italic text-red-500">Pasien Tidak Ditemukan</span> {{-- Ubah pesan --}}
                            @endif
                        </div>
                @empty
                    <p class="text-center text-gray-500">Tidak ada data pasien.</p>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div id="pagination-container" class="w-full border-t border-gray-200 pt-4 mt">
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

                        @if ($hasilUjiList->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $hasilUjiList->previousPageUrl() . '&search=' . request('search') }}"
                                class="join-item btn btn-sm">&laquo;</a>
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            <a href="{{ $hasilUjiList->url($page) . '&search=' . request('search') }}"
                                class="join-item btn btn-sm {{ $page == $current ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                                {{ $page }}
                            </a>
                        @endfor

                        @if ($hasilUjiList->hasMorePages())
                            <a href="{{ $hasilUjiList->nextPageUrl() . '&search=' . request('search') }}"
                                class="join-item btn btn-sm">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled text-gray-400">&raquo;</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/pages/rekam_medis/hasil_uji.js')
@endsection