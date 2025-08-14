{{-- resources/views/petugas/rekam_medis/data_staf.blade.php --}}
@extends('layout.rekam_medis')

@section('rekam_medis')
  <div class="px-3 sm:px-6 mt-4">
    <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Akun Staf</h1>

    <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">
      <form action="{{ url('petugas/rekam-medis/data-staf') }}" method="GET" class="w-full sm:w-auto">
      <div class="relative w-full sm:w-60">
        <input type="text" id="search-staf" name="q" placeholder="Cari Akun"
        class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
        value="{{ request('q') }}">
        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
      </div>
      </form>

      <button type="button" data-modal-target="crud-modal" data-modal-toggle="crud-modal"
      class="w-full sm:w-auto bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center sm:justify-start">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
      </svg>
      Tambah Akun
      </button>
    </div>

    {{-- Banner Notifikasi (dekat tabel) --}}
    <div id="flash-banner" class="hidden mb-4">
      <div id="flash-banner-box" class="rounded-md border px-4 py-3 flex items-start gap-3">
      <svg id="flash-banner-icon" class="w-5 h-5 mt-0.5"></svg>
      <span id="flash-banner-message" class="text-sm"></span>
      <button id="flash-banner-close" type="button"
        class="ml-auto text-sm text-gray-500 hover:text-gray-700"></button>
      </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
      <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Staf Baru</h3>
        <button type="button" data-modal-hide="crud-modal"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
          <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"
          aria-hidden="true">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        </div>

        <form id="add-staf-form" action="{{ route('rekam-medis.staf.store') }}" method="POST" class="p-4 md:p-5">
        @csrf
        <div class="grid gap-4 mb-4 grid-cols-2">
          <div class="col-span-2">
          <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama <span
            class="text-red-600">*</span></label>
          <input type="text" name="nama" id="nama"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" required
            pattern="[A-Za-z\s]+" title="Nama hanya boleh mengandung huruf dan spasi">
          </div>
          <div class="col-span-2">
          <label for="nip" class="block mb-2 text-sm font-medium text-gray-900">NIP <span
            class="text-red-600">*</span></label>
          <input type="text" name="nip" id="nip"
            class="only-digits bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required pattern="\d+" title="NIP hanya boleh mengandung angka">
          </div>
          <div class="col-span-2">
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Username <span
            class="text-red-600">*</span></label>
          <input type="text" name="email" id="email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No. WhatsApp <span
            class="text-red-600">*</span></label>
          <input type="text" name="no_whatsapp" id="no_whatsapp"
            class="only-digits-plus bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required pattern="^\+?[0-9]{10,14}$" minlength="10" maxlength="14"
            title="Nomor WhatsApp harus angka atau dimulai dengan +, minimal 10 digit, maksimal 14 digit.">
          </div>
          <div class="col-span-2">
          <label for="peran" class="block mb-2 text-sm font-medium text-gray-900">Role <span
            class="text-red-600">*</span></label>
          <select name="peran" id="peran"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
            <option value="">Pilih Role</option>
            <option value="laboran">Laboran</option>
            <option value="rekam_medis">Rekam Medis</option>
          </select>
          </div>
          <div class="col-span-2 relative">
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password <span
            class="text-red-600">*</span></label>
          <input type="password" name="password" id="password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pr-10"
            required minlength="8">
          <i id="togglePassword"
            class="fa-solid fa-eye absolute right-3 top-[42px] cursor-pointer text-gray-600"></i>
          </div>
          <div class="col-span-2 relative">
          <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi
            Password <span class="text-red-600">*</span></label>
          <input type="password" name="password_confirmation" id="password_confirmation"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pr-10"
            required>
          <i id="toggleKonfirmasiPassword"
            class="fa-solid fa-eye absolute right-3 top-[42px] cursor-pointer text-gray-600"></i>
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" data-modal-hide="crud-modal"
          class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">Batal</button>
          <button type="submit"
          class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5">
          Tambah Akun
          </button>
        </div>
        </form>
      </div>
      </div>
    </div>

    {{-- Modal Edit --}}
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
      <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
        <h3 class="text-lg font-semibold text-gray-900">Edit Staf</h3>
        <button type="button" data-modal-hide="edit-modal"
          class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
          <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14"
          aria-hidden="true">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        </div>

        <form id="edit-form" method="POST" class="p-4 md:p-5">
        @csrf
        @method('PUT')
        <div class="grid gap-4 mb-4 grid-cols-2">
          <div class="col-span-2">
          <label for="edit_nama" class="block mb-2 text-sm font-medium text-gray-900">Nama <span
            class="text-red-600">*</span></label>
          <input type="text" name="nama" id="edit_nama"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="edit_nip" class="block mb-2 text-sm font-medium text-gray-900">NIP <span
            class="text-red-600">*</span></label>
          <input type="text" name="nip" id="edit_nip"
            class="only-digits bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required pattern="\d+" title="NIP hanya boleh mengandung angka">
          </div>
          <div class="col-span-2">
          <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900">Username <span
            class="text-red-600">*</span></label>
          <input type="text" name="email" id="edit_email"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="edit_no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No. WhatsApp <span
            class="text-red-600">*</span></label>
          <input type="text" name="no_whatsapp" id="edit_no_whatsapp"
            class="only-digits-plus bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required pattern="^\+?[0-9]{10,14}$" minlength="10" maxlength="14"
            title="Nomor WhatsApp harus angka atau dimulai dengan +, minimal 10 digit, maksimal 14 digit.">
          </div>
          <div class="col-span-2">
          <label for="edit_peran" class="block mb-2 text-sm font-medium text-gray-900">Role <span
            class="text-red-600">*</span></label>
          <select name="peran" id="edit_peran"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
            <option value="laboran">Laboran</option>
            <option value="rekam_medis">Rekam Medis</option>
          </select>
          </div>
          <div class="col-span-2 relative">
          <label for="edit_password" class="block mb-2 text-sm font-medium text-gray-900">Password Baru
            (Opsional)</label>
          <input type="password" name="password" id="edit_password"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pr-10">
          <i id="toggleEditPassword"
            class="fa-solid fa-eye absolute right-3 top-[42px] cursor-pointer text-gray-600"></i>
          </div>
          <div class="col-span-2 relative">
          <label for="edit_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi
            Password Baru</label>
          <input type="password" name="password_confirmation" id="edit_password_confirmation"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 pr-10">
          <i id="toggleEditConfirmPassword"
            class="fa-solid fa-eye absolute right-3 top-[42px] cursor-pointer text-gray-600"></i>
          </div>
        </div>
        <div class="flex justify-end gap-2">
          <button type="button" data-modal-hide="edit-modal"
          class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">Batal</button>
          <button type="submit"
          class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">Simpan</button>
        </div>
        </form>
      </div>
      </div>
    </div>

    {{-- Modal Hapus --}}
    <div id="delete-modal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4 bg-black/30">
      <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="p-4 md:p-5 text-center">
        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" fill="none" viewBox="0 0 20 20" aria-hidden="true">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <h3 class="mb-5 text-lg font-medium text-gray-700">Yakin ingin menghapus data akun ini?</h3>
        <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
          <button type="button" data-modal-hide="delete-modal"
          class="text-gray-500 bg-white hover:bg-gray-100 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 w-full sm:w-auto">
          Batal
          </button>
          <form id="delete-form" method="POST" class="w-full sm:w-auto">
          @csrf
          @method('DELETE')
          <button type="submit"
            class="text-white bg-red-600 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto">
            Hapus
          </button>
          </form>
        </div>
        </div>
      </div>
      </div>
    </div>

    {{-- LIST: Mobile cards --}}
    <div class="block md:hidden space-y-4">
      @forelse ($stafs as $staf)
      <div class="bg-white rounded-lg p-4 border shadow-sm">
      <div class="mb-3">
      <h3 class="font-bold text-lg text-gray-900">{{ $staf->nama }}</h3>
      <p class="text-sm text-gray-600">NIP: {{ $staf->nip }}</p>
      </div>
      <div class="grid grid-cols-1 gap-2 text-sm mb-4">
      <p><span class="font-semibold text-gray-600">Username:</span> <span
        class="ml-2 text-gray-800">{{ $staf->email }}</span></p>
      <p>
      <span class="font-semibold text-gray-600">WhatsApp:</span>
      @if (!empty($staf->no_whatsapp))
      <a href="https://wa.me/{{ preg_replace('/^0/', '62', $staf->no_whatsapp) }}" target="_blank"
      class="ml-2 text-green-600 hover:underline">{{ $staf->no_whatsapp }}</a>
      @else
      <span class="ml-2 text-red-500">Belum diisi</span>
      @endif
      </p>
      <p>
      <span class="font-semibold text-gray-600">Role:</span>
      <span class="ml-2">
        @if ($staf->peran === 'laboran')
      <span
      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-orange-800 bg-orange-200">Laboran</span>
      @elseif ($staf->peran === 'rekam_medis')
      <span
      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-purple-800 bg-purple-200">Rekam
      Medis</span>
      @else
      <span
      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium text-white bg-gray-600">{{ ucfirst($staf->peran) }}</span>
      @endif
      </span>
      </p>
      </div>
      <div class="flex items-center justify-center gap-3">
      <td class="px-6 py-4 flex space-x-2">
      <button type="button" data-id="{{ $staf->id }}"
        class="edit-btn inline-flex items-center justify-center w-16 h-8 rounded-lg bg-blue-500 hover:bg-blue-600 text-white font-bold text-xs shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        Edit
      </button>
      <button type="button" data-url="{{ route('rekam-medis.staf.destroy', $staf->id) }}"
        class="btn-delete bg-red-600 hover:bg-red-700 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold leading-tight">
        Hapus
      </button>
      </td>


      </div>

      </div>
    @empty
      <p class="text-gray-500 text-center py-4">Tidak ada data staf yang ditemukan.</p>
    @endforelse
    </div>

    {{-- LIST: Desktop table --}}
    <div id="table-container" class="hidden md:block overflow-x-auto mt-6">
      <table class="min-w-full text-sm text-left text-gray-700 border-collapse">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
        <th class="px-6 py-3">NAMA</th>
        <th class="px-6 py-3">NIP</th>
        <th class="px-6 py-3">USERNAME</th>
        <th class="px-6 py-3">NO. WHATSAPP</th>
        <th class="px-6 py-3">ROLE</th>
        <th class="px-6 py-3">AKSI</th>
        </tr>
      </thead>
      <tbody id="staf-table-body">
        @include('petugas.rekam_medis.partials.staf_table_rows')
      </tbody>
      </table>
    </div>

    <div id="pagination-links" class="flex justify-center items-center flex-col md:flex-row mt-6 gap-3">
      <div class="join text-sm">
      {{ $stafs->links('pagination::tailwind') }}
      </div>
    </div>
    </div>
  </div>

  <div id="flash-bridge" data-type="{{ session('notif_type') }}" data-message="{{ session('notif_message') }}" hidden>
  </div>

  @if ($errors->any())
    @php
    // ambil maksimal 3 error biar gak kepanjangan
    $errs = collect($errors->all())->take(3)->implode(' • ');
    @endphp
    <div id="flash-bridge-validation" data-type="error" data-message="{{ $errs }}" hidden></div>
  @endif

@endsection