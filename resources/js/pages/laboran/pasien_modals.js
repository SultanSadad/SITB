// resources/js/pages/laboran/pasien_modals.js
import { Modal, initFlowbite } from 'flowbite';

document.addEventListener('DOMContentLoaded', () => {
  try { initFlowbite(); } catch { }

  const editEl = document.getElementById('edit-modal');
  const deleteEl = document.getElementById('delete-modal');
  const editModal = editEl ? new Modal(editEl) : null;
  const deleteModal = deleteEl ? new Modal(deleteEl) : null;

  // Delegasi klik EDIT
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-edit');
    if (!btn || !editModal) return;

    // SET NILAI FORM
    document.getElementById('pasien_id').value = btn.dataset.id || '';
    document.getElementById('edit_no_erm').value = btn.dataset.erm || '';
    document.getElementById('edit_nama').value = btn.dataset.nama || '';
    document.getElementById('edit_nik').value = btn.dataset.nik || '';
    document.getElementById('edit_no_whatsapp').value = btn.dataset.wa || '';
    document.getElementById('edit_tanggal_lahir').value = btn.dataset.lahir || '';

    // PENTING: SET ACTION KE /petugas/laboran/data-pasien/{id}
    const actionUrl = btn.dataset.updateUrl; // di Blade: data-update-url="{{ route('laboran.pasien.update', $pasien->id) }}"
    const form = document.getElementById('edit-form');
    if (form && actionUrl) {
      form.setAttribute('action', actionUrl);
    } else {
      console.warn('Update URL tidak ada pada tombol Edit');
    }

    editModal.show();
  });

  // Guard: cegah submit kalau action belum ber-ID
  const editForm = document.getElementById('edit-form');
  if (editForm) {
    editForm.addEventListener('submit', (ev) => {
      const ok = /\/petugas\/laboran\/data-pasien\/\d+$/.test(editForm.action);
      if (!ok) {
        ev.preventDefault();
        alert('Form action belum diset (ID hilang). Klik tombol Edit dari baris pasien, lalu Simpan.');
      }
    });
  }

  // Delegasi klik HAPUS
  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-delete');
    if (!btn || !deleteModal) return;
    const form = document.getElementById('delete-form');
    if (form) form.action = btn.dataset.url || '';
    deleteModal.show();
  });
});
