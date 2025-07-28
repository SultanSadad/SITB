document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-pasien');
    const desktopTableBody = document.getElementById('desktop-table-body');
    const mobileCardsContainer = document.getElementById('mobile-cards-container');
    const paginationContainer = document.getElementById('pagination-container');
    let timeoutId;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(timeoutId);
            const query = this.value.trim();

            timeoutId = setTimeout(() => {
                const url = new URL(window.location.origin + `/petugas/rekam-medis/hasil-uji`);
                if (query) {
                    url.searchParams.set('search', query);
                } else {
                    url.searchParams.delete('search');
                }

                window.history.pushState({}, '', url);

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newDesktopTableBody = doc.getElementById('desktop-table-body');
                        if (desktopTableBody && newDesktopTableBody) {
                            desktopTableBody.innerHTML = newDesktopTableBody.innerHTML;
                        }

                        const newMobileCardsContainer = doc.getElementById('mobile-cards-container');
                        if (mobileCardsContainer && newMobileCardsContainer) {
                            mobileCardsContainer.innerHTML = newMobileCardsContainer.innerHTML;
                        }

                        const newPaginationContainer = doc.getElementById('pagination-container');
                        if (paginationContainer && newPaginationContainer) {
                            paginationContainer.innerHTML = newPaginationContainer.innerHTML;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching search results:', error);
                        alert('Gagal mencari data: ' + error.message);
                    });
            }, 300);
        });
    }
});
