{{-- Nama File = rekam_medis.blade.php --}}
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard Rekam Medis</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])@php $nonce = request()->attributes->get('csp_nonce'); @endphp
  <link rel="stylesheet" href="{{ Vite::asset('resources/css/app.css') }}" nonce="{{ $nonce }}">
  <script type="module" src="{{ Vite::asset('resources/js/app.js') }}" nonce="{{ $nonce }}"></script>


  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  <style nonce="{{ request()->attributes->get('csp_nonce') }}">
    .sidebar-item {
      color: #fff !important;
      background: transparent;
      transition: background .2s
    }

    .sidebar-item:hover {
      background: #4c52e3 !important;
      color: #fff !important
    }

    .sidebar-item.active {
      background: #5e64ff !important;
      color: #fff !important;
      font-weight: bold
    }

    .menu summary {
      color: #fff !important
    }

    .menu li ul li a {
      color: #fff !important;
      padding-left: 2.5rem
    }

    .menu li ul li a:hover {
      background: #4c52e3 !important;
      color: #fff !important
    }

    .menu li ul {
      background: transparent
    }

    body {
      font-family: 'Roboto', sans-serif
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0, 0, 0, .5);
      z-index: 50
    }

    .sidebar-open .sidebar-overlay {
      display: block
    }

    html,
    body {
      overflow: hidden;
      height: 100%
    }
  </style>
</head>

<body class="sidebar-closed">
  <div class="flex h-screen bg-gray-100">
    <div class="sidebar-overlay"></div>

    <div id="sidebar"
      class="fixed md:relative z-[60] w-64 h-full bg-[#3339CD] text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

      <div class="md:hidden flex items-center justify-between px-4 py-3 border-b border-[#4c52e3]">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('/statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
          <span class="text-sm font-semibold leading-tight">UPT Puskesmas<br>Baloi Permai</span>
        </div>
        <button class="text-white text-2xl hover:text-gray-200">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="hidden md:flex items-center px-6 py-5 space-x-4 border-b border-[#4c52e3]">
        <img src="{{ asset('statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
        <div class="font-bold text-white">
          <div class="text-lg">UPT Puskesmas</div>
          <div class="text-lg">Baloi Permai</div>
        </div>
      </div>

      <ul class="menu w-full rounded-box px-2 py-4 space-y-1">
        <li>
          <a href="{{ route('rekam-medis.dashboard') }}"
            class="sidebar-item {{ Request::is('*rekam-medis/dashboard') ? 'active' : '' }}">
            <span class="flex items-center pl-1">
              <i class="fas fa-home w-5 text-center mr-3"></i>
              <span>Dashboard</span>
            </span>
          </a>
        </li>
        <li>
          <a class="sidebar-item {{ Request::is('rekam-medis/hasil-uji') ? 'active' : '' }}"
            href="{{ route('rekam-medis.hasil-uji.index') }}">
            <span class="flex items-center pl-1">
              <i class="fas fa-flask w-5 text-center mr-3"></i>
              <span>Hasil Uji Laboratorium</span>
            </span>
          </a>
        </li>

        @php
      $userMenuActive = Str::contains(Request::path(), ['rekam-medis/data-pasien', 'rekam-medis/data-staf']);
    @endphp
        <li>
          <details {{ $userMenuActive ? 'open' : '' }}>
            <summary class="{{ $userMenuActive ? 'font-bold text-white' : '' }}">
              <span class="flex items-center pl-1">
                <i class="fas fa-users w-5 text-center mr-3"></i>
                <span>Users</span>
              </span>
            </summary>
            <ul class="pl-5 pt-1 space-y-1">
              <li>
                <a class="sidebar-item {{ Request::is('rekam-medis/data-pasien*') ? 'active' : '' }}"
                  href="{{ route('rekam-medis.pasien.index') }}">
                  <span class="flex items-center pl-1">
                    <i class="fas fa-user-injured w-5 text-center mr-3"></i>
                    <span>Pasien</span>
                  </span>
                </a>
              </li>
              <li>
                <a class="sidebar-item {{ Request::is('rekam-medis/data-staf*') ? 'active' : '' }}"
                  href="{{ route('rekam-medis.staf.index') }}">
                  <span class="flex items-center pl-1">
                    <i class="fas fa-vials w-5 text-center mr-3"></i>
                    <span>Akun</span>
                  </span>
                </a>
              </li>
            </ul>
          </details>
        </li>

        {{-- Trigger logout modal: pakai data-open-logout, tanpa onclick inline --}}
        <li>
          <a href="#" id="logout-button" class="sidebar-item" data-open-logout>
            <span class="flex items-center pl-1">
              <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>
              <span>Logout</span>
            </span>
          </a>
        </li>
      </ul>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
      <div class="navbar bg-[#EDEDED] text-black shadow-lg z-50 relative px-4">
        <button class="md:hidden btn btn-ghost btn-circle">
          <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="flex-1">
          <h1 class="text-xl font-bold ml-2"></h1>
        </div>

        <div class="flex-none gap-4 items-center">
          <span class="text-sm font-semibold">Hi, {{ Auth::guard('staf')->user()->nama }}</span>
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar me-6 tooltip" data-tip="User Profile"
              aria-label="User Profile">
              <div class="w-10 h-10 rounded-full overflow-hidden">
                <img src="/statis/image/profile.jpg" class="w-full h-full object-cover" alt="Profile" />
              </div>
            </div>
            <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li>
                <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100" data-open-logout>
                  Logout
                </a>
                <form id="logout-form-dropdown" action="{{ route('staf.logout') }}" method="POST" class="hidden">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <main class="p-6 flex-1 overflow-y-auto bg-[#F5F6FA]">
        @yield('rekam_medis')
      </main>
    </div>
  </div>

  {{-- Modal Logout (tanpa inline JS) --}}
  <div id="logout-modal" tabindex="-1"
    class="hidden fixed inset-0 z-50 justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
      <div class="text-center">
        <i class="fas fa-sign-out-alt text-red-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">Anda yakin ingin logout?</h3>
        <div class="flex justify-center gap-3">
          <button type="button" data-close-logout
            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded hover:bg-gray-400 min-w-[80px] h-9 flex items-center justify-center">
            Batal
          </button>
          <form id="logout-form" action="{{ route('staf.logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 min-w-[80px] h-9 flex items-center justify-center">
              Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
  @stack('scripts')

</body>

</html>