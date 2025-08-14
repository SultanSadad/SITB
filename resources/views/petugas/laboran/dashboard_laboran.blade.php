{{--
// Nama File = dashboard_laboran.blade.php
// Deskripsi = Halaman dashboard untuk Laboran, menampilkan statistik total, hasil uji hari ini, hasil uji total, total
pasien, dan tabel hasil uji hari ini.
// Dibuat oleh = Sultan Sadad - NIM: 3312301102
// Tanggal = 25 April 2025
--}}

@extends('layout.laboran')
@section('content')
    {{-- Bagian konten dashboard Laboran --}}

    <div class="px-6 mt-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-2">
            <h2 class="text-2xl font-semibold">Dashboard Laboran</h2>
        </div>
        <div class="bg-white rounded-xl border-0 overflow-hidden mb-6">
            <!-- Header Section dengan Background Gradient Biru -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-xl text-white">Statistik Hasil Uji Tahun {{ date('Y') }}</h3>

                </div>
            </div>

            <!-- Chart Section with Padding -->
            <div class="p-6">
                <div class="h-72 bg-white rounded-lg">
                    <canvas id="yearlyChart" data-months='@json($chartLabels)' data-stats='@json($yearlyStats)'
                        data-current-year="{{ date('Y') }}" class="w-full h-full"></canvas>
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

        <!-- Stats -->
        <!-- Dashboard Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            <!-- Card 1 - Total Pasien -->
            <a href="{{ route('laboran.pasien.index') }}" class="block">
                <div
                    class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow transition duration-300 hover:bg-purple-50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
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

            <!-- Card 2 - Total Hasil Uji -->
            <a href="{{ route('laboran.hasil-uji.riwayat') }}" class="block">
                <div
                    class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow transition duration-300 hover:bg-purple-50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
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

            <!-- Card 3 - Hasil Uji Hari Ini -->
            <a href="{{ route('laboran.hasil-uji.riwayat') }}" class="block">
                <div
                    class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 hover:shadow transition duration-300 hover:bg-purple-50">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
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

        <!-- TABEL HASIL UJI HARI INI -->
        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-100 mb-6">
            <div class="flex justify-between items-center mb-3">
                <h3 class="font-semibold text-base text-gray-800">Hasil Uji Hari Ini</h3>

            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600" id="dataTable">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 rounded-t-lg">
                        <tr>
                            <th class="px-4 py-2.5 font-medium">No</th>
                            <th class="px-4 py-2.5 font-medium">Nama Pasien</th>
                            <th class="px-4 py-2.5 font-medium">NIK</th>

                            <th class="px-4 py-2.5 font-medium">Jam Upload</th>
                            <th class="px-4 py-2.5 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($todayResults as $index => $result)
                            <tr class="bg-white hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-700">{{ $loop->iteration }}</td>
                                <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-700">{{ $result->pasien->nama }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-gray-600">{{ $result->pasien->nik }}</td>

                                <td class="px-4 py-3 whitespace-nowrap text-gray-600">
                                    {{ \Carbon\Carbon::parse($result->created_at)->setTimezone('Asia/Jakarta')->format('H:i') }}
                                    WIB
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <a href="{{ asset('storage/' . $result->file) }}" target="_blank"
                                        class="inline-flex items-center justify-center px-2.5 py-1 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 transition-colors duration-200">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-10 h-10 mb-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="font-medium">Tidak ada hasil uji yang diupload hari ini</p>
                                        <p class="text-sm mt-1">Data baru akan muncul di sini setelah hasil uji diinput</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Enhanced Pagination -->
            @if($todayResults->hasPages())
                <div class="flex justify-center mt-8 border-t border-gray-200 pt-4">
                    <div class="join text-sm">
                        {{-- Tombol Sebelumnya --}}
                        @if ($todayResults->onFirstPage())
                            <button class="join-item btn btn-sm btn-disabled">&laquo;</button>
                        @else
                            <a href="{{ $todayResults->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
                        @endif

                        {{-- Nomor Halaman --}}
                        @php
                            $current = $todayResults->currentPage();
                            $last = $todayResults->lastPage();
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
                            <a href="{{ $todayResults->url(1) }}" class="join-item btn btn-sm">1</a>
                            @if ($start > 2)
                                <button class="join-item btn btn-sm btn-disabled">...</button>
                            @endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $todayResults->url($i) }}"
                                class="join-item btn btn-sm {{ $i == $current ? 'bg-blue-100 text-blue-600' : '' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <button class="join-item btn btn-sm btn-disabled">...</button>
                            @endif
                            <a href="{{ $todayResults->url($last) }}" class="join-item btn btn-sm">{{ $last }}</a>
                        @endif

                        {{-- Tombol Berikutnya --}}
                        @if ($todayResults->hasMorePages())
                            <a href="{{ $todayResults->nextPageUrl() }}" class="join-item btn btn-sm">&raquo;</a>
                        @else
                            <button class="join-item btn btn-sm btn-disabled">&raquo;</button>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>



    <script>
        // =========================
        // DATA & FUNGSI UTAMA
        // =========================

        // Nama-nama bulan yang digunakan sebagai label X-axis chart
        const monthNames = {!! json_encode($chartLabels) !!};

        // Data hasil uji per tahun (berupa objek {tahun: [data tiap bulan]})
        const yearlyData = {!! json_encode($yearlyStats) !!};

        // Fungsi untuk mengupdate ringkasan total, rata-rata, dan bulan puncak
        function updateSummary(selectedYear) {
            const data = yearlyData[selectedYear];
            const total = data.reduce((sum, value) => sum + value, 0); // Total semua bulan
            const avg = Math.round(total / data.length); // Rata-rata bulanan

            let maxValue = 0;
            let maxMonthIndex = 0;

            // Cari bulan dengan nilai tertinggi
            data.forEach((value, index) => {
                if (value > maxValue) {
                    maxValue = value;
                    maxMonthIndex = index;
                }
            });

            // Tampilkan hasil ringkasan ke elemen UI
            document.getElementById('totalTests').textContent = total.toLocaleString();
            document.getElementById('avgTests').textContent = avg.toLocaleString();
            document.getElementById('peakMonth').textContent = monthNames[maxMonthIndex];
        }

        // =========================
        // KONFIGURASI CHART
        // =========================

        const yearlyChartCtx = document.getElementById('yearlyChart').getContext('2d');

        // Buat gradient biru sebagai background chart
        const gradient = yearlyChartCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.8)');
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.1)');

        // Inisialisasi Chart.js line chart
        const yearlyChart = new Chart(yearlyChartCtx, {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Jumlah Hasil Uji',
                    data: yearlyData[{{ date('Y') }}], // Data tahun sekarang
                    backgroundColor: gradient,
                    borderColor: 'rgba(37, 99, 235, 1)', // Warna garis
                    borderWidth: 2,
                    pointBackgroundColor: 'rgba(37, 99, 235, 1)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.3, // Kelengkungan garis
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: { family: "'Poppins', sans-serif" }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)' // Garis grid vertikal samar
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { family: "'Poppins', sans-serif" } }
                    }
                },
                plugins: {
                    legend: { display: false }, // Sembunyikan label legend
                    tooltip: {
                        backgroundColor: 'rgba(30, 58, 138, 0.8)',
                        titleFont: { family: "'Poppins', sans-serif", size: 14 },
                        bodyFont: { family: "'Poppins', sans-serif", size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function (context) {
                                return context.dataset.label + ': ' + context.raw.toLocaleString() + ' hasil uji';
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                hover: {
                    mode: 'index',
                    intersect: false
                }
            }
        });

        // =========================
        // INISIALISASI & EVENT
        // =========================

        // Jalankan ringkasan awal saat halaman dimuat (tahun sekarang)
        updateSummary({{ date('Y') }});

        // Event ketika tahun diganti dari dropdown
        document.getElementById('yearSelector').addEventListener('change', function () {
            const selectedYear = this.value;

            // Update data chart & ringkasan sesuai tahun yang dipilih
            yearlyChart.data.datasets[0].data = yearlyData[selectedYear];
            yearlyChart.update();
            updateSummary(selectedYear);
        });
    </script>
@endsection
@push('scripts')
    {{-- Hubungkan file JS melalui Vite --}}
    @vite('resources/js/pages/laboran/dashboard.js')
@endpush