{{-- Nama File : pasien.blade.php --}}
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Dashboard Pasien</title>

  @php($nonce = session('csp_nonce_session') ?? request()->attributes->get('csp_nonce'))

  @env('production')
    <link rel="stylesheet" href="{{ asset('build/assets/app.css') }}" nonce="{{ $nonce }}">
    <script type="module" src="{{ asset('build/assets/app.js') }}" nonce="{{ $nonce }}"></script>
  @else
  @php($viteClient = '@vite/client') {{-- hindari directive --}}
  <script type="module" src="http://localhost:5173/{{ $viteClient }}" nonce="{{ $nonce }}"></script>
  <script type="module" src="http://localhost:5173/resources/js/app.js" nonce="{{ $nonce }}"></script>
  <link rel="stylesheet" href="http://localhost:5173/resources/css/app.css" nonce="{{ $nonce }}">
  @endenv

  {{-- penting: tempatkan stacks --}}
  @stack('styles')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  {{-- Styles khusus layout --}}
  <style nonce="{{ $nonce ?? '' }}">
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
  </style>

  {{-- tempat inject style dari child --}}
  @stack('styles')
</head>

<body class="bg-gray-100">
  <div class="flex h-screen">
    <div class="sidebar-overlay" data-toggle-sidebar></div>

    <aside id="sidebar"
      class="fixed md:relative z-[60] w-64 h-full bg-[#3339CD] text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

      <div class="md:hidden flex items-center justify-between px-4 py-3 border-b border-[#4c52e3]">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
          <span class="text-sm font-semibold leading-tight">UPT Puskesmas<br>Baloi Permai</span>
        </div>
        <button class="text-white text-2xl hover:text-gray-200" data-toggle-sidebar>
          <i class="fas fa-times"></i>
        </button>
      </div>

      <div class="hidden md:flex items-center px-6 py-5 space-x-4 border-b border-[#4c52e3]">
        <img src="{{ asset('statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
        <div class="font-bold">
          <div class="text-lg">UPT Puskesmas</div>
          <div class="text-lg">Baloi Permai</div>
        </div>
      </div>

      <ul class="menu w-full rounded-box px-2 py-4 space-y-1">
        <li>
          <a href="{{ route('pasien.dashboard') }}"
            class="sidebar-item {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
            <span class="flex items-center pl-1">
              <i class="fas fa-home w-5 text-center mr-3"></i><span>Dashboard</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{ route('pasien.hasil-uji.index') }}"
            class="sidebar-item {{ request()->routeIs('pasien.hasil-uji*') ? 'active' : '' }}">
            <span class="flex items-center pl-1">
              <i class="fas fa-flask w-5 text-center mr-3"></i><span>Hasil Uji Laboratorium</span>
            </span>
          </a>
        </li>
        <li>
          <a href="#" class="sidebar-item" data-open-logout>
            <span class="flex items-center pl-1">
              <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i><span>Logout</span>
            </span>
          </a>
        </li>
      </ul>
    </aside>

    <div class="flex-1 flex flex-col overflow-hidden">
      <div class="navbar bg-[#EDEDED] text-black shadow-lg z-50 relative px-4">
        <button class="md:hidden btn btn-ghost btn-circle" data-toggle-sidebar>
          <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="flex-1">
          <h1 class="text-xl font-bold ml-2"></h1>
        </div>

        <div class="flex-none gap-4 items-center">
          <span class="text-sm font-semibold">Hi, {{ Auth::guard('pasien')->user()->nama }}</span>
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar me-6 tooltip" data-tip="User Profile"
              aria-label="User Profile">
              <div class="w-10 h-10 rounded-full overflow-hidden">
                <img src="/statis/image/profile.jpg" class="w-full h-full object-cover" alt="Profile" />
              </div>
            </div>
            <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li>
                <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100" data-open-logout>Logout</a>
                <form id="logout-form-dropdown" action="{{ route('pasien.logout') }}" method="POST" class="hidden">@csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <main class="p-6 flex-1 overflow-y-auto bg-[#F5F6FA]">
        @yield('pasien')
      </main>
    </div>
  </div>

  {{-- Modal Logout --}}
  <div id="logout-modal" tabindex="-1"
    class="hidden fixed inset-0 z-[9999] justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
      <div class="text-center">
        <i class="fas fa-sign-out-alt text-red-500 text-4xl mb-4"></i>
        <h2 class="text-lg font-semibold mb-2">Anda yakin ingin keluar?</h2>

        <div class="flex justify-center gap-3">
          <button type="button" data-close-logout class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">
            Batal
          </button>

          <form id="logout-form" action="{{ route('pasien.logout') }}" method="POST">
            @csrf
            <button type="button" data-confirm-logout class="px-4 py-2 text-sm bg-red-600 text-white rounded"
              style="border:1px solid rgba(0,0,0,.06)"> <!-- debug border -->
              Keluar
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>


  {{-- JS layout (pakai nonce, tanpa inline handler) --}}
  <script type="module" nonce="{{ $nonce ?? '' }}">
    const $ = s => document.querySelector(s);
    const $$ = s => document.querySelectorAll(s);

    const body = document.body;
    const sidebar = $('#sidebar');

    // === Sidebar toggle (kode kamu) ===
    const toggleSidebar = () => {
      body.classList.toggle('sidebar-open');
      sidebar.classList.toggle('-translate-x-full');
      body.style.overflow = body.classList.contains('sidebar-open') ? 'hidden' : '';
    };
    $$('[data-toggle-sidebar]').forEach(b => b.addEventListener('click', toggleSidebar));

    // Tutup sidebar saat klik menu di mobile (kode kamu)
    $$('.sidebar-item').forEach(a => a.addEventListener('click', () => {
      if (window.innerWidth < 768 && body.classList.contains('sidebar-open')) toggleSidebar();
    }));

    // === Modal Logout (gabungan + perbaikan) ===
    const logoutModal = $('#logout-modal');
    const showLogout = () => {
      // pastikan overlay sidebar tidak menghalangi saat modal muncul
      body.classList.remove('sidebar-open');
      logoutModal.classList.remove('hidden');
      logoutModal.classList.add('flex');
    };
    const hideLogout = () => {
      logoutModal.classList.remove('flex');
      logoutModal.classList.add('hidden');
    };

    // buka modal (link di sidebar & dropdown)
    $$('[data-open-logout]').forEach(a => a.addEventListener('click', e => {
      e.preventDefault();
      showLogout();
    }));

    // tutup modal
    $$('[data-close-logout]').forEach(b => b.addEventListener('click', hideLogout));

    // 🔴 submit pasti tembus walau ada overlay/z-index aneh
    const logoutForm = $('#logout-form');
    $$('[data-confirm-logout]').forEach(b =>
      b.addEventListener('click', () => logoutForm?.submit())
    );

    // ekstra aman: cegah submit ganda
    if (logoutForm) {
      logoutForm.addEventListener('submit', () => {
        $$('[data-confirm-logout]').forEach(btn => btn.disabled = true);
      });
    }
  </script>

  {{-- tempat inject script dari child --}}
  @stack('scripts')

</body>

</html>