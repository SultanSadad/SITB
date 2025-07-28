{{-- resources/views/layouts/laboran.blade.php --}}
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard Laboran')</title>

  {{-- Styles --}}
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.1/dist/full.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  {{-- Vite --}}
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  {{-- Tambahan CSS --}}
  <style>
    body {
      font-family: 'Roboto', sans-serif;
    }

    .sidebar-item {
      color: white !important;
      background-color: transparent;
      transition: background 0.2s ease;
    }

    .sidebar-item:hover {
      background-color: #4c52e3 !important;
      color: white !important;
    }

    .sidebar-item.active {
      background-color: #5e64ff !important;
      color: white !important;
      font-weight: bold;
    }

    .menu summary {
      color: white !important;
    }

    .menu summary:hover {
      background-color: #4c52e3 !important;
      color: white !important;
    }

    .menu li ul li a {
      color: white !important;
      padding-left: 2.5rem;
    }

    .menu li ul li a:hover {
      background-color: #4c52e3 !important;
      color: white !important;
    }

    .menu li ul {
      background-color: transparent;
    }

    .sidebar-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 50;
    }

    .sidebar-open .sidebar-overlay {
      display: block;
    }

    html,
    body {
      overflow: hidden;
      height: 100%;
    }
  </style>
</head>

<body class="sidebar-closed">
  <div class="flex h-screen bg-gray-100">
    <div class="sidebar-overlay"></div>

    {{-- Sidebar --}}
    <div id="sidebar"
      class="fixed md:relative z-[60] w-64 h-full bg-[#3339CD] text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
      {{-- Logo Sidebar --}}
      <div class="md:hidden flex items-center justify-between px-4 py-3 border-b border-[#4c52e3]">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('/statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
          <span class="text-sm font-semibold leading-tight">UPT Puskesmas<br>Baloi Permai</span>
        </div>
        <button class="text-white text-2xl hover:text-gray-200" id="closeSidebar">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="hidden md:flex items-center px-6 py-5 space-x-4 border-b border-[#4c52e3]">
        <img src="{{ asset('/statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
        <div class="font-bold">
          <div class="text-lg">UPT Puskesmas</div>
          <div class="text-lg">Baloi Permai</div>
        </div>
      </div>

      <ul class="menu w-full rounded-box px-2 py-4 space-y-1">
        <li>
          <a href="{{ route('laboran.dashboard') }}"
            class="sidebar-item {{ Request::is('laboran/dashboard') ? 'active' : '' }}">
            <i class="fas fa-home w-5 text-center mr-3"></i> <span>Dashboard</span>
          </a>
        </li>
        <li>
          <a href="{{ route('laboran.pasien.index') }}"
            class="sidebar-item {{ Request::is('laboran/data-pasien') ? 'active' : '' }}">
            <i class="fas fa-user-injured w-5 text-center mr-3"></i> <span>Data Pasien</span>
          </a>
        </li>
        <li>
          <a href="{{ route('laboran.hasil-uji.index') }}"
            class="sidebar-item {{ Request::is('laboran/hasil-uji') ? 'active' : '' }}">
            <i class="fas fa-flask w-5 text-center mr-3"></i> <span>Hasil Uji Laboratorium</span>
          </a>
        </li>
        <li>
          <a href="#" id="logout-button" class="sidebar-item">
            <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i> <span>Logout</span>
          </a>
        </li>
      </ul>
    </div>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">
      <div class="navbar bg-[#EDEDED] text-black shadow-lg z-50 relative px-4">
        <button class="md:hidden btn btn-ghost btn-circle" id="openSidebar">
          <i class="fas fa-bars text-xl"></i>
        </button>
        <div class="flex-1">
          <h1 class="text-xl font-bold ml-2"></h1>
        </div>
        <div class="flex-none gap-4 items-center">
          <span class="text-sm font-semibold">Hi, {{ Auth::guard('staf')->user()->nama }}</span>
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar me-6 tooltip"
              data-tip="User Profile">
              <div class="w-10 h-10 rounded-full overflow-hidden">
                <img src="/statis/image/profile.jpg" class="w-full h-full object-cover" alt="Profile" />
              </div>
            </div>
            <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li>
                <a href="#" id="dropdownLogout">Logout</a>
                <form id="logout-form-dropdown" action="{{ route('staf.logout') }}" method="POST"
                  style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <main class="p-6 flex-1 overflow-y-auto" style="background-color: #F5F6FA">
        @yield('content')
      </main>
    </div>
  </div>

  {{-- Modal Logout --}}
  <div id="logout-modal" class="fixed inset-0 z-50 hidden justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
      <div class="text-center">
        <i class="fas fa-sign-out-alt text-red-500 text-4xl mb-4"></i>
        <h3 class="text-lg font-semibold mb-2">Anda yakin ingin logout?</h3>
        <div class="flex justify-center gap-3">
          <button type="button" id="cancelLogout"
            class="px-4 py-2 text-sm bg-gray-300 text-gray-700 rounded hover:bg-gray-400 min-w-[80px] h-9 flex items-center justify-center">Batal</button>
          <form id="logout-form" action="{{ route('staf.logout') }}" method="POST">
            @csrf
            <button type="submit"
              class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700 min-w-[80px] h-9 flex items-center justify-center">Keluar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  {{-- Flowbite Datepicker --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.0/datepicker.min.js"></script>

  {{-- Stack Scripts --}}
  @stack('scripts')
</body>

</html>