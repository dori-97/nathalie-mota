jQuery(document).ready(function ($) {
    function fetchFilteredPhotos() {
        // Récupérer les valeurs des filtres
        const category = $('#category-select').val();
        const format = $('#format-select').val();
        const sort = $('#sort-select').val();

        // Requête AJAX
        $.ajax({
            url: ajax_filter_params.ajax_url, // URL AJAX
            type: 'POST',
            data: {
                action: 'filter_photos', // Action PHP
                category: category,
                format: format,
                sort: sort,
            },
            beforeSend: function () {
                $('.photo-gallery').html('<p>Chargement des photos...</p>'); // Indiquer un chargement
            },
            success: function (response) {
                if (response.success && response.data) {
                    $('.photo-gallery').html(response.data); // Remplacer le contenu
                } else {
                    $('.photo-gallery').html('<p>Aucune photo trouvée.</p>');
                }
            },
            error: function (error) {
                console.error('Erreur AJAX :', error);
                $('.photo-gallery').html('<p>Erreur lors du chargement des photos.</p>');
            },
        });
    }

    // Écoute des changements sur les filtres
    $('#category-select, #format-select, #sort-select').on('change', function () {
        fetchFilteredPhotos();
    });
});
