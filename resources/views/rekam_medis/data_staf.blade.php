@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Staff</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
            <form action="{{ url('/rekam_medis/data_staf') }}" method="GET" class="mb-4">
            <div class="relative w-full">
        <input type="text" id="search-staf" name="search" placeholder="Cari Staff"
            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10"
            value="{{ request('search') }}">
        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
    </div>
</form>
                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm"
                    style="min-width: 150px; white-space: nowrap;" data-modal-toggle="crud-modal">
                    + Tambah Staf
                </button>
            </div>

            <!-- Modal Tambah Staf -->
            <div id="crud-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah Staff</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="crud-modal">&times;</button>
                    </div>
                    <form action="{{ route('stafs.store') }}" method="POST">
                        @csrf
                        <input type="" name="role" value="laboran">

                        <div class="grid gap-4 mb-4">
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-900">Nama</label>
                                <input type="text" id="nama" name="nama" class="w-full border rounded-lg p-2.5" required
                                    pattern="[A-Za-z\s]+" title="Nama hanya boleh mengandung huruf dan spasi">
                            </div>
                            <div>
                                <label for="nip" class="block text-sm font-medium text-gray-900">NIP</label>
                                <input type="text" id="nip" name="nip" class="w-full border rounded-lg p-2.5" required
                                    pattern="\d+" title="NIP hanya boleh mengandung angka">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                                <input type="email" id="email" name="email" class="w-full border rounded-lg p-2.5" required
                                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}"
                                    title="Email harus mengandung simbol @">
                            </div>
                            <div>
                                <label for="no_whatsapp" class="block text-sm font-medium text-gray-900">No.
                                    WhatsApp</label>
                                <input type="text" id="no_whatsapp" name="no_whatsapp"
                                    class="w-full border rounded-lg p-2.5" required pattern="\d+"
                                    title="Nomor WhatsApp hanya boleh mengandung angka">
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-900">Role</label>
                                <select id="role" name="role" class="w-full border rounded-lg p-2.5" required>
                                    <option value="">Pilih Role</option>
                                    <option value="laboran" {{ old('role') == 'laboran' ? 'selected' : '' }}>Laboran</option>
                                    <option value="rekammedis" {{ old('role') == 'rekammedis' ? 'selected' : '' }}>Rekam Medis
                                    </option>
                                </select>


                            </div>
                            <div class="relative">
                                <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                                <input type="password" id="password" name="password"
                                    class="w-full border rounded-lg p-2.5 pr-10" required>
                                <i id="togglePassword"
                                    class="fa-solid fa-eye absolute right-3 top-9 cursor-pointer text-gray-600"></i>
                            </div>
                            <div class="relative">
                                <label for="password_confirmation"
                                    class="block text-sm font-medium text-gray-900">Konfirmasi Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full border rounded-lg p-2.5 pr-10" required>
                                <i id="toggleKonfirmasiPassword"
                                    class="fa-solid fa-eye absolute right-3 top-9 cursor-pointer text-gray-600"></i>
                            </div>
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" data-modal-toggle="crud-modal"
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm">Batal</button>
                            <button type="submit"
                                class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Edit Staff -->
            <div id="edit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Staff</h3>
                        <button type="button" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="edit-modal">&times;</button>
                    </div>
                    <form id="edit-form" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="edit_nama" class="block text-gray-700">Nama Staf</label>
                            <input type="text" id="edit_nama" name="nama"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_nip" class="block text-gray-700">NIP</label>
                            <input type="text" id="edit_nip" name="nip"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_no_whatsapp" class="block text-gray-700">No WhatsApp Staff</label>
                            <input type="text" id="edit_no_whatsapp" name="no_whatsapp"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_email" class="block text-gray-700">Email Staff</label>
                            <input type="email" id="edit_email" name="email"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg" required>
                        </div>

                        <div class="mb-4">
                            <label for="edit_role" class="block text-gray-700">Role</label>
                            <select id="edit_role" name="role" class="mt-1 p-2 w-full border border-gray-300 rounded-lg"
                                required>
                                <option value="laboran">Laboran</option>
                                <option value="rekammedis">Rekam Medis</option>
                            </select>
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
                            <th class="px-6 py-3">NIP</th>
                            <th class="px-6 py-3">EMAIL</th>
                            <th class="px-6 py-3">NO. WHATSAPP</th>
                            <th class="px-6 py-3">ROLE</th>
                            <th class="px-6 py-3">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stafs as $staf)
                            <tr class="bg-white border-b">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $staf->nama }}</td>
                                <td class="px-6 py-4">{{ $staf->nip }}</td>
                                <td class="px-6 py-4">{{ $staf->email }}</td>
                                <td class="px-6 py-4 text-green-600 font-semibold">{{ $staf->no_whatsapp }}</td>
                                <td class="px-6 py-4">
                                    @if ($staf->role === 'laboran')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-emerald-700">
                                            Laboran
                                        </span>
                                    @elseif ($staf->role === 'rekammedis')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-fuchsia-700">
                                            Rekam Medis
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-gray-600">
                                            {{ ucfirst($staf->role) }}
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 flex space-x-2">
                                    <button data-modal-toggle="edit-modal" data-id="{{ $staf->id }}"
                                        class="edit-btn bg-blue-500 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs font-semibold">Edit</button>
                                    <form action="{{ route('stafs.destroy', $staf->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="flex justify-center mt-6">
                <nav aria-label="Page navigation">
                    <ul class="inline-flex items-center -space-x-px text-sm">
                        <!-- Previous Page Link -->
                        @if ($stafs->onFirstPage())
                            <li>
                                <span
                                    class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                    &lt;
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $stafs->previousPageUrl() }}"
                                    class="px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                                    &lt;
                                </a>
                            </li>
                        @endif

                        <!-- Page Links -->
                        @foreach ($stafs->getUrlRange(1, $stafs->lastPage()) as $page => $url)
                            <li>
                                <a href="{{ $url }}"
                                    class="px-3 py-2 leading-tight {{ $page == $stafs->currentPage() ? 'text-blue-600 bg-blue-50 border border-gray-300' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">
                                    {{ $page }}
                                </a>
                            </li>
                        @endforeach

                        <!-- Next Page Link -->
                        @if ($stafs->hasMorePages())
                            <li>
                                <a href="{{ $stafs->nextPageUrl() }}"
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                    &gt;
                                </a>
                            </li>
                        @else
                            <li>
                                <span
                                    class="px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                                    &gt;
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
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

        // Toggle password visibility
        document.getElementById("togglePassword").addEventListener("click", function () {
            const pw = document.getElementById("password");
            const type = pw.getAttribute("type") === "password" ? "text" : "password";
            pw.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        document.getElementById("toggleKonfirmasiPassword").addEventListener("click", function () {
            const pw = document.getElementById("password_confirmation");
            const type = pw.getAttribute("type") === "password" ? "text" : "password";
            pw.setAttribute("type", type);
            this.classList.toggle("fa-eye");
            this.classList.toggle("fa-eye-slash");
        });

        // Edit button functionality
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                // Set form action URL
                document.getElementById('edit-form').action = `/stafs/${id}`;

                // Fetch data and populate form
                // This is where you would typically use AJAX to fetch the staff data
                // For demonstration, assuming you get the data from the current row
                const row = this.closest('tr');
                document.getElementById('edit_nama').value = row.cells[0].textContent;
                document.getElementById('edit_nip').value = row.cells[1].textContent;
                document.getElementById('edit_email').value = row.cells[2].textContent;
                document.getElementById('edit_no_whatsapp').value = row.cells[3].textContent;
            });
        });
    </script>
    <script>
$(document).ready(function() {
    $('#search-staf').on('keyup', function() {
        const searchTerm = $(this).val();
        
        // Jika ingin menggunakan AJAX untuk pencarian real-time
        if (searchTerm.length > 2) { // Mulai cari setelah 3 karakter
            $.ajax({
                url: '{{ route("search.staf") }}',
                method: 'GET',
                data: { search: searchTerm },
                success: function(data) {
                    // Tampilkan hasil pencarian, sesuaikan dengan tampilan Anda
                    // ...
                }
            });
        }
        
        // Atau bisa juga pakai form submit langsung tanpa AJAX
        // Uncomment baris berikut jika ingin form submit otomatis
        // $(this).closest('form').submit();
    });
});
</script>
@endsection