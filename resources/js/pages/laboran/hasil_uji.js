document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search-pasien');

    if (!searchInput) return;

    let timeoutId;

    searchInput.addEventListener('input', function () {
        clearTimeout(timeoutId);

        timeoutId = setTimeout(() => {
            this.closest('form').submit();
        }, 300);
    });
});
