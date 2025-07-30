// resources/js/app.js

// Import dari versi lokal (config axios & bootstrap jika digunakan)
import './bootstrap'; // Jika Anda menggunakan bootstrap (ini dari starter kit Laravel)
import axios from 'axios'; // Pastikan axios diimpor

// Konfigurasi CSRF token untuk Axios
const csrfToken = document.head.querySelector('meta[name="csrf-token"]');
if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
} else {
    console.error('CSRF token meta tag not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Import dari versi remote (Flowbite dan JS spesifik halaman laboran)
import "flowbite";
import "./pages/laboran/dashboard";
import './pages/laboran/data_pasien';

// ... (tambahkan import lain seperti jquery, flatpickr, chart.js, dll. jika ada di file asli tapi terpotong di konflik ini) ...
// Contoh jika ada import lain yang hilang:
// import 'jquery';
// import 'flatpickr';
// import 'chart.js';