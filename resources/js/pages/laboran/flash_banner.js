// resources/js/pages/laboran/flash_banner.js
let hideTimer;

function el(id) { return document.getElementById(id); }

function setBoxStyle(box, type) {
  box.className = 'flex items-start gap-3 rounded-lg border px-4 py-3 text-sm';
  if (type === 'success') { box.classList.add('bg-green-50', 'border-green-200', 'text-green-800'); }
  else if (type === 'error') { box.classList.add('bg-red-50', 'border-red-200', 'text-red-800'); }
  else { box.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-800'); }
}

function setIcon(icon, type) {
  if (type === 'success') {
    icon.innerHTML = '<path d="M9 12l2 2 4-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path><circle cx="12" cy="12" r="9" stroke-width="2"></circle>';
  } else if (type === 'error') {
    icon.innerHTML = '<path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
  } else {
    icon.innerHTML = '<circle cx="12" cy="12" r="9" stroke-width="2"></circle><path d="M12 8h.01M12 12v4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>';
  }
}

function showBanner(type, message) {
  const wrap = el('inline-banner'), box = el('inline-banner-box');
  const icon = el('inline-banner-icon'), text = el('inline-banner-text'), close = el('inline-banner-close');
  if (!wrap || !box || !icon || !text) return;

  setBoxStyle(box, type);
  setIcon(icon, type);
  text.textContent = message || '';
  wrap.classList.remove('hidden');

  clearTimeout(hideTimer);
  hideTimer = setTimeout(() => wrap.classList.add('hidden'), 3000);
  if (close) { close.onclick = () => { clearTimeout(hideTimer); wrap.classList.add('hidden'); }; }
}

window.tstBanner = { show: showBanner };

document.addEventListener('DOMContentLoaded', () => {
  const bridge = el('flash-bridge');

  // Validasi gagal?
  if (document.body.dataset.hasErrors === '1') {
    showBanner('error', document.body.dataset.firstError || 'Terjadi kesalahan.');
    return;
  }

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
    const t = (nt && nt.includes('success')) ? 'success' : (nt === 'error' ? 'error' : 'info');
    return showBanner(t, nm);
  }
  if (sm) {
    const t = (st && st.includes('success')) ? 'success' : (st === 'error' ? 'error' : 'info');
    return showBanner(t, sm);
  }
});
