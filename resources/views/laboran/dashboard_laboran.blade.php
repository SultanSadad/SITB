@extends('layout.laboran')
@section('laboran')

  <div class="p-6 bg-gray-100">
    <!-- Header -->
    <div class="flex justify-between items-center mb-2">
    <h1 class="text-1xl font-semibold font-neutral">DASHBOARD LABORAN</h1>
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
    <a href="/laboran/DataHasilUji" class="block">
      <div class="bg-white p-4 rounded-xl shadow-sm">
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
    <h2 class="text-1xl font-semibold mb-2">HASIL UJI HARI INI</h2>
    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm p-6">
    <div class="overflow-x-auto">
      <table class="w-full text-base text-left text-gray-600" id="dataTable">
      <thead class="text-xs text-gray-500 uppercase bg-gray-50">
        <tr>
        <th class="px-6 py-3">No</th>
        <th class="px-6 py-3">Nama Pasien</th>
        <th class="px-6 py-3">NIK</th>
        <th class="px-6 py-3">Jam Upload</th>
        <th class="px-6 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($todayResults as $index => $result)
      <tr class="bg-white border-b text-sm">
      <td class="px-6 py-3">{{ $index + 1 }}</td>
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