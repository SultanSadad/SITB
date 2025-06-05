@extends('layout.rekam_medis')
<title>Hasil Uji Laboratorium</title>
@section('rekam_medis')

    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Hasil Uji Laboratorium</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="mb-6"> {{-- Hapus flex justify-between items-center karena hanya ada satu elemen --}}
                <form action="{{ url('/rekam-medis/hasil-uji') }}" method="GET" class="w-64"> {{-- Tambahkan w-full untuk
                    responsivitas --}}
                    <div class="relative w-full">
                        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien" {{-- Berikan hint
                            pencarian --}}
                            class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
            </div>
            {{-- Table View (Desktop & Tablet) --}}
            <div class="hidden md:block overflow-x-auto mt-6">
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
                    <tbody class="bg-white divide-y divide-gray-200">
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
                            ? \Carbon\Carbon::parse($hasil->pasien->tanggal_lahir)->translatedFormat('d F Y')
                            : 'Belum diisi' }}
                                            </td>
                                            <td
                                                class="px-6 py-4 font-medium {{ $hasil->pasien->no_whatsapp ? 'text-gray-900' : 'text-red-500' }}">
                                                {{ $hasil->pasien->no_whatsapp ?? 'Belum diisi' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('rekam-medis.detail', ['pasienId' => $hasil->pasien->id]) }}"
                                                    class="inline-block bg-pink-500 hover:bg-pink-600 text-white text-xs font-medium px-3 py-1 rounded transition">
                                                    Detail
                                                </a>
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
            <div class="md:hidden space-y-4 mt-6">
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
                            <p class="text-base font-bold {{ $p->no_whatsapp ? 'text-gray-900' : 'text-red-500' }} mb-4">
                                {{ $p->no_whatsapp ?? 'Belum diisi' }}
                            </p>

                            <a href="{{ route('rekam-medis.detail', ['pasienId' => $p->id]) }}"
                                class="bg-pink-600 hover:bg-pink-700 text-white px-4 py-2 rounded text-sm font-semibold text-center block transition">
                                Detail
                            </a>
                        </div>
                @empty
                    <p class="text-center text-gray-500">Tidak ada data pasien.</p>
                @endforelse
                {{-- Pagination --}}
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

                        @if ($hasilUjiList->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled text-gray-400">&laquo;</button>
                        @else
                            <a href="{{ $hasilUjiList->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
                        @endif

                        @for ($page = $start; $page <= $end; $page++)
                            <a href="{{ $hasilUjiList->url($page) }}"
                                class="join-item btn btn-sm {{ $page == $current ? 'bg-blue-100 text-blue-600 font-semibold' : 'hover:bg-gray-100 text-gray-700' }}">
                                {{ $page }}
                            </a>
                        @endfor

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
    <script>
    // Tunggu sampai semua elemen DOM selesai dimuat
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search-pasien'); // Ambil elemen input pencarian
        let timeoutId; // ID untuk mengatur delay (debounce)

        // Event saat pengguna mengetik di input pencarian
        searchInput.addEventListener('input', function () {
            clearTimeout(timeoutId); // Reset timer sebelumnya agar tidak terlalu sering fetch
            const query = this.value.trim(); // Ambil dan bersihkan nilai input

            // Beri jeda sebelum mengirim request (debounce 300ms)
            timeoutId = setTimeout(() => {
                // Buat URL baru dengan query pencarian
                const url = new URL(window.location);
                if (query) {
                    url.searchParams.set('search', query); // Tambah parameter 'search'
                } else {
                    url.searchParams.delete('search'); // Hapus parameter jika input kosong
                }
                window.history.pushState({}, '', url); // Perbarui URL di browser tanpa reload

                // Kirim permintaan AJAX ke server dengan parameter search
                fetch(`/rekam_medis/data_pasien?search=${encodeURIComponent(query)}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Tandai sebagai request AJAX
                    }
                })
                    .then(response => response.text()) // Ambil respons dalam bentuk HTML
                    .then(html => {
                        // Parse HTML respon menjadi dokumen DOM
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        // Ambil container tabel lama dan hasil baru dari respon
                        const tableContainer = document.querySelector('.table-container');
                        const newTableContainer = doc.querySelector('.table-container');

                        // Ganti isi tabel lama dengan yang baru jika keduanya ditemukan
                        if (tableContainer && newTableContainer) {
                            tableContainer.innerHTML = newTableContainer.innerHTML;
                        }
                    })
                    .catch(error => {
                        // Tangani error jika fetch gagal
                        console.error('Error:', error);
                    });
            }, 300); // Delay 300ms agar tidak fetch setiap ketik karakter
        });
    });
</script>

@endsection