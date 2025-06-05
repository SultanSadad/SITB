<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new Modal(document.getElementById('popup-modal'));
        const icon = document.getElementById('modal-icon');
        const message = @json(session('modal_success') ?? session('modal_error'));
        const isError = @json(session('modal_error') !== null);

        if (message) {
            document.getElementById('modal-message').innerText = message;

            icon.classList.remove('text-green-500', 'text-red-500');
            icon.classList.add(isError ? 'text-red-500' : 'text-green-500');

            modal.show();
            setTimeout(() => modal.hide(), 2500);
        }
    });
</script>
