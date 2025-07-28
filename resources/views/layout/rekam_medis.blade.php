{{-- Nama File   = rekam_medis.blade.php --}}
{{-- Deskripsi   = Template layout untuk halaman dashboard rekam medis --}}
{{-- Dibuat oleh = Sultan Sadad - 3312301102 --}}
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Rekam Medis</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @vite('resources/js/sidebar_rekam_medis.js')




  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  <style nonce="{{ request()->attributes->get('csp_nonce') }}">
    /* Styling dasar untuk item sidebar */
    .sidebar-item { color: white !important; background-color: transparent; transition: background 0.2s ease; }
    .sidebar-item:hover { background-color: #4c52e3 !important; color: white !important; }
    .sidebar-item.active { background-color: #5e64ff !important; color: white !important; font-weight: bold; }
    /* Styling untuk ringkasan menu (jika ada dropdown) */
    .menu summary { color: white !important; }
    .menu summary:hover x{ background-color: #4c52e3 !important; color: white !important; }
    /* Styling untuk submenu item */
    .menu li ul li a { color: white !important; padding-left: 2.5rem; }
    .menu li ul li a:hover { background-color: #4c52e3 !important; color: white !important; }
    .menu li ul { background-color: transparent; }
    /* Font family global */
    body { font-family: 'Roboto', sans-serif; }

    /* Overlay untuk sidebar di perangkat mobile */
    .sidebar-overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 50; }
    .sidebar-open .sidebar-overlay { display: block; }

    /* Mencegah scrolling pada body saat sidebar mobile terbuka */
    html, body { overflow: hidden; height: 100%; }
</style>
</head>

<body class="sidebar-closed">
  <div class="flex h-screen bg-gray-100">
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <div id="sidebar"
      class="fixed md:relative z-[60] w-64 h-full bg-[#3339CD] text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

      <div class="md:hidden flex items-center justify-between px-4 py-3 border-b border-[#4c52e3]">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('/statis/image/logoepus.png') }}" class="w-14 h-14" alt="Logo Puskesmas" />
          <span class="text-sm font-semibold leading-tight">UPT Puskesmas<br>Baloi Permai</span>
        </div>
        <button onclick="toggleSidebar()" class="text-white text-2xl hover:text-gray-200">
          <i class="fas fa-times"></i> </button>
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
          // Menentukan apakah menu 'Users' harus terbuka (active)
          $userMenuActive = Str::contains(Request::path(), [
            'rekam-medis/data-pasien',
            'rekam-medis/data-staf',
          ]);
        @endphp
        <li>
          <details {{ $userMenuActive ? 'open' : '' }}> <summary class="{{ $userMenuActive ? 'font-bold text-white' : '' }}">
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

        <li>
          <a href="#" id="logout-button" class="sidebar-item"
            onclick="event.preventDefault(); setActiveLogout(); showLogoutModal();">
            <span class="flex items-center pl-1">
              <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>
              <span>Logout</span>
            </span>
          </a>
        </li>

        <script nonce="{{ request()->attributes->get('csp_nonce') }}">
          // Menetapkan status 'active' pada tombol logout
          function setActiveLogout() {
            const items = document.querySelectorAll('.sidebar-item');
            items.forEach(item => item.classList.remove('active'));

            const logoutBtn = document.getElementById('logout-button');
            if (logoutBtn) {
              logoutBtn.classList.add('active');
              console.log("Logout active ditambahkan");
            } else {
              console.log("Element logout-button tidak ditemukan");
            }
          }

          // Catatan: Fungsi showLogoutModal() di sini mungkin belum didefinisikan lengkap
          // Definisi lengkapnya ada di bagian bawah file ini.
          function showLogoutModal() {
            console.log("Modal Logout ditampilkan (dari sidebar)"); // Debugging
            const modal = document.getElementById('logout-modal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
          }
        </script>
      </ul>
    </div>

    <div class="flex-1 flex flex-col overflow-hidden">
      <div class="navbar bg-[#EDEDED] text-black shadow-lg z-50 relative px-4">
        <button class="md:hidden btn btn-ghost btn-circle" onclick="toggleSidebar()">
          <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="flex-1">
          <h1 class="text-xl font-bold ml-2"></h1> </div>

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
                <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                  onclick="event.preventDefault(); showLogoutModal();">
                  Logout
                </a>
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
        @yield('rekam_medis') </main>
    </div>
  </div>

  <div id="logout-modal" tabindex="-1"
    class="hidden fixed inset-0 z-50 justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
      <div class="text-center">
        <i class="fas fa-sign-out-alt text-red-500 text-4xl mb-4"></i> <h3 class="text-lg font-semibold mb-2">Anda yakin ingin logout?</h3>
        <div class="flex justify-center gap-3">
          <button onclick="hideLogoutModal()"
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
</body>
{{-- Inject chartLabels dan yearlyStats ke JS global window --}}
<script nonce="{{ request()->attributes->get('csp_nonce') }}">
    window.chartLabels = @json($chartLabels);
    window.yearlyStats = @json($yearlyStats);
</script>

{{-- ChartJS CDN + Vite compiled JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@vite('resources/js/pages/rekam_medis/dashboard.js')
</html>