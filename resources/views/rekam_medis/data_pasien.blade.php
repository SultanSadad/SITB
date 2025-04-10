@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Pasien</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="relative w-1/3">
                    <input type="text" placeholder="Cari Pasien"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button data-modal-toggle="crud-modal"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-lg text-sm font-medium">
                    + Tambah Pasien
                </button>
            </div>

            <!-- Modal Tambah Pasien -->
            <div id="crud-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah Pasien</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="crud-modal">&times;</button>
                    </div>
                    <form>
                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="nama_pasien" class="block text-sm font-medium text-gray-900">Nama Pasien</label>
                                <input type="text" id="nama_pasien" name="nama_pasien"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="nik" class="block text-sm font-medium text-gray-900">NIK</label>
                                <input type="text" id="nik" name="nik" class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="no_whatsapp" class="block text-sm font-medium text-gray-900">No.
                                    WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="tanggal_lahir" class="block text-sm font-medium text-gray-900">Tanggal
                                    Lahir</label>
                                <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                                <input type="password" id="password" name="password" class="w-full border rounded-lg p-2.5"
                                    required>
                            </div>
                            <div>
                                <label for="konfirmasi_password" class="block text-sm font-medium text-gray-900">Konfirmasi
                                    Password</label>
                                <input type="password" id="konfirmasi_password" name="konfirmasi_password"
                                    class="w-full border rounded-lg p-2.5" required>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" data-modal-toggle="crud-modal"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm">Tambah
                                Pasien</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Pasien (Contoh) -->
            <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Pasien</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="edit-modal">&times;</button>
                    </div>
                    <form>
                        <!-- Form untuk edit pasien -->
                        <div class="mb-4">
                            <label for="nama_pasien" class="block text-gray-700">Nama Pasien</label>
                            <input type="text" id="nama_pasien" name="nama_pasien"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="nik" class="block text-gray-700">NIK</label>
                            <input type="text" id="nik" name="nik" class="mt-1 p-2 w-full border border-gray-300 rounded-lg"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="no_wa" class="block text-gray-700">No WhatsApp Pasien</label>
                            <input type="text" id="no_wa" name="no_wa"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="tgl_lahir" class="block text-gray-700">Tanggal Lahir Pasien</label>
                            <input type="date" id="tgl_lahir" name="tgl_lahir"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <!-- Tombol Batal dan Simpan -->
                        <div class="flex justify-end gap-2 mt-4">
                            <button type="button" data-modal-toggle="edit-modal"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="overflow-x-auto mt-6">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                        <tr>
                            <th class="px-6 py-3">NAMA</th>
                            <th class="px-6 py-3">NIK</th>
                            <th class="px-6 py-3">TANGGAL LAHIR</th>
                            <th class="px-6 py-3">NO. WHATSAPP</th>
                            <th class="px-6 py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <td class="px-6 py-4 font-medium text-gray-900">Hafivah Tahta</td>
                            <td class="px-6 py-4">3576014403910003</td>
                            <td class="px-6 py-4">06 Maret 2005</td>
                            <td class="px-6 py-4 text-green-600 font-semibold">085210659598</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <button data-modal-toggle="edit-modal"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edit</button>
                                <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script Modal -->
    <script>
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', function () {
                const modalId = this.getAttribute('data-modal-toggle');
                const modal = document.getElementById(modalId);
                modal.classList.toggle('hidden');
            });
        });

        // Tutup modal jika klik di luar konten modal
        window.addEventListener('click', function (event) {
            document.querySelectorAll('.fixed.inset-0').forEach(modal => {
                if (!modal.classList.contains('hidden') && event.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
@endsection