{{-- Nama File   = hasil_uji.blade.php --}}
{{-- Deskripsi   = Hasil Uji Rekam medis --}}
{{-- Dibuat oleh = Saskia Nadira - 3312301031 --}}
{{-- Tanggal     = 10 April 2025 --}}


{{-- Nama File   = [Berbagai file views] --}}
{{-- Deskripsi   = Perbaiki Pagination --}}
{{-- Dibuat oleh = Hafivah Tahta Rasyida - 3312301100 --}}
{{-- Tanggal     = 16 April 2025 --}}


@extends('layout.laboran')
<title>Hasil Uji Laboratorium</title>
@section('laboran')
    <div class="px-6 mt-2">
        <h1 class="font-bold text-2xl mb-4">Hasil Uji Laboratorium</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6">
                <form action="{{ url('/laboran/hasil-uji') }}" method="GET" class="w-60">
                    <div class="relative flex">
                        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>

            </div>

            {{-- Table View (Desktop & Tablet) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="min-w-full text-sm text-left text-gray-700 divide-y divide-gray-200">
                    <thead class="bg-gray-100 uppercase text-xs font-semibold text-gray-700 tracking-wide">
                        <tr>
                            <th class="px-6 py-3">NO.ERM</th>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">Nama</th>
                            <th class="px-6 py-3">Tanggal Lahir</th>
                            <th class="px-6 py-3">No WA</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        @forelse ($pasiens as $pasien)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    {{ $pasien->no_erm ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    @if ($pasien->nik)
                                        {{ $pasien->nik }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    {{ $pasien->nama ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    @if ($pasien->tanggal_lahir)
                                        {{ \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d-  m-Y') }}
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium">
                                    @if ($pasien->no_whatsapp)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pasien->no_whatsapp) }}"
                                            target="_blank" class="text-green-600 hover:underline hover:text-green-700 transition">
                                            {{ $pasien->no_whatsapp }}
                                        </a>
                                    @else
                                        <span class="text-red-500">belum diisi</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('laboran.hasil-uji.show', ['pasienId' => $pasien->id]) }}"
                                        class="inline-block bg-pink-500 hover:bg-pink-600 text-white text-xs font-medium px-3 py-1 rounded transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                    Tidak ada data pasien yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- Card View (Mobile) --}}
            <div class="md:hidden space-y-4 mt-6">
                @forelse ($pasiens as $pasien)
                        <div class="bg-white border border-gray-200 rounded-xl shadow p-4">
                            <p class="text-xs text-gray-500 font-semibold">Nomor ERM</p>
                            <p class="text-base font-bold mb-2 {{ $pasien->no_erm ? 'text-gray-900' : 'text-red-500' }}">
                                {{ $pasien->no_erm ?? 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold mt-2">NIK</p>
                            <p class="text-base font-bold mb-2 {{ $pasien->nik ? 'text-gray-900' : 'text-red-500' }}">
                                {{ $pasien->nik ?? 'Belum diisi' }}
                            </p>
                            <p class="text-xs text-gray-500 font-semibold mt-2">Nama Pasien</p>
                            <p class="text-base font-bold mb-2 {{ $pasien->nama ? 'text-gray-900' : 'text-red-500' }}">
                                {{ $pasien->nama ?? 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold mt-2">Tanggal Lahir</p>
                            <p class="text-base font-bold mb-2 {{ $pasien->tanggal_lahir ? 'text-gray-900' : 'text-red-500' }}">
                                {{ $pasien->tanggal_lahir
                    ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d F Y')
                    : 'Belum diisi' }}
                            </p>

                            <p class="text-xs text-gray-500 font-semibold mt-2">No HP</p>
                            <p class="text-base font-bold mb-4 {{ $pasien->no_whatsapp ? 'text-gray-900' : 'text-red-500' }}">
                                {{ $pasien->no_whatsapp ?? 'Belum diisi' }}
                            </p>

                            <a href="{{ route('laboran.hasil-uji.show', ['pasienId' => $pasien->id]) }}"
                                style="background-color: #E650BE;"
                                class="text-white px-4 py-2 rounded text-sm font-semibold text-center w-full block transition hover:opacity-90">
                                Detail
                            </a>
                        </div>
                @empty
                    <p class="text-gray-500 text-center">Tidak ada data pasien yang ditemukan.</p>
                @endforelse
            </div>
            <div class="flex justify-center mt-2 border-t border-gray-200 pt-2">
                <div class="mt-2">
                    <div class="join text-sm">
                        {{-- Tombol Sebelumnya --}}
                        @if ($pasiens->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled">&laquo;</button>
                        @else
                            <a href="{{ $pasiens->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
                        @endif

                        {{-- Nomor Halaman --}}
                        @php
                            $current = $pasiens->currentPage();
                            $last = $pasiens->lastPage();
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
                            <a href="{{ $pasiens->url(1) }}" class="join-item btn btn-sm">1</a>
                            @if ($start > 2)
                                <button class="join-item btn btn-sm btn-disabled">...</button>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $pasiens->url($i) }}"
                                class="join-item btn btn-sm {{ $i == $current ? 'bg-blue-100 text-blue-600' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <button class="join-item btn btn-sm btn-disabled">...</button>
                            @endif
                            <a href="{{ $pasiens->url($last) }}" class="join-item btn btn-sm">{{ $last }}</a>
                        @endif

                        {{-- Tombol Berikutnya --}}
                        @if ($pasiens->hasMorePages())
                            <a href="{{ $pasiens->nextPageUrl() }}" class="join-item btn btn-sm">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled">&raquo;</button>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-pasien'); // Ambil input pencarian
            let timeoutId; // Untuk menyimpan ID timeout terakhir

            searchInput.addEventListener('input', function () {
                clearTimeout(timeoutId); // Hapus timeout sebelumnya agar tidak dobel
                const query = this.value.trim(); // Ambil teks input dan hapus spasi

                // Set delay agar tidak terlalu banyak request saat user sedang mengetik
                timeoutId = setTimeout(() => {
                    // Submit form (GET) setelah user berhenti mengetik selama 300ms
                    this.closest('form').submit(); // Kirim form ke URL action (refresh data)
                }, 300); // Delay 300ms
            });=
        });
    </script>

@endsection