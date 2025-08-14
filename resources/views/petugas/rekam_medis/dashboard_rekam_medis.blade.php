{{-- resources/views/petugas/rekam_medis/dashboard_rekam_medis.blade.php --}}
@extends('layout.rekam_medis')

@section('rekam_medis')
  <div class="px-6 mt-4">
    <div class="flex justify-between items-center mb-2">
    <h2 class="text-2xl font-semibold">Dashboard Rekam Medis</h2>
    </div>

    <div class="bg-white rounded-xl border-0 overflow-hidden mb-6">
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
      <div class="flex justify-between items-center">
      <h3 class="font-bold text-xl text-white">Statistik Hasil Uji Tahun {{ date('Y') }}</h3>
      </div>
    </div>

    <div class="p-6">
      <div class="h-72 bg-white rounded-lg">
      <canvas id="yearlyChart" data-labels='@json($chartLabels)' data-stats='@json($yearlyStats)'
        class="w-full h-full"></canvas>
      </div>

      <div class="grid grid-cols-3 gap-4 mt-4">
      <div class="bg-blue-50 rounded-lg p-3 text-center">
        <p class="text-sm text-gray-500">Total Tahun Ini</p>
        <p class="text-xl font-bold text-blue-600" id="totalTests">0</p>
      </div>
      <div class="bg-blue-50 rounded-lg p-3 text-center">
        <p class="text-sm text-gray-500">Rata-rata Bulanan</p>
        <p class="text-xl font-bold text-blue-600" id="avgTests">0</p>
      </div>
      <div class="bg-blue-50 rounded-lg p-3 text-center">
        <p class="text-sm text-gray-500">Bulan Tertinggi</p>
        <p class="text-xl font-bold text-blue-600" id="peakMonth">-</p>
      </div>
      </div>
    </div>
    </div>

    {{-- Cards ringkas (match laboran) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
    <a href="{{ route('rekam-medis.pasien.index') }}" class="block">
      <div
      class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow transition duration-300 hover:bg-purple-50">
      <div class="flex items-center space-x-3">
        <div class="p-2 bg-purple-100 rounded-lg">
        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        </div>
        <div>
        <p class="text-gray-500 text-xs font-medium">Total Pasien</p>
        <h2 class="text-xl font-bold text-gray-800">{{ $totalPatients }}</h2>
        </div>
      </div>
      </div>
    </a>

    <a href="{{ route('rekam-medis.hasil-uji.data') }}" class="block">
      <div
      class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow transition duration-300 hover:bg-purple-50">
      <div class="flex items-center space-x-3">
        <div class="p-2 bg-blue-100 rounded-lg">
        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        </div>
        <div>
        <p class="text-gray-500 text-xs font-medium">Total Hasil Uji</p>
        <h2 class="text-xl font-bold text-gray-800">{{ $totalTests }}</h2>
        </div>
      </div>
      </div>
    </a>

    <a href="{{ route('rekam-medis.hasil-uji.data') }}" class="block">
      <div
      class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow transition duration-300 hover:bg-purple-50">
      <div class="flex items-center space-x-3">
        <div class="p-2 bg-green-100 rounded-lg">
        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
          d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        </div>
        <div>
        <p class="text-gray-500 text-xs font-medium">Hasil Uji Hari Ini</p>
        <h2 class="text-xl font-bold text-gray-800">{{ $todayResultsCount }}</h2>
        </div>
      </div>
      </div>
    </a>
    </div>

    {{-- Tabel hasil uji hari ini --}}
    @include('petugas.rekam_medis.partials.partial_hasil_uji_hari_ini')
  </div>

  @push('scripts')
    @php $rmDash = Vite::asset('resources/js/pages/rekam_medis/dashboard.js'); @endphp
    <script type="module" src="{{ $rmDash }}" nonce="{{ $nonce }}"></script>
  @endpush

@endsection