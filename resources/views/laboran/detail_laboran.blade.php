@extends('layout.laboran')

@section('laboran')
    <div class="relative px-6 mt-4">

        <!-- Tombol Kembali -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-700 hover:text-gray-900 mb-3">
            <!-- Heroicon: Panah ke kiri -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span class="text-sm font-medium">Kembali</span>
        </a>

        <h1 class="font-bold text-2xl mb-4">Detail Hasil Uji</h1>

        <div class="bg-white shadow-md rounded-lg p-6">

            <!-- Tombol Upload Hasil Uji -->
            <div class="flex justify-end mb-4">
                <button onclick="toggleModal(true)" 
                    class="inline-flex items-center bg-green-700 hover:bg-green-800 text-white text-sm font-semibold px-4 py-2 rounded">
            <!-- Icon upload -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
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
                            <th class="px-6 py-3 text-center">TANGGAL UJI</th>
                            <th class="px-6 py-3 text-center">TANGGAL UPLOAD</th>
                            <th class="px-6 py-3 text-center">STATUS</th>
                            <th class="px-6 py-3 text-center">FILE</th>
                            <th class="px-6 py-3 text-center">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 text-center">5 April 2025</td>
                            <td class="px-6 py-4 text-center">7 April 2025</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-sm font-medium">Negatif</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="#"
                                    class="bg-green-600 hover:bg-green-700 text-white px-2 py-1 rounded text-xs font-semibold">
                                    Cetak Hasil
                                </a>
                            </td>
                            <td class="px-6 py-4 flex justify-center space-x-2">
                                <a href="#"
                                   class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                    Cetak
                                </a>
                                <button type="button"
                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold"
                                    data-modal-toggle="delete-modal">
                                    Hapus
                                </button>


                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <!-- Modal Upload Hasil Uji -->
    <div id="modalUpload" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-5">
            <h2 class="text-xl font-bold mb-4 text-left">Upload Hasil Uji</h2>
            
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-900">Status</label>
                    <select id="status" name="status" required
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <option value="">Pilih Status </option>
                        <option value="Negatif">Negatif</option>
                        <option value="Positif">Positif</option>
                    </select>
                </div>

                <!-- File Upload -->
                <div class="mb-4">
                    <label for="file" class="block text-sm font-medium text-gray-700">File Hasil (PDF)</label>
                    <input type="file" id="file" name="file" accept="application/pdf" required
                        class="mt-1 block w-full text-sm text-gray-700">
                </div>

                <!-- Tombol -->
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" onclick="toggleModal(false)"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded">Batal</button>
                    <button type="submit"
                            class="px-4 py-2 bg-green-700 text-white hover:bg-green-800 rounded">Upload</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        function toggleModal(show) {
            const modal = document.getElementById('modalUpload');
            modal.classList.toggle('hidden', !show);
        }
    </script>


@endsection
