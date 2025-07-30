{{--
// Nama File = dashboard_rekam_medis.blade.php
// Deskripsi = Halaman dashboard untuk Staf Rekam Medis, menampilkan statistik total, hasil uji hari ini, hasil uji
total, total pasien, dan tabel hasil uji hari ini.
// Dibuat oleh = Sultan Sadad - NIM: 3312301102
// Tanggal = 25 April 2025
--}}

@extends('layout.rekam_medis')
@section('rekam_medis')
    <div class="px-6 mt-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-2xl font-semibold">Dashboard Rekam Medis</h2>
        </div>
        <div class="bg-white rounded-xl border-0  mb-6">
            <!-- Header Section dengan Background Gradient Biru -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4 rounded-t-lg">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-xl text-white">Statistik Hasil Uji Tahun {{ date('Y') }}</h3>
                </div>
            </div>
            <!-- Chart Section with Padding -->
            <div class="p-6">
                <div class="h-72 bg-white rounded-lg">
                    <canvas id="yearlyChart"></canvas>
                </div>

                <!-- Data Summary Cards - Semua dengan Tema Biru -->
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

        <!-- Data Table hasil uji hari ini -->
        @include('petugas.rekam_medis.partials.partial_hasil_uji_hari_ini')

    </div>

    {{-- Inject chartLabels dan yearlyStats ke JS global window --}}
    <script nonce="{{ $nonce }}">
        window.chartLabels = @json($chartLabels);
        window.yearlyStats = @json($yearlyStats);
    </script>

    {{-- ChartJS CDN + Vite compiled JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/js/pages/rekam_medis/dashboard.js')
@endsection