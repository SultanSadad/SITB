// resources/js/pages/rekam_medis/data_staf.js
import { Modal, initFlowbite } from 'flowbite';

// Jalan hanya kalau elemen halaman staf ada
if (document.getElementById('staf-table-body')) {
  // Hindari double init saat HMR / reload Vite
  if (window.__RM_DS_INIT__) {
    document.removeEventListener('click', window.__RM_DS_CLICK_HOOK || (() => { }));
  }
  window.__RM_DS_INIT__ = true;

  /* ============== Banner dekat tabel ============== */
  function showBanner(type, message) {
    const wrap = document.getElementById('flash-banner');
    const box = document.getElementById('flash-banner-box');
    const icon = document.getElementById('flash-banner-icon');
    const msgEl = document.getElementById('flash-banner-message');
    const close = document.getElementById('flash-banner-close');
    if (!wrap || !box || !icon || !msgEl || !close) return;

    const baseBox = 'rounded-md border px-4 py-3 flex items-start gap-3';
    const pal = {
      success_add: ['bg-green-50', 'border-green-300', 'text-green-800'],
      success_edit: ['bg-blue-50', 'border-blue-300', 'text-blue-800'],
      success_delete: ['bg-red-50', 'border-red-300', 'text-red-800'],
      success_general: ['bg-green-50', 'border-green-300', 'text-green-800'],
      success: ['bg-green-50', 'border-green-300', 'text-green-800'],
      error: ['bg-red-50', 'border-red-300', 'text-red-800'],
      info: ['bg-blue-50', 'border-blue-300', 'text-blue-800'],
    }[type] || ['bg-green-50', 'border-green-300', 'text-green-800'];

    box.className = `${baseBox} ${pal.join(' ')}`;
    icon.setAttribute('class', `w-5 h-5 mt-0.5 ${pal[2]}`);
    icon.setAttribute('viewBox', '0 0 24 24');
    icon.setAttribute('fill', 'none');
    icon.setAttribute('stroke', 'currentColor');

    const paths = {
      ok: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
      error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
      info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    };
    icon.innerHTML = (type === 'error') ? paths.error : (type === 'info') ? paths.info : paths.ok;

    msgEl.textContent = message || '';
    wrap.classList.remove('hidden');

    close.onclick = () => wrap.classList.add('hidden');

    clearTimeout(window.__stafBannerTimer);
    window.__stafBannerTimer = setTimeout(() => wrap.classList.add('hidden'), 3000);
  }

  function showFromBridge() {
    const read = (el) => el ? { type: el.getAttribute('data-type'), message: el.getAttribute('data-message') } : null;
    const fd = read(document.getElementById('flash-bridge'))
      || read(document.getElementById('flash-bridge-validation'));
    if (fd && fd.type && fd.message) requestAnimationFrame(() => showBanner(fd.type, fd.message));
  }

  /* ============== Helpers form ============== */
  function toggleEye(toggleId, inputId) {
    const t = document.getElementById(toggleId);
    const i = document.getElementById(inputId);
    if (!t || !i) return;
    t.addEventListener('click', () => {
      const isPw = i.type === 'password';
      i.type = isPw ? 'text' : 'password';
      t.classList.toggle('fa-eye');
      t.classList.toggle('fa-eye-slash');
    });
  }

  function enforceDigits() {
    document.querySelectorAll('.only-digits').forEach((el) => {
      el.addEventListener('input', () => { el.value = el.value.replace(/\D+/g, ''); });
    });
    document.querySelectorAll('.only-digits-plus').forEach((el) => {
      el.addEventListener('input', () => { el.value = el.value.replace(/[^0-9+]+/g, ''); });
    });
  }

  /* ============== Live search (AJAX) ============== */
  function liveSearch() {
    const input = document.getElementById('search-staf');
    const tableBody = document.getElementById('staf-table-body');
    const mobileCards = document.querySelector('.block.md\\:hidden.space-y-4');
    const pag = document.getElementById('pagination-links');
    if (!input || !tableBody || !mobileCards || !pag) return;

    let timer;
    input.addEventListener('input', () => {
      clearTimeout(timer);
      timer = setTimeout(async () => {
        try {
          const q = encodeURIComponent(input.value || '');
          const res = await fetch(`?q=${q}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
          const html = await res.text();
          const doc = new DOMParser().parseFromString(html, 'text/html');
          const tb = doc.getElementById('staf-table-body');
          const mc = doc.querySelector('.block.md\\:hidden.space-y-4');
          const pg = doc.getElementById('pagination-links');
          if (tb) tableBody.innerHTML = tb.innerHTML;
          if (mc) mobileCards.innerHTML = mc.innerHTML;
          if (pg) pag.innerHTML = pg.innerHTML;

          // Elemen data-API Flowbite perlu di-init ulang
          initFlowbite();
        } catch {
          showBanner('error', 'Gagal memuat pencarian.');
        }
      }, 300);
    });
  }

  /* ============== Edit & Delete ============== */
  let editModal = null;
  let deleteModal = null;

  function wireEditDelete() {
    const editEl = document.getElementById('edit-modal');
    const deleteEl = document.getElementById('delete-modal');

    if (editEl && !editModal) editModal = new Modal(editEl);
    if (deleteEl && !deleteModal) deleteModal = new Modal(deleteEl);

    const clickHook = async (e) => {
      // EDIT
      const eb = e.target.closest('.edit-btn');
      if (eb) {
        e.preventDefault();
        const id = eb.dataset.id;
        try {
          const res = await fetch(`/petugas/rekam-medis/data-staf/${id}/edit-data`);
          if (!res.ok) throw new Error('HTTP ' + res.status);
          const data = await res.json();

          const set = (i, v) => { const el = document.getElementById(i); if (el) el.value = (v ?? ''); };
          set('edit_nama', data.nama);
          set('edit_nip', data.nip);
          set('edit_email', data.email);
          set('edit_no_whatsapp', data.no_whatsapp);
          const role = document.getElementById('edit_peran'); if (role) role.value = data.peran;
          const form = document.getElementById('edit-form'); if (form) form.action = `/petugas/rekam-medis/data-staf/${id}`;

          editModal?.show();
        } catch {
          showBanner('error', 'Gagal memuat data staf.');
        }
        return;
      }

      // DELETE
      const db = e.target.closest('.btn-delete');
      if (db) {
        e.preventDefault();
        const url = db.dataset.url;
        const form = document.getElementById('delete-form');
        if (form && url) form.action = url;
        deleteModal?.show();
        return;
      }
    };

    // Simpan agar bisa dihapus saat HMR
    window.__RM_DS_CLICK_HOOK = clickHook;
    document.addEventListener('click', clickHook);
  }

  /* ============== Validasi password (client) ============== */
  function passwordValidation() {
    const addForm = document.getElementById('add-staf-form');
    if (addForm) {
      addForm.addEventListener('submit', (e) => {
        const p = document.getElementById('password')?.value || '';
        const c = document.getElementById('password_confirmation')?.value || '';
        if (p !== c) { e.preventDefault(); showBanner('error', 'Password dan konfirmasi tidak cocok.'); }
      });
    }
    const editForm = document.getElementById('edit-form');
    if (editForm) {
      editForm.addEventListener('submit', (e) => {
        const p = document.getElementById('edit_password')?.value || '';
        const c = document.getElementById('edit_password_confirmation')?.value || '';
        if (p && p !== c) { e.preventDefault(); showBanner('error', 'Password dan konfirmasi tidak cocok.'); }
      });
    }
  }

  /* ============== Boot ============== */
  document.addEventListener('DOMContentLoaded', () => {
    initFlowbite();

    toggleEye('togglePassword', 'password');
    toggleEye('toggleKonfirmasiPassword', 'password_confirmation');
    toggleEye('toggleEditPassword', 'edit_password');
    toggleEye('toggleEditConfirmPassword', 'edit_password_confirmation');

    enforceDigits();
    liveSearch();
    wireEditDelete();
    passwordValidation();
    showFromBridge();
  });
}
