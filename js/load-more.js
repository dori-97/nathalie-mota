// ETAPE 4 : pagination lors du clic sur Charger Plus //
jQuery(document).ready(function($) {
    console.log("load-more.js is loaded");
    var postsPerPage = 8;

    $('#load-more').on('click', function(e) {
        e.preventDefault(); // Assure que le clic ne recharge pas la page

        let page = $(this).data('page') || 1;
        page++; // Incrémente la page à chaque clic

        // Catégorie sélectionnée
        let category = $('#category-select').val();

        // Requête AJAX
        $.ajax({
            url: load_more_params.ajax_url, // URL définie dans PHP avec `wp_localize_script`
            type: 'POST',
            data: {
                action: 'load_more_posts', // Action correspondante dans PHP
                nonce: load_more_params.nonce, // Utiliser un nonce si ajouté dans PHP
                page: page,
                category: category
            },
            success: function(response) {
                if (response) {
                    $('.photo-gallery').append(response); // Ajoute les nouveaux éléments
                    $('#load-more').data('page', page); // Met à jour la page
                } 
                // Si la réponse est vide, cela signifie qu'il n'y a plus d'articles à charger
                if (!response.trim()) {
                    $('#load-more').hide(); // Masquer le bouton "Charger plus"
                } else {
                    ($.trim(response) === '' || $(response).filter('article').length < postsPerPage); {
                        $('#load-more').hide(); // Masquer le bouton
                    }
                }
            },
            error: function() {
                alert('Erreur lors du chargement des posts.');
            }
        });
    });
});