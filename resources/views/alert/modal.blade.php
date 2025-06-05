{{-- resources/views/alert/modal.blade.php --}}

<div id="popup-modal" tabindex="-1"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-[100] flex justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
            <div class="p-4 md:p-5 text-center">
                <svg id="modal-icon" class="mx-auto mb-4 w-12 h-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    {{-- Icon akan diisi oleh JS --}}
                </svg>
                <h3 class="mb-2 text-lg font-normal text-gray-500 dark:text-gray-400">
                    <span id="modal-message">Pesan</span>
                </h3>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const popupModalElement = document.getElementById('popup-modal');
        const iconElement = document.getElementById('modal-icon');
        const messageElement = document.getElementById('modal-message');

        // Pastikan Flowbite Modal & elemen tersedia
        if (typeof Modal !== 'undefined' && popupModalElement && iconElement && messageElement) {
            // Inisialisasi modal (Flowbite)
            const modal = new Modal(popupModalElement, { closable: false }); 

            // Buat fungsi global untuk menampilkan notifikasi
            window.showNotification = function(message, type = 'success', duration = 2500) {
                messageElement.innerText = message;
                iconElement.classList.remove('text-green-500', 'text-blue-500', 'text-red-500');

                const icons = {
                    checkmark: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                    error: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                };

                // Tentukan ikon dan warna berdasarkan tipe
                switch (type) {
                    case 'update': // Edit -> Biru
                        iconElement.innerHTML = icons.checkmark;
                        iconElement.classList.add('text-blue-500');
                        break;
                    case 'delete': // Hapus -> Merah
                        iconElement.innerHTML = icons.checkmark;
                        iconElement.classList.add('text-red-500');
                        break;
                    case 'error': // Error -> Merah (X)
                        iconElement.innerHTML = icons.error;
                        iconElement.classList.add('text-red-500');
                        duration = 3000; 
                        break;
                    case 'success': // Tambah / Default -> Hijau
                    default:
                        iconElement.innerHTML = icons.checkmark;
                        iconElement.classList.add('text-green-500');
                        break;
                }

                modal.show();
                setTimeout(() => modal.hide(), duration);
            };

            // Tangani session('success') dari Backend Laravel
            @if (session('success'))
                const message = "{{ session('success') }}";
                let type = 'success';
                if (message.toLowerCase().includes('diperbarui')) type = 'update';
                if (message.toLowerCase().includes('dihapus')) type = 'delete';
                window.showNotification(message, type);
            @endif

            // Tangani $errors dari Backend Laravel
            @if ($errors->any())
                const rawMessage = @json($errors->first());
                const translated = {
                    "The nik has already been taken.": "NIK sudah digunakan.",
                    "The no whatsapp has already been taken.": "Nomor WhatsApp sudah digunakan.",
                    "The no erm has already been taken.": "Nomor ERM sudah digunakan.",
                };
                const finalMessage = translated[rawMessage] ?? rawMessage;
                window.showNotification(finalMessage, 'error');
            @endif

        } else {
             console.error("Flowbite Modal atau #popup-modal tidak ditemukan. Notifikasi mungkin tidak berfungsi.");
        }
    });
</script>