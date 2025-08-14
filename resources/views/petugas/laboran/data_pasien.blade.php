{{-- resources/views/petugas/laboran/data_pasien.blade.php --}}
{{-- TETAPKAN WARNA & LAYOUT SESUAI ASLI --}}

@extends('layout.laboran')
@section('title', 'Data Pasien')

@section('content')

  {{-- Banner notifikasi dekat tabel (flash dari controller) --}}
  @php
    $notifType = session('notif_type') ?? session('success_type');
    $notifMsg = session('notif_message') ?? session('success_message');
    $bannerClasses = match ($notifType) {
    'success_add', 'success_edit', 'success_delete', 'success_general' => 'bg-green-50 text-green-800 border-green-200',
    'error' => 'bg-red-50 text-red-800 border-red-200',
    'info' => 'bg-blue-50 text-blue-800 border-blue-200',
    default => 'hidden'
    };
    @endphp


  {{-- Bridge untuk JS (kalau perlu popup juga) --}}
  <div id="flash-bridge" data-success="{{ session('success') }}" data-error="{{ session('error') }}"
    data-notif-type="{{ session('notif_type') }}" data-notif-message="{{ session('notif_message') }}"
    data-success-type="{{ session('success_type') }}" data-success-message="{{ session('success_message') }}" hidden>
  </div>

  <div class="px-3 sm:px-6 mt-4">
    <h1 class="font-bold text-xl sm:text-2xl mb-4">Data Pasien</h1>

    <div class="bg-white shadow-md rounded-lg p-3 sm:p-6">
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center space-y-3 sm:space-y-0">
      <form action="{{ route('laboran.pasien.index') }}" method="GET" class="w-64 sm:w-auto">
      <div class="relative w-full sm:w-64 lg:w-64">
        <input type="text" id="search-pasien" name="search" placeholder="Cari Pasien"
        class="border border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring focus:border-blue-300 text-sm pl-10 placeholder-gray-400 text-black"
        value="{{ request('search') }}">
        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
      </div>
      </form>

      <button type="button"
      class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg text-sm w-full sm:w-auto whitespace-nowrap"
      data-modal-target="crud-modal" data-modal-toggle="crud-modal">
      + Tambah Pasien
      </button>
    </div>

    {{-- ================== MODAL HAPUS ================== --}}
    <div id="delete-modal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
      <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <button type="button"
        class="absolute top-3 end-2.5 text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
        data-modal-hide="delete-modal" aria-label="Close">
        <span class="sr-only">Close</span>×
        </button>
        <div class="p-4 md:p-5 text-center">
        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" xmlns="http://www.w3.org/2000/svg" fill="none"
          viewBox="0 0 20 20" aria-hidden="true">
          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <h3 class="mb-5 text-lg font-normal text-gray-700">Yakin ingin menghapus data pasien ini?</h3>

        <button data-modal-hide="delete-modal" type="button"
          class="text-gray-700 bg-white hover:bg-gray-100 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5">
          Batal
        </button>

        <form id="delete-form" method="POST" class="inline-block ml-2">
          @csrf
          @method('DELETE')
          <button type="submit"
          class="text-white bg-red-600 hover:bg-red-800 rounded-lg text-sm inline-flex items-center px-5 py-2.5">
          Ya, Hapus
          </button>
        </form>
        </div>
      </div>
      </div>
    </div>

    {{-- ================== MODAL TAMBAH ================== --}}
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
      <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
        <h3 class="text-lg font-semibold text-gray-900">Tambah Pasien Baru</h3>
        <button type="button"
          class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
          data-modal-hide="crud-modal" aria-label="Close">
          <span class="sr-only">Close</span>×
        </button>
        </div>

        <form action="{{ route('laboran.pasien.store') }}" method="POST" class="p-4 md:p-5">
        @csrf
        <div class="grid gap-4 mb-4 grid-cols-2">
          <div class="col-span-2">
          <label for="no_erm" class="block mb-2 text-sm font-medium text-gray-900">No. ERM <span
            class="text-red-600">*</span></label>
          <input type="text" id="no_erm" name="no_erm"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama Pasien <span
            class="text-red-600">*</span></label>
          <input type="text" id="nama" name="nama"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="nik" class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
          <input type="text" id="nik" name="nik" pattern="[0-9]{16}" maxlength="16" inputmode="numeric"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="col-span-2">
          <label for="no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No. WhatsApp</label>
          <input type="tel" id="no_whatsapp" name="no_whatsapp" pattern="^(08|\+62)[0-9]{8,12}$" maxlength="14"
            inputmode="numeric"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="col-span-2">
          <label for="tanggal_lahir" class="block mb-2 text-sm font-medium text-gray-900">Tanggal Lahir</label>
          <input type="date" id="tanggal_lahir" name="tanggal_lahir"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
          </div>
        </div>

        <div class="flex justify-end gap-2">
          <button type="button" data-modal-hide="crud-modal"
          class="text-gray-700 bg-white hover:bg-gray-100 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5">
          Batal
          </button>
          <button type="submit"
          class="text-white inline-flex items-center bg-green-700 hover:bg-green-800 rounded-lg text-sm px-5 py-2.5">
          Tambah Pasien
          </button>
        </div>
        </form>

      </div>
      </div>
    </div>

    {{-- ================== MODAL EDIT ================== --}}
    <div id="edit-modal" tabindex="-1" aria-hidden="true"
      class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
      <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow">
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t">
        <h3 class="text-lg font-semibold text-gray-900">Edit Pasien</h3>
        <button type="button"
          class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
          data-modal-hide="edit-modal" aria-label="Close">
          <span class="sr-only">Close</span>×
        </button>
        </div>

        <form id="edit-form" method="POST" class="p-4 md:p-5">
        @csrf
        @method('PUT')
        <input type="hidden" id="pasien_id" name="pasien_id">

        <div class="grid gap-4 mb-4 grid-cols-2">
          <div class="col-span-2">
          <label for="edit_no_erm" class="block mb-2 text-sm font-medium text-gray-900">No. ERM <span
            class="text-red-600">*</span></label>
          <input type="text" id="edit_no_erm" name="no_erm"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="edit_nama" class="block mb-2 text-sm font-medium text-gray-900">Nama Pasien <span
            class="text-red-600">*</span></label>
          <input type="text" id="edit_nama" name="nama"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
            required>
          </div>
          <div class="col-span-2">
          <label for="edit_nik" class="block mb-2 text-sm font-medium text-gray-900">NIK</label>
          <input type="text" id="edit_nik" name="nik" pattern="[0-9]{16}" maxlength="16" inputmode="numeric"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="col-span-2">
          <label for="edit_no_whatsapp" class="block mb-2 text-sm font-medium text-gray-900">No. WhatsApp</label>
          <input type="tel" id="edit_no_whatsapp" name="no_whatsapp" pattern="^(08|\+62)[0-9]{8,12}$"
            maxlength="14" inputmode="numeric"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
          </div>
          <div class="col-span-2">
          <label for="edit_tanggal_lahir" class="block mb-2 text-sm font-medium text-gray-900">Tanggal
            Lahir</label>
          <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5">
          </div>
        </div>

        <div class="flex justify-end gap-2">
          <button type="button" data-modal-hide="edit-modal"
          class="text-gray-700 bg-white hover:bg-gray-100 rounded-lg border border-gray-300 text-sm font-medium px-5 py-2.5">
          Batal
          </button>
          <button type="submit"
          class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
          Simpan
          </button>
        </div>
        </form>

      </div>
      </div>
    </div>
    <!-- Inline banner (hidden by default) -->
    <div id="inline-banner" class="hidden mt-4">
      <div id="inline-banner-box" class="flex items-start gap-3 rounded-lg border px-4 py-3 text-sm">
      <svg id="inline-banner-icon" class="w-5 h-5 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none"
        stroke="currentColor"></svg>
      <div id="inline-banner-text" class="leading-5"></div>
      <button type="button" id="inline-banner-close" class="ml-auto text-xs font-semibold"></button>
      </div>
    </div>

    {{-- ================ MOBILE CARDS ================ --}}
    <div class="block lg:hidden space-y-4 mt-6" id="mobile-cards-container">
      @forelse ($pasiens as $pasien)
      <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
      <div class="flex justify-between items-start mb-2">
      <h3 class="text-xl font-bold {{ empty($pasien->nama) ? 'text-red-500' : 'text-gray-900' }}">
      {{ $pasien->nama ?? 'Nama Belum diisi' }}</h3>
      </div>

      <div class="text-sm text-gray-700 space-y-1.5">
      <p><span class="font-semibold text-gray-600">ERM:</span>
      <span
        class="{{ empty($pasien->no_erm) ? 'text-red-500' : 'text-gray-800' }}">{{ $pasien->no_erm ?? 'Belum diisi' }}</span>
      </p>
      <p><span class="font-semibold text-gray-600">NIK:</span>
      <span
        class="{{ empty($pasien->nik) ? 'text-red-500' : 'text-gray-800' }}">{{ $pasien->nik ?? 'Belum diisi' }}</span>
      </p>
      <p><span class="font-semibold text-gray-600">Tanggal Lahir:</span>
      <span class="{{ empty($pasien->tanggal_lahir) ? 'text-red-500' : 'text-gray-800' }}">
        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d M Y') : 'Belum diisi' }}
      </span>
      </p>
      <p><span class="font-semibold text-gray-600">WhatsApp:</span>
      @if (!empty($pasien->no_whatsapp))
      <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pasien->no_whatsapp)) }}"
      target="_blank" class="text-green-600 hover:underline">{{ $pasien->no_whatsapp }}</a>
      @else
      <span class="text-red-500">Belum diisi</span>
      @endif
      </p>
      </div>

      <div class="flex justify-end gap-3 mt-4">
      <button
      class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded text-sm font-semibold w-full transition btn-edit"
      data-id="{{ $pasien->id }}" data-nama="{{ $pasien->nama }}" data-nik="{{ $pasien->nik }}"
      data-wa="{{ $pasien->no_whatsapp }}"
      data-lahir="{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}"
      data-erm="{{ $pasien->no_erm ?? '' }}" data-update-url="{{ route('laboran.pasien.update', $pasien->id) }}">
      Edit
      </button>

      <button
      class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm font-semibold w-full transition btn-delete"
      data-url="{{ route('laboran.pasien.destroy', $pasien->id) }}">
      Hapus
      </button>
      </div>
      </div>
    @empty
      <p class="text-gray-500 text-center">Tidak ada data pasien yang ditemukan.</p>
    @endforelse
    </div>

    {{-- ================ DESKTOP TABLE ================ --}}
    <div id="table-container" class="hidden lg:block overflow-x-auto mt-6">

      <table class="w-full text-sm text-left text-gray-700">
      <thead class="text-xs text-gray-700 uppercase bg-gray-100">
        <tr>
        <th class="px-6 py-3">NO.ERM</th>
        <th class="px-6 py-3">NAMA</th>
        <th class="px-6 py-3">NIK</th>
        <th class="px-6 py-3">TANGGAL LAHIR</th>
        <th class="px-6 py-3">NO. WHATSAPP</th>
        <th class="px-6 py-3">AKSI</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($pasiens as $pasien)
      <tr class="bg-white border-b">
      <td class="px-6 py-4 font-medium {{ empty($pasien->no_erm) ? 'text-red-500' : 'text-gray-900' }}">
        {{ $pasien->no_erm ?? 'Belum ada' }}
      </td>
      <td class="px-6 py-4 font-medium {{ empty($pasien->nama) ? 'text-red-500' : 'text-gray-900' }}">
        {{ $pasien->nama ?? 'Belum diisi' }}
      </td>
      <td class="px-6 py-4 {{ empty($pasien->nik) ? 'text-red-500' : '' }}">{{ $pasien->nik ?? 'Belum diisi' }}
      </td>
      <td class="px-6 py-4 {{ empty($pasien->tanggal_lahir) ? 'text-red-500' : '' }}">
        {{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('d-m-Y') : 'Belum diisi' }}
      </td>
      <td class="px-6 py-4 whitespace-nowrap font-medium">
        @if ($pasien->no_whatsapp)
      <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $pasien->no_whatsapp)) }}"
      target="_blank" class="text-green-600 hover:underline hover:text-green-700 transition">
      {{ $pasien->no_whatsapp }}
      </a>
      @else
      <span class="text-red-500">belum diisi</span>
      @endif
      </td>
      <td class="px-6 py-4">
        <div class="flex gap-2">
        <button
        class="bg-blue-500 hover:bg-blue-600 text-white py-1 px-2 rounded-md text-xs font-semibold transition btn-edit"
        data-id="{{ $pasien->id }}" data-erm="{{ $pasien->no_erm }}" data-nama="{{ $pasien->nama }}"
        data-nik="{{ $pasien->nik }}" data-wa="{{ $pasien->no_whatsapp }}"
        data-lahir="{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('Y-m-d') : '' }}"
        data-update-url="{{ route('laboran.pasien.update', $pasien->id) }}">
        Edit
        </button>

        <button
        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-semibold transition btn-delete"
        data-url="{{ route('laboran.pasien.destroy', $pasien->id) }}">
        Hapus
        </button>
        </div>
      </td>
      </tr>
      @empty
      <tr>
      <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data pasien yang ditemukan.</td>
      </tr>
      @endforelse
      </tbody>
      </table>
    </div>

    {{-- ================ PAGINATION ================ --}}
    <div class="flex justify-center mt-6">
      <div class="join text-sm">
      @if ($pasiens->onFirstPage())
      <button class="join-item btn btn-sm btn-disabled">&laquo;</button>
    @else
      <a href="{{ $pasiens->previousPageUrl() }}" class="join-item btn btn-sm">&laquo;</a>
    @endif

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
      }
      @endphp

      @if ($start > 1)
      <a href="{{ $pasiens->url(1) }}" class="join-item btn btn-sm">1</a>
      @if ($start > 2)
      <button class="join-item btn btn-sm btn-disabled">...</button>
      @endif
    @endif

      @for ($i = $start; $i <= $end; $i++)
      <a href="{{ $pasiens->url($i) }}"
      class="join-item btn btn-sm {{ $i == $current ? 'bg-blue-100 text-blue-600' : '' }}">
      {{ $i }}
      </a>
    @endfor

      @if ($end < $last)
      @if ($end < $last - 1)
      <button class="join-item btn btn-sm btn-disabled">...</button>
      @endif
      <a href="{{ $pasiens->url($last) }}" class="join-item btn btn-sm">{{ $last }}</a>
    @endif

      @if ($pasiens->hasMorePages())
      <a href="{{ $pasiens->nextPageUrl() }}" class="join-item btn btn-sm">&raquo;</a>
    @else
      <button class="join-item btn btn-sm btn-disabled">&raquo;</button>
    @endif
      </div>
    </div>

    </div>
  </div>

  {{-- Popup modal (opsional untuk toast ala modal kecil) --}}
  <div id="popup-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full p-4">
    <div class="relative w-full max-w-sm sm:max-w-md max-h-full">
    <div class="relative bg-white rounded-lg shadow-sm">
      <div class="p-4 md:p-5 text-center">
      <svg id="modal-icon" class="mx-auto mb-4 w-10 h-10 sm:w-12 sm:h-12" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24" stroke="currentColor"></svg>
      <h3 class="mb-2 text-base sm:text-lg font-normal text-gray-700">
        <span id="modal-message">Pesan</span>
      </h3>
      </div>
    </div>
    </div>
  </div>
  <!-- Flash bridge untuk semua pola session yang kamu pakai -->


  <script nonce="{{ request()->attributes->get('csp_nonce') }}">
    // ====== Util Banner TST (inline 3 detik) ======
    (function () {
    let hideTimer;

    function el(id) { return document.getElementById(id); }

    function setBoxStyle(box, type) {
      // reset base
      box.className = 'flex items-start gap-3 rounded-lg border px-4 py-3 text-sm';
      if (type === 'success') {
      box.classList.add('bg-green-50', 'border-green-200', 'text-green-800');
      } else if (type === 'error') {
      box.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
      } else {
      box.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-800');
      }
    }

    function setIcon(icon, type) {
      if (type === 'success') {
      icon.innerHTML = '<path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="12" cy="12" r="9" stroke-width="2"></circle>';
      } else if (type === 'error') {
      icon.innerHTML = '<path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
      } else {
      icon.innerHTML = '<circle cx="12" cy="12" r="9" stroke-width="2"></circle><path d="M12 8h.01M12 12v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
      }
    }

    function showBanner(type, message) {
      const wrap = el('inline-banner');
      const box = el('inline-banner-box');
      const icon = el('inline-banner-icon');
      const text = el('inline-banner-text');
      const close = el('inline-banner-close');
      if (!wrap || !box || !icon || !text) return;

      setBoxStyle(box, type);
      setIcon(icon, type);
      text.textContent = message || '';
      wrap.classList.remove('hidden');

      clearTimeout(hideTimer);
      hideTimer = setTimeout(() => wrap.classList.add('hidden'), 3000);
      if (close) {
      close.onclick = () => {
        clearTimeout(hideTimer);
        wrap.classList.add('hidden');
      };
      }
    }

    // Expose global biar bisa dipanggil dari AJAX jika perlu
    window.tstBanner = { show: showBanner };

    // ====== Auto-detect dari session/errors ======
    document.addEventListener('DOMContentLoaded', () => {
      const bridge = el('flash-bridge');

      // 1) Validasi gagal?
      @if ($errors->any())
      showBanner('error', @json($errors->first()));
      return;
    @endif

      if (!bridge) return;

      // 2) Pola umum success/error
      const s = bridge.getAttribute('data-success') || '';
      const e = bridge.getAttribute('data-error') || '';

      // 3) Pola notif_type/notif_message (rekam medis)
      const nt = bridge.getAttribute('data-notif-type') || '';
      const nm = bridge.getAttribute('data-notif-message') || '';

      // 4) Pola success_type/success_message (beberapa destroy())
      const st = bridge.getAttribute('data-success-type') || '';
      const sm = bridge.getAttribute('data-success-message') || '';

      // Tentukan prioritas pesan yang ditampilkan
      if (s) return showBanner('success', s);
      if (e) return showBanner('error', e);

      if (nm) {
      const type = (nt && nt.indexOf('success') !== -1) ? 'success'
        : (nt === 'error' ? 'error' : 'info');
      return showBanner(type, nm);
      }

      if (sm) {
      const type = (st && st.indexOf('success') !== -1) ? 'success'
        : (st === 'error' ? 'error' : 'info');
      return showBanner(type, sm);
      }
    });
    })();
  </script>

@endsection

@push('scripts')
  {{-- Page script melalui Vite (tidak mengubah warna/layout) --}}
  @vite('resources/js/pages/laboran/data_pasien.js')
@endpush