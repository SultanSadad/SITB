<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Laboran</title>

  <!-- DaisyUI & Tailwind -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.1/dist/full.min.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>

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
</head>

<body>
  <div class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <div id="sidebar"
      class="fixed md:relative z-[60] w-64 h-full bg-[#3339CD] text-white transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

      <!-- header sidebar (logo + close button) -->
      <div class="md:hidden flex items-center justify-between px-4 py-3">
        <img src="{{ asset('image/logoepus.png') }}" class="w-10 h-10" alt="Logo" />
        <button onclick="toggleSidebar()" class="text-white text-2xl">
          <i class="fas fa-times"></i>
        </button>
      </div>

      <!-- Logo -->
      <div class="hidden md:flex items-center justify-center h-16">
        <img src="{{ asset('image/logoepus.png') }}" class="w-12 h-12" alt="Logo" />
      </div>

      <div class="font-bold divider mb-2 text-center text-xl text-white">Meta Scane</div>

      <ul class="menu w-full rounded-box px-2">
        <li>
          <a href="/laboran/dashboard_laboran"class="sidebar-item {{ Request::is('laboran/dashboard_laboran') ? 'active' : '' }}"><i class="fas fa-home mr-2"></i>Dashboard</a>
        </li>
        <li>
        <a href="/laboran/hasil_uji"class="sidebar-item {{ Request::is('laboran/hasil_uji') ? 'active' : '' }}"><i class="fas fa-vial mr-2"></i>Hasil Uji TB</a>
        </li>
        <li>
          <a href="/login"class="sidebar-item {{ Request::is('login') ? 'active' : '' }}"><i class="fas fa-right-from-bracket mr-2"></i>Logout</a>
        </li>
      </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
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
          <span class="text-sm font-semibold">Hi, Laboran</span>
          <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar me-6" aria-label="User Profile">
              <div class="w-10 h-10 rounded-full overflow-hidden tooltip" data-tip="User Profile">
                <img src="/image/profile.jpg" class="w-full h-full object-cover" alt="Profile" />
              </div>
            </div>
            <ul tabindex="0" class="menu dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
              <li><a class="justify-between">Profile <span class="badge">New</span></a></li>
              <li><a href="/Login">Logout</a></li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Konten utama -->
      <main class="p-6 flex-1 overflow-y-auto" style="background-color: #F5F6FA">
        @yield('laboran')
      </main>
    </div>
  </div>

  <!-- Script Toggle Sidebar -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('-translate-x-full');
    }
  </script>
</body>

</html>