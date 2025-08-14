window.showLogoutModal = function () {
  const modal = document.getElementById('logout-modal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
};

window.setActiveLogout = function () {
  const items = document.querySelectorAll('.sidebar-item');
  items.forEach(item => item.classList.remove('active'));
  const logoutBtn = document.getElementById('logout-button');
  if (logoutBtn) {
    logoutBtn.classList.add('active');
    console.log("Logout active ditambahkan");
  }
};
