@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Staff</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <div class="relative w-1/3">
                    <input type="text" placeholder="Cari Staff"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm"
                    style="min-width: 150px; white-space: nowrap;" data-modal-toggle="crud-modal">
                    + Tambah Staff
                </button>
            </div>

            <!-- Modal Tambah Staf -->
            <div id="crud-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-sm p-4">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-semibold text-gray-900">Tambah Staff</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="crud-modal">&times;</button>
                    </div>
                    <form>
                        <div class="grid gap-3 mb-3">
                            <div>
                                <label for="nama" class="block text-xs font-medium text-gray-900">Nama</label>
                                <input type="text" id="nama" name="nama" class="w-full border rounded-lg p-2 text-xs"
                                    required>
                            </div>
                            <div>
                                <label for="email" class="block text-xs font-medium text-gray-900">Email</label>
                                <input type="email" id="email" name="email" class="w-full border rounded-lg p-2 text-xs"
                                    required>
                            </div>
                            <div>
                                <label for="nip" class="block text-xs font-medium text-gray-900">NIP</label>
                                <input type="text" id="nip" name="nip" class="w-full border rounded-lg p-2 text-xs"
                                    required>
                            </div>
                            <div>
                                <label for="no_whatsapp" class="block text-xs font-medium text-gray-900">No WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp"
                                    class="w-full border rounded-lg p-2 text-xs" required>
                            </div>
                            <div>
                                <label for="bagian" class="block text-xs font-medium text-gray-900">Bagian</label>
                                <select id="bagian" name="bagian" class="w-full border rounded-lg p-2 text-xs">
                                    <option value="" selected disabled>-- Pilih Bagian --</option>
                                    <option value="Rekam Medis">Rekam Medis</option>
                                    <option value="Laboran">Laboran</option>
                                </select>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-toggle="crud-modal"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-xs w-20 text-center">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-green-700 hover:bg-green-800 text-white px-3 py-1.5 rounded-lg text-xs w-20 text-center">
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="overflow-x-auto mt-6">
  <table class="w-full text-sm text-gray-700 text-center whitespace-nowrap">
    <thead class="text-xs text-gray-700 uppercase bg-gray-100">
      <tr>
        <th class="px-6 py-3">NAMA</th>
        <th class="px-6 py-3">EMAIL</th>
        <th class="px-6 py-3">NIP</th>
        <th class="px-6 py-3">NO. WHATSAPP</th>
        <th class="px-6 py-3">BAGIAN</th>
        <th class="px-6 py-3">AKSI</th>
      </tr>
    </thead>
    <tbody>
      <tr class="bg-white border-b">
        <td class="px-6 py-4 font-medium text-gray-900">Hafivah Tahta</td>
        <td class="px-6 py-4">hafivah@example.com</td>
        <td class="px-6 py-4">3576014403910003</td>
        <td class="px-6 py-4 text-green-600 font-semibold">085210659598</td>
        <td class="px-6 py-4">Rekam Medis</td>
        <td class="px-6 py-4">
          <div class="flex justify-center items-center space-x-2">
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
          </div>
        </td>
      </tr>
    </tbody>
  </table>
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
