@extends('layout.rekam_medis')

@section('title', 'Dashboard Rekam Medis')

@section('rekam_medis')

  <div class="p-6 bg-gray-100">
    <!-- Header -->
    <div class="flex justify-between items-center mb-2">
    <h1 class="text-1xl font-semibold font-neutral">DASHBOARD REKAM MEDIS</h1>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <!-- Card 1 - Total Pasien -->
    <div class="bg-white p-4 rounded-xl shadow-sm">
      <div class="flex items-center space-x-4">
      <div class="p-2 bg-purple-100 rounded-md">
        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2h8zM16 14a4 4 0 010-8 4 4 0 010 8z" />
        </svg>
      </div>
      <div>
        <p class="text-gray-500 text-sm">Total Pasien</p>
        <h2 class="text-xl font-bold">{{ $totalPatients }}</h2>
      </div>
      </div>
    </div>

    <!-- Card 2 - Total Hasil Uji -->
    <a href="{{ route('rekam-medis.datahasiluji') }}" class="block">
      <div class="bg-white p-4 rounded-xl shadow-sm hover:bg-gray-50 transition">
      <div class="flex items-center space-x-4">
        <div class="p-2 bg-purple-100 rounded-md">
        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 12h6m2 6H7a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v10a2 2 0 01-2 2z" />
        </svg>
        </div>
        <div>
        <p class="text-gray-500 text-sm">Total Hasil Uji</p>
        <h2 class="text-xl font-bold">{{ $totalTests }}</h2>
        </div>
      </div>
      </div>
    </a>

    <!-- Card 3 - Hasil Uji Hari Ini -->
    <div class="bg-white p-4 rounded-xl shadow-sm">
      <div class="flex items-center space-x-4">
      <div class="p-2 bg-purple-100 rounded-md">
        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5V4H2v16h5m10 0V10m0 10l-4-4m4 4l4-4" />
        </svg>
      </div>
      <div>
        <p class="text-gray-500 text-sm">Hasil Uji Hari Ini</p>
        <h2 class="text-xl font-bold">{{ $todayResultsCount }}</h2>
      </div>
      </div>
    </div>
    </div>

    <!-- Section Judul Tabel -->
    <div class="mt-6 mb-2">
    <h2 class="text-1xl font-semibold">HASIL UJI HARI INI</h2>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm p-6">
    <div class="overflow-x-auto">
      <table class="w-full text-base text-left text-gray-600" id="dataTable">
      <thead class="text-xs text-gray-500 uppercase bg-gray-50">
        <tr>
        <th class="px-6 py-3">Nama Pasien</th>
        <th class="px-6 py-3">NIK</th>
        <th class="px-6 py-3">Jam Upload</th>
        <th class="px-6 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($todayResults as $index => $result)
      <tr class="bg-white border-b text-sm">
      <td class="px-6 py-3">{{ $result->pasien->nama }}</td>
      <td class="px-6 py-3">{{ $result->pasien->nik }}</td>
      <td class="px-6 py-3">
        {{ \Carbon\Carbon::parse($result->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }} WIB
      </td>
      <td class="px-6 py-3">
        <a href="{{ asset('storage/' . $result->file) }}" target="_blank"
        class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
        <i class="fas fa-file-alt"></i> Lihat
        </a>
      </td>
      </tr>
      @empty
      <tr>
      <td colspan="6" class="px-6 py-3 text-center">Tidak ada hasil uji yang diupload hari ini</td>
      </tr>
      @endforelse
      </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center mt-6">
      <nav aria-label="Page navigation">
      <ul class="inline-flex items-center -space-x-px text-sm">
        {{-- Previous --}}
        @if ($todayResults->onFirstPage())
      <li>
      <span
        class="px-3 py-2 ml-0 leading-tight text-gray-400 bg-white border border-gray-300 rounded-l-lg cursor-not-allowed">
        &lt;
      </span>
      </li>
      @else
      <li>
      <a href="{{ $todayResults->previousPageUrl() }}"
        class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
        &lt;
      </a>
      </li>
      @endif

        {{-- Page Numbers --}}
        @foreach ($todayResults->getUrlRange(1, $todayResults->lastPage()) as $page => $url)
      <li>
      <a href="{{ $url }}"
        class="px-3 py-2 leading-tight {{ $page == $todayResults->currentPage() ? 'text-blue-600 bg-blue-50 border border-gray-300' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
        {{ $page }}
      </a>
      </li>
      @endforeach

        {{-- Next --}}
        @if ($todayResults->hasMorePages())
      <li>
      <a href="{{ $todayResults->nextPageUrl() }}"
        class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
        &gt;
      </a>
      </li>
      @else
      <li>
      <span
        class="px-3 py-2 leading-tight text-gray-400 bg-white border border-gray-300 rounded-r-lg cursor-not-allowed">
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

@section('scripts')
  <script>
    $(document).ready(function () {
    $('#dataTable').DataTable();
    });
  </script>
@endsection