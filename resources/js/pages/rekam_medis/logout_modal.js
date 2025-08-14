// resources/js/pages/rekam_medis/logout_modal.js
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
  // buka modal dari semua pemicu
  document.querySelectorAll('[data-open-logout]').forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      setActiveLogout();
      showLogoutModal();
    });
  });

  // tutup modal
  document.querySelectorAll('[data-close-logout]').forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      hideLogoutModal();
    });
  });

  // klik overlay untuk tutup
  const overlay = document.getElementById('logout-modal');
  if (overlay) {
    overlay.addEventListener('click', (e) => {
      if (e.target === overlay) hideLogoutModal();
    });
  }
});
