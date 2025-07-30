<script nonce="{{ $nonce }}">
    // Pastikan seluruh DOM (struktur halaman) sudah selesai dimuat sebelum menjalankan skrip.
    document.addEventListener('DOMContentLoaded', function () {
        // Mendapatkan referensi ke elemen modal utama berdasarkan ID 'popup-modal'.
        // Asumsi `Modal` adalah konstruktor dari pustaka seperti Flowbite.
        const modal = new Modal(document.getElementById('popup-modal'));

        // Mendapatkan referensi ke elemen ikon di dalam modal.
        const icon = document.getElementById('modal-icon');

        // Mendapatkan referensi ke elemen pesan di dalam modal.
        const messageElement = document.getElementById('modal-message'); // Perbaikan: menggunakan nama variabel yang konsisten

        // Mengambil pesan dari session Laravel.
        // `@json(session('modal_success') ?? session('modal_error'))` akan mengonversi nilai session
        // menjadi string JSON JavaScript. Ini akan mengambil 'modal_success' jika ada,
        // jika tidak maka mengambil 'modal_error'.
        const message = @json(session('modal_success') ?? session('modal_error'));

        // Menentukan apakah pesan yang diambil adalah error atau sukses.
        // `isError` akan `true` jika session 'modal_error' tidak kosong.
        const isError = @json(session('modal_error') !== null);

        // Memeriksa apakah ada pesan yang diterima dari session.
        if (message) {
            // Menetapkan teks pesan ke elemen di dalam modal.
            messageElement.innerText = message; // Perbaikan: menggunakan messageElement

            // Menghapus kelas warna ikon yang ada (hijau/merah) untuk persiapan penggantian.
            icon.classList.remove('text-green-500', 'text-red-500');
            // Menambahkan kelas warna ikon berdasarkan apakah itu pesan error atau sukses.
            // Jika `isError` true, tambahkan 'text-red-500', jika tidak, tambahkan 'text-green-500'.
            icon.classList.add(isError ? 'text-red-500' : 'text-green-500');

            // Menampilkan modal.
            modal.show();

            // Menyembunyikan modal secara otomatis setelah 2.5 detik (2500 milidetik).
            setTimeout(() => modal.hide(), 2500);
        }
    });
</script>