@extends('layout.pasien')

@section('pasien')

    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 px-5 py-6">
        <!-- Welcome Header with Animation -->
        <div class="mb-8 text-center relative">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-3xl opacity-10"></div>
    <div class="relative py-8 px-6">
        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
            Selamat Datang, {{ Auth::guard('pasien')->user()->nama }}
        </h1>
        <p class="text-gray-600 text-lg">Sistem Informasi Hasil Uji Laboratorium</p>
        <div class="mt-4 flex justify-center">
            <div class="w-20 h-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full"></div>
        </div>
    </div>
</div>

        
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-8 border border-blue-100 ">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 pb-4 border-b border-gray-200">
        <div class="flex items-center space-x-3 mb-4 sm:mb-0">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2 class="text-xl md:text-2xl font-bold text-gray-800">Data Diri Pasien</h2>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
        <div class="space-y-4">
            <div class="group rounded-lg p-4 transition-all duration-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-4 0V5a2 2 0 014 0v1"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Nomor Induk Kependudukan</p>
                        <p class="text-base md:text-lg font-semibold text-gray-800">{{ $pasien->nik }}</p>
                    </div>
                </div>
            </div>

            <div class="group  rounded-lg p-4 transition-all duration-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center ">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Nama Lengkap</p>
                        <p class="text-base md:text-lg font-semibold text-gray-800">{{ $pasien->nama }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="group  rounded-lg p-4 transition-all duration-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center ">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Nomor Telepon</p>
                        <p class="text-base md:text-lg font-semibold text-gray-800">{{ $pasien->no_whatsapp }}</p>
                    </div>
                </div>
            </div>

            <div class="group rounded-lg p-4 transition-all duration-200">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center ">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Nomor Rekam Medis</p>
                        <p class="text-base md:text-lg font-semibold text-gray-800">{{ $pasien->no_erm }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

        <!-- Video Tutorial Section with Enhanced Design -->
        <div class="bg-white rounded-2xl shadow-xl p-8 border border-blue-100 transition-all duration-300">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                <div class="flex items-center space-x-3">

                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Panduan Penggunaan Sistem</h2>
                        <p class="text-gray-600">Tutorial lengkap sistem informasi hasil laboratorium</p>
                    </div>
                </div>
                
            </div>

            <!-- Video Container with Improved Styling -->
            <div class="relative group">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl opacity-20"></div>
                <div class="relative bg-black rounded-2xl overflow-hidden shadow-2xl">
                    <iframe 
                        class="w-full h-80 md:h-96"
                        src="https://www.youtube.com/embed/nrfrxLVEPPc"
                        title="Panduan Sistem Informasi Hasil Laboratorium"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen>
                    </iframe>
                </div>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-2 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm">Video ini akan membantu Anda memahami cara menggunakan sistem</span>
                </div>
                
            </div>
        </div>
        
    </div>

   
@endsection