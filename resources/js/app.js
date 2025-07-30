import './bootstrap'; // Jika Anda menggunakan bootstrap
import axios from 'axios'; // Pastikan axios diimpor

// ... (import flowbite, jquery, flatpickr, chart.js, dll.) ...


const csrfToken = document.head.querySelector('meta[name="csrf-token"]');

if (csrfToken) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
} else {
    console.error('CSRF token meta tag not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}