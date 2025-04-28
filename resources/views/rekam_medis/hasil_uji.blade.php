@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Hasil Uji TB</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-between items-center mb-4">
    <!-- Input Pencarian -->
    <form action="{{ url('/rekam_medis/hasil_uji') }}" method="GET" class="relative w-1/3">
        <input type="text" name="search" placeholder="Cari Pasien"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10"
            value="{{ request('search') }}">
        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
    </form>
</div>

            <div class="overflow-x-auto">
    <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
            <tr>
                <th class="px-6 py-3">Nama Pasien</th>
                <th class="px-6 py-3">Tanggal Uji TB</th>
                <th class="px-6 py-3">Tanggal Upload TB</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">File</th>
            </tr>
        </thead>
        <tbody>
            @forelse($hasilUjiList as $hasil)
                <tr class="bg-white border-b">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $hasil->pasien->nama }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($hasil->tanggal_uji)->format('d F Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($hasil->tanggal_upload)->format('d F Y') }}</td>
                    <td class="px-6 py-4">
                        @if($hasil->status == 'Positif')
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-semibold">Positif</span>
                        @else
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">Negatif</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ asset('storage/' . $hasil->file) }}" target="_blank"
                            class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-semibold">
                            Cetak Hasil
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="bg-white border-b">
                    <td colspan="5" class="px-6 py-4 text-center">Tidak ada data hasil uji</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="flex justify-center mt-6">
    <nav aria-label="Page navigation">
        <ul class="inline-flex items-center -space-x-px text-sm">
            {{-- Previous Page --}}
            @if ($hasilUjiList->onFirstPage())
                <li>
                    <span class="px-3 py-2 ml-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
                        &lt;
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $hasilUjiList->previousPageUrl() }}"
                        class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                        &lt;
                    </a>
                </li>
            @endif

            {{-- Page Numbers --}}
            @foreach ($hasilUjiList->getUrlRange(1, $hasilUjiList->lastPage()) as $page => $url)
                <li>
                    <a href="{{ $url }}"
                        class="px-3 py-2 leading-tight {{ $page == $hasilUjiList->currentPage() ? 'text-blue-600 bg-blue-50 border border-gray-300' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                        {{ $page }}
                    </a>
                </li>
            @endforeach

            {{-- Next Page --}}
            @if ($hasilUjiList->hasMorePages())
                <li>
                    <a href="{{ $hasilUjiList->nextPageUrl() }}"
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
@endsection