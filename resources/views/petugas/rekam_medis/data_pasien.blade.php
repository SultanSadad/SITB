{{-- resources/views/petugas/rekam_medis/data_pasien.blade.php --}}
@extends('layout.rekam_medis')

@section('rekam_medis')
  <div class="px-3 sm:px-6 mt-4">
    <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Pasien</h1>

    <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
    <div class="mb-4 sm:mb-6">
      <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4 mb-4">
      <form action="{{ route('rekam-medis.pasien.index') }}" method="GET" class="flex-grow">
        <div class="relative flex flex-col sm:flex-row gap-2 items-stretch sm:items-center w-full">
        <div class="relative flex">
          <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
          class="bg-transparent border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
          value="{{ request('search') }}">
          <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
        </div>

        <div class="hidden lg:flex space-x-2 flex-shrink-0">
          <a href="{{ route('rekam-medis.pasien.index') }}"
          class="px-3 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition {{ !request()->has('verification_status') ? 'ring-1 ring-blue-300 bg-blue-50' : '' }}">
          Semua
          </a>
          <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'verified']) }}"
          class="px-3 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition {{ request()->get('verification_status') == 'verified' ? 'ring-1 ring-green-300 bg-green-50' : '' }}">
          Terverifikasi
          </a>
          <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'unverified']) }}"
          class="px-3 py-2 text-xs font-medium text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition {{ request()->get('verification_status') == 'unverified' ? 'ring-1 ring-yellow-300 bg-yellow-50' : '' }}">
          Belum
          </a>
        </div>
        </div>
      </form>

      <button type="button"
        class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm flex items-center justify-center lg:ml-3 flex-shrink-0 w-full sm:w-auto"
        data-modal-target="crud-modal" data-modal-toggle="crud-modal">
        Tambah Pasien
      </button>
      </div>

      <div class="flex lg:hidden space-x-2 mb-2">
      <a href="{{ route('rekam-medis.pasien.index') }}"
        class="flex-1 px-2 py-2 text-xs font-medium text-center text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition {{ !request()->has('verification_status') ? 'ring-1 ring-blue-300 bg-blue-50' : '' }}">
        <span class="hidden sm:inline">Semua</span>
      </a>
      <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'verified']) }}"
        class="flex-1 px-2 py-2 text-xs font-medium text-center text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition {{ request()->get('verification_status') == 'verified' ? 'ring-1 ring-green-300 bg-green-50' : '' }}">
        <span class="hidden sm:inline">Terverifikasi</span>
      </a>
      <a href="{{ route('rekam-medis.pasien.index', ['verification_status' => 'unverified']) }}"
        class="flex-1 px-2 py-2 text-xs font-medium text-center text-gray-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100 transition {{ request()->get('verification_status') == 'unverified' ? 'ring-1 ring-yellow-300 bg-yellow-50' : '' }}">
        <span class="hidden sm:inline">Belum</span>
      </a>
      </div>
    </div>

    {{-- Banner Notifikasi --}}
    <div id="flash-banner" class="hidden mb-4" role="alert">
      <div id="flash-banner-box" class="rounded-md border px-4 py-3 flex items-start gap-3">
      <svg id="flash-banner-icon" class="w-5 h-5 mt-0.5" viewBox="0 0 24 24"></svg>
      <div class="flex-1">
        <p id="flash-banner-message" class="text-sm font-medium"></p>
      </div>
      <button id="flash-banner-close" type="button"
        class="ms-2 inline-flex items-center justify-center rounded-md px-2 py-1 text-sm">×</button>
      </div>
    </div>

    {{-- Modal Tambah --}}
    <div id="crud-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 p-4">
      <div class="bg-white rounded-lg shadow-md w-full max-w-md max-h-[90vh] overflow-y-auto">
      <div class="p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Pasien</h3>
        <button type="button" class="text-gray-400 hover:text-gray-900 text-2xl leading-none"
          data-modal-hide="crud-modal">&times;</button>
        </div>
        <form action="{{ route('rekam-medis.pasien.store') }}" method="POST">
        @csrf
        <div class="grid gap-4 mb-4">
          <div>
          <label for="no_erm" class="block text-sm font-medium text-gray-900 mb-1">No. ERM<span
            class="text-red-600">*</span></label>
          <input type="text" id="no_erm" name="no_erm"
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" required>
          </div>
          <div>
          <label for="nama_pasien" class="block text-sm font-medium text-gray-900 mb-1">Nama Pasien<span
            class="text-red-600">*</span></label>
          <input type="text" id="nama_pasien" name="nama_pasien"
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" required>
          </div>
          <div>
          <label for="nik" class="block text-sm font-medium text-gray-900 mb-1">NIK</label>
          <input type="text" id="nik" name="nik" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm"
            maxlength="16" inputmode="numeric" pattern="^\d{16}$" title="NIK harus 16 digit angka.">
          </div>
          <div>
          <label for="no_whatsapp" class="block text-sm font-medium text-gray-900 mb-1">No. WhatsApp</label>
          <input type="tel" id="no_whatsapp" name="no_whatsapp"
            class="w-full border border-gray-300 rounded-lg p-2.5 text-sm" pattern="^\d{10}$" maxlength="10"
            inputmode="numeric" title="Nomor WhatsApp harus 10 digit angka.">
          </div>
          <div>
          <label for="tanggal_lahir" class="block text-sm font-medium text-gray-900 mb-1">Tanggal Lahir</label>
          <input type="date" id="tanggal_lahir" name="tanggal_lahir"
            class="w-full border rounded-lg p-2.5 text-sm border-gray-300">
          </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-2">
          <button type="button" data-modal-hide="crud-modal"
          class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">Batal</button>
          <button type="submit"
          class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">Tambah
          Pasien</button>
        </div>
        </form>
      </div>
      </div>
    </div>

    {{-- Modal Edit --}}
    <div id="edit-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
      <div class="bg-white rounded-lg shadow-md w-full max-w-md max-h-[90vh] overflow-y-auto">
      <div class="p-4 sm:p-5">
        <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Edit Data Pasien</h3>
        <button type="button" class="text-gray-400 hover:text-gray-900 text-2xl leading-none"
          data-modal-hide="edit-modal">&times;</button>
        </div>
        <form id="edit-form" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="pasien_id" name="pasien_id">
        <div class="grid gap-4 mb-4">
          <div>
          <label for="edit_no_erm" class="block text-sm font-medium text-gray-900 mb-1">No. ERM</label>
          <input type="text" id="edit_no_erm" name="no_erm"
            class="w-full border rounded-lg p-2.5 text-sm border-gray-300" required>
          </div>
          <div>
          <label for="edit_nama" class="block text-sm font-medium text-gray-900 mb-1">Nama</label>
          <input type="text" id="edit_nama" name="nama"
            class="w-full border rounded-lg p-2.5 text-sm border-gray-300" required>
          </div>
          <div>
          <label for="edit_nik" class="block text-sm font-medium text-gray-900 mb-1">NIK</label>
          <input type="text" id="edit_nik" name="nik"
            class="w-full border rounded-lg p-2.5 text-sm border-gray-300" pattern="[0-9]{16}" maxlength="16"
            inputmode="numeric">
          </div>
          <div>
          <label for="edit_no_whatsapp" class="block text-sm font-medium text-gray-900 mb-1">No. WhatsApp</label>
          <input type="tel" id="edit_no_whatsapp" name="no_whatsapp"
            class="w-full border rounded-lg p-2.5 text-sm border-gray-300" pattern="^\+?[0-9]{10,14}$"
            maxlength="14" inputmode="numeric">
          </div>
          <div>
          <label for="edit_tanggal_lahir" class="block text-sm font-medium text-gray-900 mb-1">Tanggal
            Lahir</label>
          <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
            class="w-full border rounded-lg p-2.5 text-sm border-gray-300">
          </div>
        </div>
        <div class="flex flex-col sm:flex-row justify-end gap-2">
          <button type="button" data-modal-hide="edit-modal"
          class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">Batal</button>
          <button type="submit"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto">Simpan</button>
        </div>
        </form>
      </div>
      </div>
    </div>

    {{-- Modal Delete --}}
    <div id="delete-modal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50">
      <div class="relative w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <button type="button"
        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 flex items-center justify-center"
        data-modal-hide="delete-modal">
        <span class="sr-only">Close</span>×
        </button>
        <div class="p-6 text-center">
        <h3 class="mb-5 text-lg font-medium text-gray-700">Yakin ingin menghapus data pasien ini?</h3>
        <form id="delete-form" method="POST">
          @csrf
          @method('DELETE')
          <div class="flex flex-col sm:flex-row justify-center gap-4 mt-4">
          <button type="button" data-modal-hide="delete-modal"
            class="text-gray-700 bg-white hover:bg-gray-100 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5 w-full sm:w-auto">Batal</button>
          <button type="submit"
            class="text-white bg-red-600 hover:bg-red-800 rounded-lg text-sm px-5 py-2.5 w-full sm:w-auto">Hapus</button>
          </div>
        </form>
        </div>
      </div>
      </div>
    </div>

    {{-- LIST DATA --}}
    <div id="table-container" class="mt-6">
      {{-- MOBILE CARD --}}
      <div class="block md:hidden space-y-4">
      @foreach ($pasiens as $pasien)
      <div class="bg-gray-50 rounded-lg p-4 border">
      <div class="flex justify-between items-start mb-3">
      <div class="flex-1">
        <h4 class="font-semibold text-sm {{ empty($pasien->nama) ? 'text-red-500' : 'text-gray-900' }}">
        {{ $pasien->nama ?: 'Belum diisi' }}</h4>
        <p class="text-xs mt-1 {{ empty($pasien->no_erm) ? 'text-red-500' : 'text-gray-600' }}">ERM:
        {{ $pasien->no_erm ?: 'Belum diisi' }}</p>
      </div>
      <div class="flex items-center space-x-2">
        <input type="checkbox" class="verifikasi-checkbox accent-blue-600" data-id="{{ $pasien->id }}" {{ $pasien->verifikasi ? 'checked' : '' }}>
        <label class="text-xs text-gray-600">Verifikasi</label>
      </div>
      </div>

      <div class="grid grid-cols-1 gap-2 text-xs text-gray-600 mb-4">
      <div><span class="font-medium">NIK:</span> <span
        class="{{ empty($pasien->nik) ? 'text-red-500' : '' }}">{{ $pasien->nik ?: 'Belum diisi' }}</span></div>
      <div><span class="font-medium">Tanggal Lahir:</span>
        <span class="{{ empty($pasien->tanggal_lahir) ? 'text-red-500' : '' }}">
        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d-m-Y') : 'Belum diisi' }}
        </span>
      </div>
      <div><span class="font-medium">WhatsApp:</span>
        @if($pasien->no_whatsapp)
      <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pasien->no_whatsapp) }}" target="_blank"
      class="text-green-600 hover:underline">{{ $pasien->no_whatsapp }}</a>
      @else
      <span class="text-red-500">Belum diisi</span>
      @endif
      </div>
      </div>

      <div class="flex gap-2">
      <button
        class="btn-edit bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold w-1/2"
        data-modal-target="edit-modal" data-modal-toggle="edit-modal" data-id="{{ $pasien->id }}"
        data-nama="{{ $pasien->nama }}" data-nik="{{ $pasien->nik }}" data-wa="{{ $pasien->no_whatsapp }}"
        data-lahir="{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}"
        data-erm="{{ $pasien->no_erm ?? '' }}">Edit</button>

      <button
        class="btn-delete bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-semibold w-1/2"
        data-modal-target="delete-modal" data-modal-toggle="delete-modal"
        data-url="{{ route('rekam-medis.pasien.destroy', $pasien->id) }}">Hapus</button>
      </div>
      </div>
    @endforeach
      </div>

      {{-- TABLE DESKTOP --}}
      <div class="hidden md:block overflow-x-auto">
      <table class="w-full text-sm text-left text-gray-700">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
          <th class="px-3 lg:px-6 py-3">NO.ERM</th>
          <th class="px-3 lg:px-6 py-3">NAMA</th>
          <th class="px-3 lg:px-6 py-3 hidden lg:table-cell">NIK</th>
          <th class="px-6 py-3">TGL LAHIR</th>
          <th class="px-6 py-3">NO. WA</th>
          <th class="px-6 py-3 text-center">VERIFIKASI</th>
          <th class="px-6 py-3">AKSI</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pasiens as $pasien)
        <tr class="bg-white border-b">
        <td class="px-6 py-4 font-medium {{ empty($pasien->no_erm) ? 'text-red-500' : 'text-gray-900' }}">
        {{ $pasien->no_erm ?: 'Belum diisi' }}</td>
        <td class="px-6 py-4 font-medium {{ empty($pasien->nama) ? 'text-red-500' : 'text-gray-900' }}">
        {{ $pasien->nama ?: 'Belum diisi' }}</td>
        <td class="px-6 py-4 hidden lg:table-cell {{ empty($pasien->nik) ? 'text-red-500' : '' }}">
        {{ $pasien->nik ?: 'Belum diisi' }}</td>
        <td class="px-6 py-4 {{ empty($pasien->tanggal_lahir) ? 'text-red-500' : '' }}">
        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d-m-Y') : 'Belum diisi' }}
        </td>
        <td class="px-6 py-4 font-sm">
        @if($pasien->no_whatsapp)
        <a href="https://wa.me/{{ preg_replace('/^0/', '62', $pasien->no_whatsapp) }}" target="_blank"
        class="text-green-600 hover:underline">{{ $pasien->no_whatsapp }}</a>
      @else
        <span class="text-red-500">Belum diisi</span>
      @endif
        </td>
        <td class="px-6 py-4 text-center">
        <div class="flex items-center justify-center">
          <input type="checkbox" class="verifikasi-checkbox accent-blue-600" data-id="{{ $pasien->id }}" {{ $pasien->verifikasi ? 'checked' : '' }}>
        </div>
        </td>
        <td class="px-6 py-4 flex space-x-2">
        <button
          class="btn-edit bg-blue-500 hover:bg-blue-600 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold leading-tight"
          data-modal-target="edit-modal" data-modal-toggle="edit-modal" data-id="{{ $pasien->id }}"
          data-nama="{{ $pasien->nama }}" data-nik="{{ $pasien->nik }}" data-wa="{{ $pasien->no_whatsapp }}"
          data-lahir="{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}"
          data-erm="{{ $pasien->no_erm ?? '' }}">Edit</button>

        <button
          class="btn-delete bg-red-600 hover:bg-red-700 text-white px-2.5 py-1.5 rounded-md text-xs font-semibold leading-tight"
          data-modal-target="delete-modal" data-modal-toggle="delete-modal"
          data-url="{{ route('rekam-medis.pasien.destroy', $pasien->id) }}">Hapus</button>

        </td>
        </tr>
      @endforeach
        </tbody>
      </table>
      </div>

      {{-- PAGINATION (singkat) --}}
      @php
    $current = $pasiens->currentPage();
    $last = $pasiens->lastPage();
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
    } else {
      $start = 1;
      $end = $last;
    }
    @endphp
      <div class="flex justify-center mt-6">
      <div class="join text-sm">
        @if ($pasiens->onFirstPage())
      <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&laquo;</button>
      @else
      <a href="{{ $pasiens->previousPageUrl() }}"
      class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&laquo;</a>
      @endif

        @for ($page = 1; $page <= $last; $page++)
        @if ($page == 1 || $page == $last || ($page >= $current - 1 && $page <= $current + 1))
      <a href="{{ $pasiens->url($page) }}"
      class="join-item btn btn-sm border {{ $page == $current ? 'bg-blue-100 text-blue-600 border-blue-300' : 'border-gray-300 text-gray-600 hover:bg-gray-100' }}">{{ $page }}</a>
      @elseif ($page == $current - 2 || $page == $current + 2)
      <button class="join-item btn btn-sm btn-disabled border border-gray-200">...</button>
      @endif
      @endfor

        @if ($pasiens->hasMorePages())
      <a href="{{ $pasiens->nextPageUrl() }}"
      class="join-item btn btn-sm border border-gray-300 hover:bg-gray-100 text-gray-600">&raquo;</a>
      @else
      <button class="join-item btn btn-sm btn-disabled border border-gray-300 text-gray-400">&raquo;</button>
      @endif
      </div>
      </div>
    </div>
    </div>
  </div>

  {{-- Bridge flash --}}
  <div id="flash-bridge" data-type="{{ session('notif_type') }}" data-message="{{ session('notif_message') }}" hidden>
  </div>
  @if ($errors->any())
    <div id="flash-bridge-validation" data-type="error" data-message="{{ $errors->first() }}" hidden></div>
  @endif

  {{-- Fallback aman CSP: kirim flash ke window.__flashData agar JS pasti bisa baca --}}
  @if (session('notif_type') && session('notif_message'))
    <script nonce="{{ request()->attributes->get('csp_nonce') }}">
    window.__flashData = { type: @json(session('notif_type')), message: @json(session('notif_message')) };
    </script>
  @endif


  {{-- Routing untuk JS --}}
  <script nonce="{{ request()->attributes->get('csp_nonce') }}">
    window.csrfToken = "{{ csrf_token() }}";
    window.routeUpdateUrl = "{{ route('rekam-medis.pasien.update', ['pasien' => ':id']) }}";
    window.routeVerifikasiUrl = "{{ route('rekam-medis.pasien.verifikasi', ['pasien' => ':id']) }}";
    window.routeIndexPath = "{{ route('rekam-medis.pasien.index') }}";
  </script>
@endsection