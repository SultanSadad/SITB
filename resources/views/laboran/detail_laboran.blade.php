@extends('layout.laboran')

@section('laboran')
    <div class="relative px-6 mt-1">
        <!-- Tombol Kembali -->
        <a href="{{ route('laboran.hasil-uji') }}" class="mt-4 inline-block bg-gray-600 text-white px-4 py-2 rounded">
            Kembali
        </a>
        <h1 class="font-bold text-2xl mb-4">Detail Hasil Uji Laboratorium</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Tombol Upload Hasil Uji -->
            <div class="flex justify-end mb-4">
                <button onclick="toggleModal(true)"
                    class="inline-flex items-center bg-green-700 hover:bg-green-800 text-white text-sm font-semibold px-4 py-2 rounded">
                    <!-- Icon upload -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 16.5V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18v-1.5M12 3v12m0 0l-3.75-3.75M12 15l3.75-3.75" />
                    </svg>
                    Upload Hasil Uji
                </button>
            </div>

            <div class="overflow-x-auto mt-6">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <!-- TANGGAL UJI -->
                            <th class="px-6 py-3 ">
                                <div class="flex gap-1 relative">
                                    TANGGAL UJI
                                    <button id="filterTanggalUjiButton" data-dropdown-toggle="filterTanggalUjiDropdown"
                                        class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.65a.75.75 0 01-1.1 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <!-- Dropdown filter -->
                                    <div id="filterTanggalUjiDropdown"
                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute top-8 right-0">
                                        <ul class="py-2 text-sm text-gray-700">
                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Terbaru</a></li>
                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Terlama</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>

                            <!-- TANGGAL UPLOAD -->
                            <th class="px-6 py-3 ">
                                <div class="flex  gap-1 relative">
                                    TANGGAL UPLOAD
                                    <button id="filterTanggalUploadButton"
                                        data-dropdown-toggle="filterTanggalUploadDropdown"
                                        class="text-gray-500 hover:text-gray-700">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.1 1.02l-4.25 4.65a.75.75 0 01-1.1 0l-4.25-4.65a.75.75 0 01.02-1.06z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>

                                    <div id="filterTanggalUploadDropdown"
                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 absolute top-8 right-0">
                                        <ul class="py-2 text-sm text-gray-700">
                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Terbaru</a></li>
                                            <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Terlama</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </th>

                            <!-- STATUS -->
                          

                            <!-- FILE -->
                            <th class="px-6 py-3 ">
                                FILE
                            </th>

                            <!-- AKSI -->
                            <th class="px-6 py-3 ">
                                <div class="flex gap-1">
                                    AKSI
                                </div>
                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        @forelse ($pasien->hasilUjiTB as $hasil)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4 ">{{ $hasil->tanggal_uji }}</td>
                                <td class="px-6 py-4 ">{{ $hasil->tanggal_upload }}</td>
                        

                                <td class="px-6 py-4 ">
                                    <button type="button"
                                        onclick="window.open('{{ asset('storage/' . $hasil->file) }}', '_blank')"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                        <i class="fa-solid fa-download mr-1"></i>
                                        Cetak Hasil
                                    </button>
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <form action="{{ route('hasil-uji.destroy', $hasil->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center">Belum ada hasil uji.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="modalUpload"
        class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full bg-black bg-opacity-50">
        <div class="relative p-0 w-full max-w-md">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-5 border-b">
                    <h3 class="text-xl font-medium text-gray-900">
                        Upload Hasil Uji
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex justify-center items-center"
                        onclick="toggleModal(false)">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                
                <form action="{{ route('hasil-uji.store', $pasien->id) }}" method="POST" enctype="multipart/form-data"
                    class="p-5">
                    @csrf

                    <!-- Tanggal Uji -->
                    <div class="mb-5">
                        <label for="tanggal_uji" class="block mb-2 text-base font-medium text-gray-900">Tanggal Uji</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input type="date" id="tanggal_uji" name="tanggal_uji"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg block w-full ps-10 p-3"
                                required>
                        </div>
                    </div>

                    <!-- Tanggal Upload - hidden, akan diisi otomatis -->
                    <input type="hidden" id="tanggal_upload" name="tanggal_upload">

                    <!-- Status -->
                    <div class="mb-5">
                        <label for="status" class="block mb-2 text-base font-medium text-gray-900">Status</label>
                        <div class="relative">
                            <select id="status" name="status"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-base rounded-lg block w-full p-3 appearance-none"
                                required>
                                <option value="">Pilih Status</option>
                                <option value="Positif">Positif</option>
                                <option value="Negatif">Negatif</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-5">
                        <label class="block mb-2 text-base font-medium text-gray-900" for="file_upload">File Hasil
                            Uji</label>

                        <!-- Initial state (no file selected) -->
                        <div id="file-input-initial" class="flex items-center">
                            <label for="file_upload"
                                class="flex cursor-pointer items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-l-lg text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Pilih File
                            </label>
                            <div
                                class="flex-grow bg-gray-50 border border-l-0 border-gray-300 rounded-r-lg py-2 px-3 text-sm text-gray-500">
                                Tidak ada file yang dipilih
                            </div>
                        </div>

                        <!-- After file selected state (hidden initially) -->
                        <div id="file-input-selected"
                            class="hidden flex items-center justify-between bg-gray-50 border border-gray-300 rounded-lg py-2 px-3">
                            <div class="text-sm text-gray-900 truncate" id="selected-filename">filename.pdf</div>
                            <button type="button" id="change-file-btn"
                                class="ml-2 text-sm text-blue-600 hover:text-blue-800 font-medium">
                                Ganti File
                            </button>
                        </div>

                        <input id="file_upload" type="file" class="hidden" name="file"
                            accept=".pdf,.jpg,.jpeg,.png,.doc,.docx" required>
                        <div class="mt-2 text-sm text-gray-500">Format: PDF, JPG, PNG, DOC</div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end space-x-2 mt-8">
                        <button type="button" onclick="toggleModal(false)"
                            class="px-5 py-3 bg-gray-200 hover:bg-gray-300 rounded-lg text-sm font-medium text-gray-800">Batal</button>
                        <button type="submit"
                            class="px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg text-sm">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const fileInput = document.getElementById('file_upload');
            const initialState = document.getElementById('file-input-initial');
            const selectedState = document.getElementById('file-input-selected');
            const selectedFilename = document.getElementById('selected-filename');
            const changeFileBtn = document.getElementById('change-file-btn');

            // Set default date to today
            const today = new Date();
            const formattedDate = today.toISOString().substr(0, 10);
            document.getElementById('tanggal_uji').value = formattedDate;
            document.getElementById('tanggal_upload').value = formattedDate;

            // Handle file selection
            fileInput.addEventListener('change', function () {
                if (fileInput.files.length > 0) {
                    // Update the filename display
                    selectedFilename.textContent = fileInput.files[0].name;

                    // Show selected state, hide initial state
                    initialState.classList.add('hidden');
                    selectedState.classList.remove('hidden');
                } else {
                    // Show initial state if no file selected
                    initialState.classList.remove('hidden');
                    selectedState.classList.add('hidden');
                }
            });

            // Handle "Ganti File" button click
            changeFileBtn.addEventListener('click', function (e) {
                e.preventDefault();
                fileInput.click();
            });

            // Set tanggal_upload to current date before submitting
            document.querySelector('form').addEventListener('submit', function (e) {
                const now = new Date();
                document.getElementById('tanggal_upload').value = now.toISOString().substr(0, 10);
            });
        });

        function toggleModal(show) {
            const modal = document.getElementById('modalUpload');
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        // Function to open the modal
        function openUploadModal() {
            toggleModal(true);
        }
    </script>
@endsection