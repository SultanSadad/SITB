@extends('layout.laboran')

@section('laboran')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Hasil Uji Laboratorium</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <!-- Input Pencarian -->
                <form action="{{ url('/laboran/hasil-uji') }}" method="GET">
                    <div class="relative w-full">
                        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
        <th scope="col" class="px-6 py-3 ">Nomor ERM</th>
        <th scope="col" class="px-6 py-3 ">NIK</th>
        <th scope="col" class="px-6 py-3 ">Nama</th>
        <th scope="col" class="px-6 py-3 ">Tanggal Lahir</th>
        <th scope="col" class="px-6 py-3 ">No HP</th>
        <th scope="col" class="px-6 py-3 ">Aksi</th>
    </tr>
        </thead>
        <!-- views/laboran/hasil_uji.blade.php -->

        <tbody>
    @forelse ($pasiens as $pasien)
        <tr class="bg-white border-b">
            <td class="px-6 py-4 font-medium text-gray-900 ">{{ $pasien->no_erm ?? 'N/A' }}</td>
            <td class="px-6 py-4 ">{{ $pasien->nik ?? 'N/A' }}</td>
            <td class="px-6 py-4 ">{{ $pasien->nama }}</td>
            <td class="px-6 py-4 ">{{ $pasien->tanggal_lahir ? date('d-m-Y', strtotime($pasien->tanggal_lahir)) : 'N/A' }}</td>
            <td class="px-6 py-4 ">{{ $pasien->no_whatsapp ?? 'N/A' }}</td>
            <td class="px-6 py-4 ">
                <a href="{{ route('laboran.detail', ['pasienId' => $pasien->id]) }}"
                   style="background-color: #E650BE;"
                   class="text-white px-2 py-1 rounded text-xs font-regular">
                    Detail
                </a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6" class="px-6 py-4 text-center">Tidak ada data pasien</td>
        </tr>
    @endforelse
</tbody>
    </table>
</div>

<!-- Pagination -->
<div class="flex justify-center mt-6">
    <nav aria-label="Page navigation">
        <ul class="inline-flex items-center -space-x-px text-sm">
            {{-- Previous Page --}}
            @if ($pasiens->onFirstPage())
                <li>
                    <span class="px-3 py-2 ml-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                        &lt;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $pasiens->previousPageUrl() }}"
                        class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                        &lt;
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($pasiens->getUrlRange(1, $pasiens->lastPage()) as $page => $url)
                <li>
                    <a href="{{ $url }}"
                        class="px-3 py-2 leading-tight {{ $page == $pasiens->currentPage() ? 'text-blue-600 bg-blue-50 border border-gray-300' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                        {{ $page }}
                    </a>
                </li>
            @endforeach

            {{-- Next Page --}}
            @if ($pasiens->hasMorePages())
                <li>
                    <a href="{{ $pasiens->nextPageUrl() }}"
                        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                        &gt;
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 leading-tight text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
                        &gt;
                    </span>
                </li>
            @endif
        </ul>
    </nav>
</div>  
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-pasien');
            let timeoutId;

            searchInput.addEventListener('input', function () {
                clearTimeout(timeoutId);
                const query = this.value.trim();

                // Set delay untuk menghindari terlalu banyak request
                timeoutId = setTimeout(() => {
                    // Update URL agar bisa di-bookmark
                    const url = new URL(window.location);
                    if (query) {
                        url.searchParams.set('search', query);
                    } else {
                        url.searchParams.delete('search');
                    }
                    window.history.pushState({}, '', url);

                    // Fetch data dari server dengan query
                    fetch(`/rekam_medis/data_pasien?search=${encodeURIComponent(query)}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.text())
                        .then(html => {
                            // Update konten tabel dengan hasil pencarian
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');

                            // Sesuaikan selector ini dengan struktur tabel Anda
                            const tableContainer = document.querySelector('.table-container');
                            const newTableContainer = doc.querySelector('.table-container');

                            if (tableContainer && newTableContainer) {
                                tableContainer.innerHTML = newTableContainer.innerHTML;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }, 300);
            });
        });
    </script>
@endsection