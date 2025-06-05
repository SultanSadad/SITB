<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Pasien</title>

  <!-- DaisyUI & Tailwind -->

  @vite(['resources/css/app.css', 'resources/js/app.js'])


  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" />

  <!-- Google Font: Roboto -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

  <style>
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

    body {
      font-family: 'Roboto', sans-serif;
    }
  </style>
  <style>
    /* Tambahan agar tidak bisa di-scroll */
    html,
    body {
      overflow: hidden;
      height: 100%;
    }

    .sidebar-item {
      color: white !important;
      background-color: transparent;
      transition: background 0.2s ease;
    }

    /* ...sisa CSS kamu tetap seperti semula... */
  </style>
</head>

<body>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar Overlay (mobile only) -->
    <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <div id="sidebar"
      class="fixed md:relative z-[60] w-64 h-full bg-[#3339CD] text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

      <!-- Mobile Header -->
      <div class="md:hidden flex items-center justify-between px-4 py-3 border-b border-[#4c52e3]">
        <div class="flex items-center space-x-3">
          <img src="{{ asset('image/logoepus.png') }}" class="w-14 h-14" alt="Logo" />
          <span class="text-sm font-semibold leading-tight">UPT Puskesmas<br>Baloi Permai</span>
        </div>
        <button onclick="toggleSidebar()" class="text-white text-2xl hover:text-gray-200">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Desktop Header -->
      <div class="hidden md:flex items-center px-6 py-5 space-x-4 border-b border-[#4c52e3]">
        <img src="{{ asset('image/logoepus.png') }}" class="w-14 h-14" alt="Logo" />
        <div class="font-bold">
          <div class="text-lg">UPT Puskesmas</div>
          <div class="text-lg">Baloi Permai</div>
        </div>
      </div>
      <ul class="menu w-full rounded-box px-2 py-4 space-y-1">
        <li>
          <a href="{{ route('pasien.dashboard') }}"
            class="sidebar-item {{ Request::is('pasien/dashboard') ? 'active' : '' }}">
            <span class="flex items-center pl-1">
              <i class="fas fa-home w-5 text-center mr-3"></i>
              <span>Dashboard</span>
            </span>
          </a>
        </li>
        <li>
          <a href="{{ route('pasien.hasil_uji') }}"
            class="sidebar-item {{ request()->routeIs('pasien.hasil_uji*') ? 'active' : '' }}">
            <span class="flex items-center pl-1">
              <i class="fas fa-flask w-5 text-center mr-3"></i>
              <span>Hasil Uji Laboratorium</span>
            </span>
          </a>
        </li>
        <!-- Tombol Logout -->
        <li>
          <a href="#" id="logout-button" class="sidebar-item"
            onclick="event.preventDefault(); setActiveLogout(); showLogoutModal();">
            <span class="flex items-center pl-1">
              <i class="fas fa-sign-out-alt w-5 text-center mr-3"></i>
              <span>Logout</span>
            </span>
          </a>
        </li>

        <script>
          function setActiveLogout() {
            // Remove active class from all sidebar items
            document.querySelectorAll('.sidebar-item').forEach(item => {
              item.classList.remove('active');
            });

            // Add active class to logout button
            document.getElementById('logout-button').classList.add('active');
          }

          function showLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
          }

          function hideLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
            // Optional: Remove active state when modal is closed
            document.getElementById('logout-button').classList.remove('active');
          }
        </script>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Navbar -->
      <div class="navbar bg-[#EDEDED] text-black shadow-lg z-50 relative px-4">
        <!-- Hamburger untuk mobile -->
        <button class="md:hidden btn btn-ghost btn-circle" onclick="toggleSidebar()">
          <i class="fas fa-bars text-xl"></i>
        </button>

        <div class="flex-1">
          <h1 class="text-xl font-bold ml-2"></h1>
        </div>

        <div class="flex-none gap-4 items-center">
          <span class="text-sm font-semibold">Hi, {{ Auth::user()->name }}</span>
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar me-6" aria-label="User Profile">
              <div class="w-10 h-10 rounded-full overflow-hidden tooltip" data-tip="User Profile">
                <img src="/image/profile.jpg" class="w-full h-full object-cover" alt="Profile" />
              </div>
            </div>
            <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li>
                <a href="#" class="block w-full text-left px-4 py-2 hover:bg-gray-100"
                  onclick="event.preventDefault(); showLogoutModal();">
                  Logout
                </a>

                <form id="logout-form-dropdown" action="{{ route('pasien.logout') }}" method="POST"
                  style="display: none;">
                  @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Main Content -->
      <main class="p-6 flex-1 overflow-y-auto" style="background-color: #F5F6FA">
        @yield('pasien')
      </main>
    </div>
  </div>
  <div id="logout-modal" tabindex="-1"
    class="hidden fixed inset-0 z-50 justify-center items-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
      <div class="text-center">
        <i class="fas fa-sign-out-alt text-red-500 text-4xl mb-4"></i>
        <h2 class="text-lg font-semibold mb-2">Anda yakin ingin keluar?</h1>
          <div class="flex justify-center gap-3">
            <button onclick="hideLogoutModal()"
              class="px-4 py-2 text-sm bg-gray-300 rounded hover:bg-gray-400">Batal</button>
            <form id="logout-form" action="{{ route('pasien.logout') }}" method="POST">
              @csrf
              <button type="submit"
                class="px-4 py-2 text-sm bg-red-600 text-white rounded hover:bg-red-700">Keluar</button>
            </form>
          </div>
      </div>
    </div>
  </div>

  <!-- Script Toggle Sidebar -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      document.body.classList.toggle('sidebar-open');
      sidebar.classList.toggle('-translate-x-full');

      // Prevent scrolling when sidebar is open on mobile
      if (document.body.classList.contains('sidebar-open')) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    }

    // Close sidebar when clicking on a menu item (mobile only)
    document.querySelectorAll('.sidebar-item').forEach(item => {
      item.addEventListener('click', function () {
        if (window.innerWidth < 768) {
          toggleSidebar();
        }
      });
    });
  </script>

  <script>
    function showLogoutModal() {
  const modal = document.getElementById('logout-modal');
  modal.classList.remove('hidden');
  modal.classList.add('flex'); // tambahkan flex hanya saat ditampilkan
}

function hideLogoutModal() {
  const modal = document.getElementById('logout-modal');
  modal.classList.remove('flex'); // hapus flex saat ditutup
  modal.classList.add('hidden');
}

  </script>
  
</body>

</html>