// resources/js/pages/laboran/logout_modal.js

function showLogoutModal() {
  const modal = document.getElementById('logout-modal');
  if (modal) {
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }
}

function hideLogoutModal() {
  const modal = document.getElementById('logout-modal');
  if (modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
}

function setActiveLogout() {
  document.querySelectorAll('.sidebar-item').forEach(el => el.classList.remove('active'));
  const logoutBtn = document.getElementById('logout-button');
  if (logoutBtn) logoutBtn.classList.add('active');
}

document.addEventListener('DOMContentLoaded', () => {
  // Bind semua trigger pembuka modal
  const openers = document.querySelectorAll('[data-open-logout]');
  if (openers.length) {
    openers.forEach(el => {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        setActiveLogout();
        showLogoutModal();
      });
    });
  }

  // Bind tombol batal/close
  const closers = document.querySelectorAll('[data-close-logout]');
  if (closers.length) {
    closers.forEach(el => {
      el.addEventListener('click', (e) => {
        e.preventDefault();
        hideLogoutModal();
      });
    });
  }

  // Klik di overlay untuk menutup
  const overlay = document.getElementById('logout-modal');
  if (overlay) {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) hideLogoutModal();
    });
  }
});
