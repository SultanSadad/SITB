@extends('layout.laboran')
@section('laboran')
    <div class="container px-4 py-6 mx-auto">
        <!-- Header Section -->
        <div class="mb-6">
            <h2 class="text-2xl font-semibold">Data Hasil Laboratorium</h2>
            <p class="text-gray-500 mt-1">Ini adalah daftar hasil uji</p>
        </div>

        <!-- Filters and Search Row -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <!-- Search Form -->
            <form action="{{ url('/laboran/DataHasilUji') }}" method="GET"
                class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4 w-full">
                <!-- Search -->
                <div class="relative w-full md:w-1/3">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" name="search"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5"
                        placeholder="Cari Nama Pasien" value="{{ request('search') }}">
                </div>

                <!-- Date Filters -->
                <div class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 ..." />
                            </svg>
                        </div>
                        <input id="datepicker-range-start" name="start" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 pl-10 p-2.5"
                            value="{{ request('start') }}" placeholder="Dari">
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 ..." />
                            </svg>
                        </div>
                        <input id="datepicker-range-end" name="end" type="date"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 pl-10 p-2.5"
                            value="{{ request('end') }}" placeholder="Ke">
                    </div>

                    <!-- Buttons -->
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>

                    <a href="{{ url('/laboran/DataHasilUji') }}"
                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-200">
                        <i class="fas fa-sync mr-1"></i> Reset
                    </a>
                </div>
            </form>

        </div>

        <!-- Status Alert -->
        @if(session('success'))
            <div id="alert-border-3" class="flex p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50" role="alert">
                <svg class="flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
                <div class="ml-3 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button"
                    class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex h-8 w-8"
                    data-dismiss-target="#alert-border-3" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Table Section -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 ">No</th>
                        <th scope="col" class="px-6 py-3 ">NIK</th>
                        <th scope="col" class="px-6 py-3 ">Nama</th>
                        <th scope="col" class="px-6 py-3 ">Tanggal Upload</th>
                        <th scope="col" class="px-6 py-3 ">No HP</th>
                        <th scope="col" class="px-6 py-3 ">Tanggal Uji</th>
                        <th scope="col" class="px-6 py-3 ">Hasil Uji</th>
                        <th scope="col" class="px-6 py-3 ">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($hasilUjiList as $index => $hasil)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <td class="px-6 py-4 ">{{ $hasilUjiList->firstItem() + $index }}</td>
                            <td class="px-6 py-4 ">{{ $hasil->pasien->nik ?? 'N/A' }}</td>
                            <td class="px-6 py-4 ">{{ $hasil->pasien->nama ?? 'N/A' }}</td>
                            <td class="px-6 py-4 ">
                                {{ $hasil->tanggal_upload ? date('d-m-Y', strtotime($hasil->tanggal_upload)) : 'N/A' }}</td>
                            <td class="px-6 py-4 ">{{ $hasil->pasien->no_whatsapp ?? 'N/A' }}</td>
                            <td class="px-6 py-4 ">{{ date('d-m-Y', strtotime($hasil->tanggal_uji)) }}</td>
                            <td class="px-6 py-4 ">
                                @if($hasil->file)
                                    <a href="{{ asset('storage/' . $hasil->file) }}"
                                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-1.5  inline-flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-download mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400">Tidak ada file</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 flex space-x-2">
    <form action="{{ route('hasil-uji.destroy', $hasil->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
        @csrf
        @method('DELETE')
        <button type="submit"
            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
            <i class="fa-solid fa-trash"></i> Hapus
        </button>
    </form>
</td>

                        </tr>
                    @empty
                        <tr class="bg-white">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data hasil laboratorium</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-center mt-4">
            {{ $hasilUjiList->appends(request()->query())->links() }}
        </div>
    </div>

    <!-- Include datepicker and other scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize date pickers
            const startDatePicker = flatpickr("#datepicker-range-start", {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function (selectedDates, dateStr) {
                    // Update the end date minimum
                    if (selectedDates[0]) {
                        endDatePicker.set('minDate', dateStr);
                    }
                }
            });

            const endDatePicker = flatpickr("#datepicker-range-end", {
                dateFormat: "Y-m-d",
                allowInput: true,
                onChange: function (selectedDates, dateStr) {
                    // Update the start date maximum
                    if (selectedDates[0]) {
                        startDatePicker.set('maxDate', dateStr);
                    }
                }
            });

            // Set initial values if they exist
            const startInput = document.getElementById('datepicker-range-start');
            const endInput = document.getElementById('datepicker-range-end');

            if (startInput.value) {
                endDatePicker.set('minDate', startInput.value);
            }

            if (endInput.value) {
                startDatePicker.set('maxDate', endInput.value);
            }

            // Alert dismiss functionality
            const dismissButtons = document.querySelectorAll('[data-dismiss-target]');
            dismissButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.getAttribute('data-dismiss-target');
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.classList.add('hidden');
                    }
                });
            });
        });
    </script>
@endsection