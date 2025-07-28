import { Modal } from 'flowbite';

// Global modal instance
let flowbitePopupModal;
let crudModal;
let editModal;
let deleteModal;

window.initModals = function () {
    const popupModalElement = document.getElementById('popup-modal');
    const crudModalElement = document.getElementById('crud-modal');
    const editModalElement = document.getElementById('edit-modal');
    const deleteModalElement = document.getElementById('delete-modal');

    if (popupModalElement) flowbitePopupModal = new Modal(popupModalElement);
    if (crudModalElement) crudModal = new Modal(crudModalElement);
    if (editModalElement) editModal = new Modal(editModalElement);
    if (deleteModalElement) deleteModal = new Modal(deleteModalElement);
};

window.showNotification = function (type, message) {
    if (!flowbitePopupModal) return;

    const icon = document.getElementById('modal-icon');
    const msg = document.getElementById('modal-message');
    icon.className = 'mx-auto mb-4 w-12 h-12';
    msg.innerText = message;

    const icons = {
        success_add: 'text-green-500',
        success_edit: 'text-blue-500',
        success_delete: 'text-red-500',
        success_general: 'text-green-500',
        error: 'text-red-500',
        info: 'text-blue-500'
    };

    const svgPaths = {
        check: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
    };

    icon.classList.add(icons[type] || 'text-green-500');
    icon.innerHTML = (type === 'error') ? svgPaths.error : (type === 'info') ? svgPaths.info : svgPaths.check;
    flowbitePopupModal.show();
    setTimeout(() => flowbitePopupModal.hide(), 2500);
};

window.confirmDelete = function (url) {
    if (!deleteModal) return;
    document.getElementById('delete-form').action = url;
    deleteModal.show();
};

window.closeDeleteModal = function () {
    if (deleteModal) deleteModal.hide();
};

window.editPasien = function (id, nama, nik, no_whatsapp, tanggal_lahir, no_erm) {
    if (!editModal) return;
    document.getElementById('pasien_id').value = id;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_nik').value = nik || '';
    document.getElementById('edit_no_whatsapp').value = no_whatsapp || '';
    document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
    document.getElementById('edit_no_erm').value = no_erm;

    const updateUrl = window.routeUpdateUrl.replace(':id', id);
    document.getElementById('edit-form').action = updateUrl;

    editModal.show();
};

window.setupNikInput = function (input) {
    if (!input) return;

    input.addEventListener('input', function () {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 16) value = value.slice(0, 16);
        this.value = value;
    });

    input.addEventListener('paste', function (event) {
        event.preventDefault();
        const pasted = event.clipboardData.getData('text').replace(/\D/g, '');
        this.value = (this.value + pasted).slice(0, 16);
    });

    input.addEventListener('invalid', function (e) {
        if (this.value && this.value.length !== 16) {
            e.target.setCustomValidity("NIK harus terdiri dari 16 digit angka.");
        } else {
            e.target.setCustomValidity("");
        }
    });

    input.addEventListener('input', function (e) {
        e.target.setCustomValidity("");
    });
};

document.addEventListener('DOMContentLoaded', function () {
    window.initModals();

    setupNikInput(document.getElementById('nik'));
    setupNikInput(document.getElementById('edit_nik'));

    const searchInput = document.getElementById('search-pasien');
    if (searchInput) {
        let timeoutId;
        searchInput.addEventListener('input', function () {
            clearTimeout(timeoutId);
            const query = this.value.trim();

            timeoutId = setTimeout(() => {
                const url = new URL(window.location);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }
                window.history.pushState({}, '', url);

                fetch(`/rekam_medis/data-pasien?search=${encodeURIComponent(query)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                }).then(res => res.text())
                    .then(html => {
                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const newTable = doc.getElementById('table-container');
                        document.getElementById('table-container').innerHTML = newTable.innerHTML;
                    }).catch(console.error);
            }, 300);
        });
    }

    // Verifikasi toggle (pakai jQuery)
    $('#table-container').on('change', '.verifikasi-checkbox', function () {
        const id = $(this).data('id');
        const isChecked = $(this).prop('checked');
        const checkbox = $(this);
        const url = window.routeVerifikasiUrl.replace(':id', id);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                verifikasi: isChecked ? 1 : 0,
                _token: window.csrfToken
            },
            success: function (response) {
                if (response.success) {
                    const msg = isChecked ? 'Data pasien telah berhasil diverifikasi.' : 'Verifikasi dibatalkan.';
                    showNotification('success_general', msg);
                } else {
                    showNotification('error', 'Gagal memperbarui status verifikasi.');
                    checkbox.prop('checked', !isChecked);
                }
            },
            error: function () {
                showNotification('error', 'Terjadi kesalahan saat update verifikasi.');
                checkbox.prop('checked', !isChecked);
            }
        });
    });
});
