// resources/js/pages/laboran/data_pasien.js
// NOTE: Tidak ada initFlowbite() agar tidak bentrok data-API Flowbite.
import { Modal } from 'flowbite';

const $ = (sel, root = document) => root.querySelector(sel);
const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));
const get = (id) => document.getElementById(id);

/* -------------------- Modal Helpers -------------------- */
function buildModal(id) {
  const el = get(id);
  return el ? new Modal(el) : null;
}
const modals = {
  edit: buildModal('edit-modal'),
  del: buildModal('delete-modal'),
  crud: buildModal('crud-modal'),
  popup: buildModal('popup-modal'),
};

// fallback open untuk tombol "+ Tambah Pasien" (kalau tidak ingin data-API)
document.addEventListener('click', (e) => {
  const addBtn = e.target.closest('[data-modal-target="crud-modal"],[data-modal-toggle="crud-modal"]');
  if (addBtn && modals.crud) {
    e.preventDefault();
    modals.crud.show();
  }
});

// tutup modal untuk elemen yang punya data-modal-hide (tanpa initFlowbite)
$$('[data-modal-hide]').forEach(btn => {
  btn.addEventListener('click', (e) => {
    const targetId = btn.getAttribute('data-modal-hide');
    if (!targetId) return;
    if (targetId === 'crud-modal' && modals.crud) return modals.crud.hide();
    if (targetId === 'edit-modal' && modals.edit) return modals.edit.hide();
    if (targetId === 'delete-modal' && modals.del) return modals.del.hide();
    if (targetId === 'popup-modal' && modals.popup) return modals.popup.hide();
  });
});

/* -------------------- Edit & Delete actions -------------------- */
function setVal(id, val) { const el = get(id); if (el) el.value = val ?? ''; }

document.addEventListener('click', (e) => {
  // EDIT
  const eb = e.target.closest('.btn-edit');
  if (eb && modals.edit) {
    // Set form action
    const form = get('edit-form');
    const action = eb.dataset.updateUrl || '';
    if (form && action) form.action = action;

    // Isi field
    setVal('pasien_id', eb.dataset.id);
    setVal('edit_no_erm', eb.dataset.erm);
    setVal('edit_nama', eb.dataset.nama);
    setVal('edit_nik', eb.dataset.nik);
    setVal('edit_no_whatsapp', eb.dataset.wa);
    setVal('edit_tanggal_lahir', eb.dataset.lahir);

    modals.edit.show();
    return;
  }

  // DELETE
  const db = e.target.closest('.btn-delete');
  if (db && modals.del) {
    const form = get('delete-form');
    const url = db.dataset.url;
    if (form && url) form.action = url;
    modals.del.show();
    return;
  }
});

/* -------------------- Banner TST 3 detik -------------------- */
let hideTimer;
function setBoxStyle(box, type) {
  box.className = 'flex items-start gap-3 rounded-lg border px-4 py-3 text-sm';
  if (type === 'success') {
    box.classList.add('bg-green-50', 'border-green-200', 'text-green-800');
  } else if (type === 'error') {
    box.classList.add('bg-red-50', 'border-red-200', 'text-red-800');
  } else {
    box.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-800');
  }
}
function setIcon(icon, type) {
  // simple inline SVG paths (tanpa style inline)
  if (type === 'success') {
    icon.innerHTML = '<path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="12" cy="12" r="9" stroke-width="2"></circle>';
  } else if (type === 'error') {
    icon.innerHTML = '<path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
  } else {
    icon.innerHTML = '<circle cx="12" cy="12" r="9" stroke-width="2"></circle><path d="M12 8h.01M12 12v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
  }
}
function showBanner(type, message) {
  const wrap = get('inline-banner');
  const box = get('inline-banner-box');
  const icon = get('inline-banner-icon');
  const text = get('inline-banner-text');
  const close = get('inline-banner-close');
  if (!wrap || !box || !icon || !text) return;

  setBoxStyle(box, type);
  setIcon(icon, type);
  text.textContent = message || '';
  wrap.classList.remove('hidden');

  clearTimeout(hideTimer);
  hideTimer = setTimeout(() => wrap.classList.add('hidden'), 3000);

  if (close) {
    close.onclick = () => { clearTimeout(hideTimer); wrap.classList.add('hidden'); };
  }
}
window.tstBanner = { show: showBanner }; // kalau perlu dipanggil dari AJAX

// Auto-detect dari session bridge (elemen sudah ada di blade)
document.addEventListener('DOMContentLoaded', () => {
  // Prioritas error validasi
  if (document.body.dataset.hasErrors === '1') {
    const msg = document.body.dataset.firstError || 'Terjadi kesalahan.';
    return showBanner('error', msg);
  }

  const bridge = get('flash-bridge');
  if (!bridge) return;

  const s = bridge.getAttribute('data-success') || '';
  const e = bridge.getAttribute('data-error') || '';
  const nt = bridge.getAttribute('data-notif-type') || '';
  const nm = bridge.getAttribute('data-notif-message') || '';
  const st = bridge.getAttribute('data-success-type') || '';
  const sm = bridge.getAttribute('data-success-message') || '';

  if (s) return showBanner('success', s);
  if (e) return showBanner('error', e);

  if (nm) {
    const t = nt.includes('success') ? 'success' : (nt === 'error' ? 'error' : 'info');
    return showBanner(t, nm);
  }
  if (sm) {
    const t = st.includes('success') ? 'success' : (st === 'error' ? 'error' : 'info');
    return showBanner(t, sm);
  }
});
