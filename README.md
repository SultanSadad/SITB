# 🧪 SITB - Sistem Informasi Hasil Uji Laboratorium

**SITB** adalah aplikasi berbasis web untuk mengelola data pasien, hasil uji laboratorium, dan verifikasi rekam medis pasien TBC.  
Dibangun menggunakan **Laravel 10** dengan arsitektur berbasis role, SITB mempermudah proses administrasi, pengelolaan data, dan akses hasil uji bagi pasien secara aman dan terstruktur.

---

## ✨ Fitur Utama

### 1. **Laboran**
- CRUD data pasien (tambah, edit, hapus, cari).
- Upload hasil uji (file PDF/Dokumen).
- Filter hasil uji berdasarkan tanggal.
- Sorting & pagination dinamis.
- Modal konfirmasi & notifikasi (Flowbite).
- Upload & hapus file hasil uji di storage.

### 2. **Rekam Medis**
- Verifikasi status pasien (checkbox AJAX).
- Kelola data pasien terverifikasi.
- Akses dashboard statistik hasil uji.
- Laporan hasil uji per bulan dalam bentuk grafik.

### 3. **Pasien**
- Login dengan NIK & Nomor ERM.
- Melihat hasil uji laboratorium.
- Mengunduh hasil uji dalam format PDF.
- Dashboard ringkasan hasil uji.

---

## 👥 Aktor & Hak Akses

| Role | Deskripsi |
|---|---|
| **Laboran** | Mengelola data pasien & hasil uji laboratorium. |
| **Rekam Medis** | Memverifikasi pasien & mengelola rekam medis. |
| **Pasien** | Melihat & mengunduh hasil uji pribadi. |

---

## 🛠️ Teknologi yang Digunakan
- **Laravel 10**
- **PHP 8.2**
- **PostgreSQL**
- **Vite** untuk build asset
- **Flowbite + TailwindCSS** untuk UI
- **Chart.js** untuk visualisasi data


---

## 🚀 Cara Instalasi

### 1️⃣ Clone Repository
```bash masuk ke terminal
git clone [https://gitlab.com/sultan/sitb.git](https://gitlab.com/sultan/sitb.git)
- cd sitb
- composer install
- npm install
- cp .env.example .env

Atur konfigurasi database:
    DB_CONNECTION=pgsql
    DB_HOST=127.0.0.1
    DB_PORT=5432
    DB_DATABASE=sitb
    DB_USERNAME=postgres
    DB_PASSWORD=yourpassword

- php artisan key:generate
- php artisan migrate --seed
- php artisan storage:link
- php artisan serve
- npm run dev

*Kami berharap aplikasi ini dapat membantu tenaga medis dan pasien dalam memperoleh informasi kesehatan secara efisien, sekaligus menjadi langkah kecil  menuju pelayanan kesehatan yang lebih baik.