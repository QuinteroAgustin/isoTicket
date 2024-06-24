document.addEventListener('DOMContentLoaded', function () {
    const filterButton = document.getElementById('filterButton');
    if (filterButton) {
        filterButton.addEventListener('click', function () {
            const form = document.getElementById('filterForm');
            const formData = new FormData(form);
            const filterUrl = document.getElementById('filterButton').getAttribute('data-url');

            // Stockez les valeurs des champs de filtrage dans l'URL
            const searchParams = new URLSearchParams();
            for (const pair of formData.entries()) {
                searchParams.append(pair[0], pair[1]);
            }
            const urlWithParams = new URL(filterUrl);
            urlWithParams.search = searchParams.toString();

            fetch(urlWithParams, {
                method: 'GET',
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('clientTable').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
        });
    } else {
        console.error('Filter button not found');
    }
});
