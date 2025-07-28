{{-- resources/views/laboran/dashboard_laboran.blade.php --}}
@extends('layout.laboran')

@section('title', 'Dashboard Laboran')

@section('content')
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard Laboran</h1>

        {{-- Statistik jumlah hasil uji tiap bulan (grafik) --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Statistik Hasil Uji per Bulan</h2>
            <div class="relative h-72">
                <canvas id="yearlyChart" data-months='@json($chartLabels)' data-stats='@json($yearlyStats)'>
                </canvas>
            </div>
        </div>

        {{-- Informasi lainnya bisa ditambahkan di sini --}}
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Informasi Tambahan</h2>
            <p>Selamat datang di dashboard Laboran. Silakan gunakan menu di samping untuk mengelola data hasil uji.</p>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Hubungkan file JS melalui Vite --}}
    @vite('resources/js/pages/laboran/dashboard.js')
@endpush