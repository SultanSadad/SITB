@extends('layout.rekam_medis')

@section('rekam_medis')
    <div class="px-6 mt-4">
        <h1 class="font-bold text-2xl mb-4">Data Akun</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <form action="{{ url('/rekam-medis/data-staf') }}" method="GET" class="mb-4">
                    <div class="relative w-full">
                        <input type="text" id="search-staf" name="search" placeholder="Cari Staff"
                            class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10"
                            value="{{ request('search') }}">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </form>
                <button type="submit" data-modal-toggle="crud-modal"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Staff
                </button>

            </div>
            <!-- Modal Tambah Staf -->
            <div id="crud-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg shadow-md w-full max-w-md p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Tambah Staff</h3>
                        <button type="submit" class="text-gray-400 hover:text-gray-900"
                            data-modal-toggle="crud-modal">&times;</button>
                    </div>
                    <form action="{{ route('stafs.store') }}" method="POST">
                        @csrf

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
                                <label for="peran" class="block text-sm font-medium text-gray-900">Role</label>
                                <select id="peran" name="peran" class="w-full border rounded-lg p-2.5" required>
                                    <option value="">Pilih Role</option>
                                    <option value="laboran">Laboran</option>
                                    <option value="rekam_medis">Rekam Medis</option>
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
                <select id="edit_role" name="peran" class="mt-1 p-2 w-full border border-gray-300 rounded-lg"
                    required>
                    <option value="laboran">Laboran</option>
                    <option value="rekam_medis">Rekam Medis</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="edit_password" class="block text-gray-700">Password Baru (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" id="edit_password" name="password"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-lg">
                <i id="toggleEditPassword"
                    class="fa-solid fa-eye absolute right-8 translate-y-[-50%] cursor-pointer text-gray-600"></i>
            </div>
            
            <div class="mb-4">
                <label for="edit_password_confirmation" class="block text-gray-700">Konfirmasi Password Baru</label>
                <input type="password" id="edit_password_confirmation" name="password_confirmation"
                    class="mt-1 p-2 w-full border border-gray-300 rounded-lg">
                <i id="toggleEditConfirmPassword"
                    class="fa-solid fa-eye absolute right-8 translate-y-[-50%] cursor-pointer text-gray-600"></i>
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
                                <td class="px-6 py-4 text-green-600 font-sm">{{ $staf->no_whatsapp }}</td>
                                <td class="px-6 py-4">
                                    @if ($staf->peran === 'laboran')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-sm text-orange-800 bg-orange-200">
                                            Laboran
                                        </span>
                                    @elseif ($staf->peran === 'rekam_medis')
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-sm text-purple-800 bg-purple-200">
                                            Rekam Medis
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold text-white bg-gray-600">
                                            {{ ucfirst($staf->peran) }}
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
    <script>
document.addEventListener('DOMContentLoaded', function () {
    // Toggle modal visibility
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) modal.classList.toggle('hidden');
    }

    // Toggle visibility of password fields
    function setupPasswordToggle(toggleId, inputId) {
        const toggle = document.getElementById(toggleId);
        const input = document.getElementById(inputId);
        if (toggle && input) {
            toggle.addEventListener('click', () => {
                const isPassword = input.getAttribute('type') === 'password';
                input.setAttribute('type', isPassword ? 'text' : 'password');
                toggle.classList.toggle('fa-eye');
                toggle.classList.toggle('fa-eye-slash');
            });
        }
    }

    setupPasswordToggle('togglePassword', 'password');
    setupPasswordToggle('toggleKonfirmasiPassword', 'password_confirmation');

    // Handle Add Staff buttons
    document.querySelectorAll('[data-modal-toggle="crud-modal"]').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            toggleModal('crud-modal');
        });
    });

    // Close modal when clicking outside modal content
    window.addEventListener('click', function (event) {
        document.querySelectorAll('.fixed.inset-0').forEach(modal => {
            if (!modal.classList.contains('hidden') && event.target === modal) {
                modal.classList.add('hidden');
            }
        });
    });

    // Edit button functionality
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function () {
            const staffId = this.getAttribute('data-id');
            const editForm = document.getElementById('edit-form');
            if (editForm) editForm.action = `/stafs/${staffId}`;

            fetch(`/stafs/${staffId}/edit-data`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit_nama').value = data.nama || '';
                    document.getElementById('edit_nip').value = data.nip || '';
                    document.getElementById('edit_no_whatsapp').value = data.no_whatsapp || '';
                    document.getElementById('edit_email').value = data.email || '';
                    document.getElementById('edit_role').value = data.peran || 'laboran';
                    toggleModal('edit-modal');
                })
                .catch(error => {
                    console.error('Error fetching staff data:', error);
                    const row = this.closest('tr');
                    if (row) {
                        document.getElementById('edit_nama').value = row.cells[0].textContent.trim();
                        document.getElementById('edit_nip').value = row.cells[1].textContent.trim();
                        document.getElementById('edit_email').value = row.cells[2].textContent.trim();
                        document.getElementById('edit_no_whatsapp').value = row.cells[3].textContent.trim();

                        const roleText = row.cells[4].textContent.trim().toLowerCase();
                        document.getElementById('edit_role').value =
                            roleText.includes('rekam medis') ? 'rekam_medis' : 'laboran';
                    }
                    toggleModal('edit-modal');
                });
        });
    });

    // Validate Add Staff form before submission
    const addForm = document.querySelector('#crud-modal form');
    if (addForm) {
        addForm.addEventListener('submit', function (e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak cocok!');
            }
        });
    }

    // Debug logs
    console.log('Total buttons with data-modal-toggle:', document.querySelectorAll('[data-modal-toggle]').length);
    console.log('Add Staff modal exists:', document.getElementById('crud-modal') !== null);
    console.log('Edit modal exists:', document.getElementById('edit-modal') !== null);
});
</script>

@endsection