// resources/js/pages/rekam_medis/data_pasien.js
import { initFlowbite } from 'flowbite';

/* ===== Banner Notifikasi ===== */
function showBanner(type, message) {
  const wrap = document.getElementById('flash-banner');
  const box = document.getElementById('flash-banner-box');
  const icon = document.getElementById('flash-banner-icon'); // <svg>
  const msgEl = document.getElementById('flash-banner-message');
  const close = document.getElementById('flash-banner-close');
  if (!wrap || !box || !icon || !msgEl || !close) return;

  const baseBox = 'rounded-md border px-4 py-3 flex items-start gap-3';
  const palette = {
    success_add: ['bg-green-50', 'border-green-300', 'text-green-800'],
    success_edit: ['bg-blue-50', 'border-blue-300', 'text-blue-800'],
    success_delete: ['bg-red-50', 'border-red-300', 'text-red-800'],
    success_general: ['bg-green-50', 'border-green-300', 'text-green-800'],
    error: ['bg-red-50', 'border-red-300', 'text-red-800'],
    info: ['bg-blue-50', 'border-blue-300', 'text-blue-800'],
  }[type] || ['bg-green-50', 'border-green-300', 'text-green-800'];

  box.setAttribute('class', `${baseBox} ${palette.join(' ')}`);
  icon.setAttribute('class', `w-5 h-5 mt-0.5 ${palette[2]}`);
  icon.setAttribute('viewBox', '0 0 24 24');
  icon.setAttribute('fill', 'none');
  icon.setAttribute('stroke', 'currentColor');

  const paths = {
    error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    ok: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
  };
  icon.innerHTML = (type === 'error') ? paths.error : (type === 'info') ? paths.info : paths.ok;

  msgEl.textContent = message || '';
  wrap.classList.remove('hidden');
  close.onclick = () => wrap.classList.add('hidden');
  clearTimeout(window.__bannerTimer);
  window.__bannerTimer = setTimeout(() => wrap.classList.add('hidden'), 3000);
}

/* ===== Ambil Flash Message (robust) ===== */
function pickFlash() {
  try {
    if (window.__flashData && typeof window.__flashData === 'object') {
      const fd = window.__flashData;
      try { delete window.__flashData; } catch (_) { }
      if (fd?.type && fd?.message) return { type: fd.type, message: fd.message };
    }
  } catch (_) { }

  const main = document.getElementById('flash-bridge');
  if (main) {
    const t = main.getAttribute('data-type');
    const m = main.getAttribute('data-message');
    if (t && m) return { type: t, message: m };
  }

  const v = document.getElementById('flash-bridge-validation');
  if (v) {
    const t = v.getAttribute('data-type');
    const m = v.getAttribute('data-message');
    if (t && m) return { type: t, message: m };
  }

  return null;
}
function showFromBridge() {
  const fd = pickFlash();
  if (fd) requestAnimationFrame(() => showBanner(fd.type, fd.message));
}

/* ===== Page Ready ===== */
document.addEventListener('DOMContentLoaded', () => {
  initFlowbite();

  const http = window.axios; // gunakan axios global dari bootstrap.js
  const $ = (id) => document.getElementById(id);

  // EDIT: isi form + biarkan Flowbite buka modal via data-API
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-edit');
    if (!btn) return;

    const id = btn.dataset.id;
    const form = $('edit-form');
    if (form) {
      if (!form.getAttribute('data-action-template') && window.routeUpdateUrl) {
        form.setAttribute('data-action-template', window.routeUpdateUrl);
      }
      const tpl = form.getAttribute('data-action-template') || window.routeUpdateUrl || '';
      form.action = (tpl || '').replace(':id', id);
    }

    const setVal = (cid, val) => { const el = $(cid); if (el) el.value = val ?? ''; };
    setVal('pasien_id', id);
    setVal('edit_nama', btn.dataset.nama);
    setVal('edit_nik', btn.dataset.nik);
    setVal('edit_no_whatsapp', btn.dataset.wa);
    setVal('edit_tanggal_lahir', btn.dataset.lahir);
    setVal('edit_no_erm', btn.dataset.erm);
  });

  // HAPUS: set action + biarkan Flowbite buka modalnya
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-delete');
    if (!btn) return;
    const form = $('delete-form');
    if (form) form.action = btn.dataset.url || '#';
  });

  // VERIFIKASI: AJAX + banner; revert jika gagal
  document.addEventListener('change', async (e) => {
    const chk = e.target.closest('.verifikasi-checkbox');
    if (!chk) return;

    const id = chk.dataset.id;
    const url = (window.routeVerifikasiUrl || '').replace(':id', id);
    const wants = chk.checked;

    try {
      const fd = new FormData();
      fd.append('verifikasi', wants ? '1' : '0');

      const { data } = await http.post(url, fd);
      const type = (data && data.type) || (data && data.success ? 'success_general' : 'error');
      const msg = (data && data.message) || (data && data.success ? 'Status verifikasi diperbarui.' : 'Gagal memperbarui status verifikasi.');
      showBanner(type, msg);
    } catch (_) {
      chk.checked = !wants;
      showBanner('error', 'Gagal memperbarui status verifikasi.');
    }
  });

  // flash dari redirect (tambah/edit/hapus/validasi)
  showFromBridge();
});
