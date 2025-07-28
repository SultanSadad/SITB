// resources/js/pages/data_staf.js

import 'flowbite';
import $ from 'jquery';

let flowbitePopupModal, crudModal, editModalInstance, deleteModalInstance;

function initModals() {
    flowbitePopupModal = new Modal(document.getElementById('popup-modal'));
    crudModal = new Modal(document.getElementById('crud-modal'));
    editModalInstance = new Modal(document.getElementById('edit-modal'));
    deleteModalInstance = new Modal(document.getElementById('delete-modal'));
}

function showNotification(type, message) {
    const icon = document.getElementById('modal-icon');
    const msg = document.getElementById('modal-message');

    icon.className = 'mx-auto mb-4 w-12 h-12';
    icon.innerHTML = '';
    msg.innerText = message;

    const icons = {
        success: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />',
        info: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />'
    };

    if (['success_add', 'success_edit', 'success_delete', 'success_general', 'success'].includes(type)) {
        icon.classList.add('text-green-500');
        icon.innerHTML = icons.success;
    } else if (type === 'error') {
        icon.classList.add('text-red-500');
        icon.innerHTML = icons.error;
    } else if (type === 'info') {
        icon.classList.add('text-blue-500');
        icon.innerHTML = icons.info;
    }

    flowbitePopupModal.show();
    setTimeout(() => flowbitePopupModal.hide(), 2500);
}

function setupPasswordToggle(toggleId, inputId) {
    const toggle = document.getElementById(toggleId);
    const input = document.getElementById(inputId);
    if (toggle && input) {
        toggle.addEventListener('click', () => {
            const isPassword = input.getAttribute('type') === 'password';
            input.setAttribute('type', isPassword ? 'text' : 'password');
            toggle.classList.toggle('fa-eye');
            toggle.classList.toggle('fa-eye-slash');
        });
    }
}

function setupSearch() {
    const searchInput = document.getElementById('search-staf');
    const tableBody = document.getElementById('staf-table-body');
    const mobileCardsContainer = document.querySelector('.block.md\\:hidden.space-y-4');
    const paginationLinksContainer = document.getElementById('pagination-links');

    if (!searchInput) return;

    let timeout;
    searchInput.addEventListener('input', () => {
        clearTimeout(timeout);
        const query = searchInput.value;
        timeout = setTimeout(() => {
            fetch(`?q=${encodeURIComponent(query)}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    const doc = new DOMParser().parseFromString(html, 'text/html');
                    tableBody.innerHTML = doc.getElementById('staf-table-body').innerHTML;
                    mobileCardsContainer.innerHTML = doc.querySelector('.block.md\\:hidden.space-y-4').innerHTML;
                    paginationLinksContainer.innerHTML = doc.getElementById('pagination-links').innerHTML;
                });
        }, 300);
    });
}

function setupEditDeleteListeners() {
    document.getElementById('table-container').addEventListener('click', function (e) {
        const editBtn = e.target.closest('.edit-btn');
        if (editBtn) {
            e.preventDefault();
            const id = editBtn.dataset.id;
            fetch(`/petugas/rekam-medis/data-staf/${id}/edit-data`)
                .then(res => res.json())
                .then(data => {
                    document.getElementById('edit_nama').value = data.nama;
                    document.getElementById('edit_nip').value = data.nip;
                    document.getElementById('edit_email').value = data.email;
                    document.getElementById('edit_no_whatsapp').value = data.no_whatsapp;
                    document.getElementById('edit_peran').value = data.peran;
                    document.getElementById('edit-form').action = `/petugas/rekam-medis/data-staf/${id}`;
                    editModalInstance.show();
                })
                .catch(err => showNotification('error', err.message));
        }
    });

    window.confirmDelete = function (url) {
        document.getElementById('delete-form').action = url;
        deleteModalInstance.show();
    };
}

function initPasswordValidation() {
    document.getElementById('add-staf-form')?.addEventListener('submit', e => {
        const pass = document.getElementById('password').value;
        const confirm = document.getElementById('password_confirmation').value;
        if (pass !== confirm) {
            e.preventDefault();
            showNotification('error', 'Password dan konfirmasi tidak cocok.');
        }
    });

    document.getElementById('edit-form')?.addEventListener('submit', e => {
        const pass = document.getElementById('edit_password').value;
        const confirm = document.getElementById('edit_password_confirmation').value;
        if (pass && pass !== confirm) {
            e.preventDefault();
            showNotification('error', 'Password dan konfirmasi tidak cocok.');
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    try {
        initModals();
        setupPasswordToggle('togglePassword', 'password');
        setupPasswordToggle('toggleKonfirmasiPassword', 'password_confirmation');
        setupPasswordToggle('toggleEditPassword', 'edit_password');
        setupPasswordToggle('toggleEditConfirmPassword', 'edit_password_confirmation');
        setupSearch();
        setupEditDeleteListeners();
        initPasswordValidation();
    } catch (e) {
        console.error('Init Error:', e);
    }
});
