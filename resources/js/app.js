// resources/js/app.js
import './bootstrap';
import axios from 'axios';
import 'flowbite';
import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.css';

// CSRF axios (biarkan seperti sebelumnya)
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
  axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
}

// Halaman Rekam Medis
import './pages/rekam_medis/data_pasien';
import './pages/rekam_medis/data_staf';   // <— TAMBAHKAN BARIS INI
import './pages/rekam_medis/logout_modal';
import './pages/laboran/logout_modal';
import './pages/laboran/flash_banner';
import './pages/laboran/pasien_modals';
import './pages/laboran/data_pasien';
import './pages/laboran/hasil_uji';

