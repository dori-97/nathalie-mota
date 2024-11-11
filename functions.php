<?php
//ETAPE 1 : Charger le style du thème//
function nathalie_mota_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
   
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_styles');
?>


<?php
//ETAPE 1 : Enregistrer emplacement menus de WP//  
function nathalie_mota_register_menus() {
    register_nav_menus(
        array(
            'header' => __( 'Header' ),
            'footer' => __( 'Footer' ),
        )
    );
}
add_action( 'init', 'nathalie_mota_register_menus' );
?>


<?php
//ETAPE 1 : Récupérer logo via WP// 
function nathalie_mota_support_logo() {
    add_theme_support( 'custom-logo' );
}
add_action( 'after_setup_theme', 'nathalie_mota_support_logo' );
?>


<?php
// ETAPE 1 : ajout d'un ID à Contact dans header menu pour pouvoir afficher modale //
function add_contact_link_id($atts, $item, $args) {
    // vérifie si le titre de l'élément est "Contact" et s'il appartient au menu principal
    if ($item->title === 'CONTACT' && $args->theme_location === 'header') {
        $atts['id'] = 'contact-link'; // ajoute l'ID "contact-link" au lien "Contact"
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_contact_link_id', 10, 3);
?>


<?php
// ETAPE 2 : Gestion catégories CPT //
function create_post_type() {
    register_post_type('photo',
        array(
            'labels' => array(
                'name' => __('Photos'),
                'singular_name' => __('Photo')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'photos'),
            'taxonomies' => array('category'), 
        )
    );
}
add_action('init', 'create_post_type');


function create_formats_taxonomy() {
    register_taxonomy(
        'format',
        'photo', // Nom du CPT
        array(
            'label' => __('Formats'),
            'rewrite' => array('slug' => 'format'),
            'hierarchical' => true, // True si catégories, false pour étiquettes
        )
    );
}
add_action('init', 'create_formats_taxonomy');


function create_sort_taxonomy() {
    register_taxonomy(
        'trier_par', // Nom de la taxonomie
        'photo', // Nom du CPT
        array(
            'label' => __('Trier par'),
            'rewrite' => array('slug' => 'trier-par'),
            'hierarchical' => true, // True si on veut des catégories, false pour des étiquettes
        )
    );
}
add_action('init', 'create_sort_taxonomy');

// ETAPE 3 : enqueue script JS pour navigation single-photo.php //
function enqueue_navigation_single_photo_script() {
    
    wp_enqueue_script('navigation-single-photo', get_template_directory_uri() . '/js/navigation-single-photo.js', array(), null, true);

}
add_action('wp_enqueue_scripts', 'enqueue_random_hero_script');


// ETAPE 4 : fonction pour img aléatoire hero header //
// chargement script//
function enqueue_random_hero_script() {
    
    wp_enqueue_script('random-hero', get_template_directory_uri() . '/js/hero.js', array(), null, true);

    // Localiser le script pour envoyer des données PHP (comme l'URL admin-ajax.php)
    wp_localize_script('random-hero', 'random_hero_params', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_random_hero_script');

// fonction pour l'image aléatoire // 
function get_random_hero_image() {
    $args = array(
        'post_type' => 'photo', 
        'posts_per_page' => 1,
        'orderby' => 'rand'
    );
    
    $query = new WP_Query($args);
    
    if ($query->have_posts()) {
        $query->the_post();
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
    } else {
        // Image de fallback si aucune photo n'est trouvée
        $image_url = get_template_directory_uri() . '/assets/images/nathalie-10.jpeg'; 
    }
    
    wp_reset_postdata();
    
    return $image_url; 
}

//suite étape du dessus avec AJAX pour récupérer l'image//
function ajax_get_random_hero_image() {
    $image_url = get_random_hero_image();
    if ($image_url) {
        echo $image_url;
    }
    wp_die();
}

add_action('wp_ajax_get_random_hero_image', 'ajax_get_random_hero_image');
add_action('wp_ajax_nopriv_get_random_hero_image', 'ajax_get_random_hero_image');



//ETAPE 4 : requete AJAX pour pagination//
function enqueue_load_more_script() {
    wp_enqueue_script('load-more', get_template_directory_uri() . '/js/load-more.js', array('jquery'), null, true);

    // Envoie l'URL AJAX et le nonce vers JavaScript
    wp_localize_script('load-more', 'load_more_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('load_more_posts_nonce'), // Création d'un nonce sécurisé
    ));
}
add_action('wp_enqueue_scripts', 'enqueue_load_more_script');


// suite pour charger plus de photos
function load_more_posts() {
    // Sécuriser la requête avec le nonce
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'load_more_posts_nonce')) {
        die('Permission non accordée');
    }


    // Récupère les variables transmises par AJAX
    // Récupérer la page actuelle à charger (par défaut page 1)
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    // Récupérer la catégorie (terme de la taxonomie 'photo')
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';


    // Arguments pour la requête
    $args = array(
        'post_type'      => 'photo',  // CPT "photo"
        'posts_per_page' => 8,        // Nombre de posts par page
        'paged'          => $page,    // Page actuelle pour la pagination
    );

    // Si une catégorie est spécifiée, ajouter la taxonomie à la requête
    if (!empty($category)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'photo', // Taxonomie associée à ton CPT "photo"
                'field'    => 'term_id', // Nous utilisons l'ID de la catégorie
                'terms'    => $category,
            ),
        );
    }

    // Effectuer la requête avec les arguments spécifiés
    $query = new WP_Query($args);

    // Vérifier si des posts sont trouvés
    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            // Retourner le HTML des posts sans header, footer, etc.
              get_template_part('templates-part/photo', 'block');
        endwhile;
    endif;

    // Réinitialiser les données de la requête
    wp_reset_postdata();

    // Terminer la requête Ajax
    die();
}

add_action('wp_ajax_load_more_posts', 'load_more_posts'); // Utilisateurs connectés
add_action('wp_ajax_nopriv_load_more_posts', 'load_more_posts'); // Utilisateurs non connectés



// ETAPE 4 : listes déroulantes //
function filter_photos_ajax() {
    // Récupérer les paramètres envoyés par AJAX
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $format = isset($_GET['format']) ? $_GET['format'] : '';
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';
    $posts_per_page = isset($_GET['posts_per_page']) ? $_GET['posts_per_page'] : 8;

    // Arguments pour la requête WP_Query
    $args = array(
        'post_type' => 'photo', // CPT 'photo'
        'posts_per_page' => $posts_per_page,
        'orderby' => 'date', // Ou tout autre critère de tri
        'order' => 'DESC', // Tri décroissant par défaut
    );

    // Ajouter les filtres
    if (!empty($category)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'category',
            'field' => 'id',
            'terms' => $category,
            'operator' => 'IN',
        );
    }
    if (!empty($format)) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'id',
            'terms' => $format,
            'operator' => 'IN',
        );
    }
    if (!empty($sort)) {
        $args['orderby'] = 'meta_value'; // Si tu veux trier par un custom field, sinon ajuste selon tes besoins
        $args['meta_key'] = 'trier_par';  // Remplace avec le bon custom field
        $args['order'] = 'ASC'; // Tri ascendant ou descendant selon la logique
    }

    // La requête
    $query = new WP_Query($args);

    // Vérifier s'il y a des posts
    if ($query->have_posts()) {
        while ($query->have_posts()) : $query->the_post();
            // Inclure le template pour afficher la photo
            get_template_part('templates-part/photo', 'block');
        endwhile;
    } else {
        echo '<p>Aucune photo trouvée.</p>';
    }

    // Réinitialiser la requête
    wp_reset_postdata();

    // Terminer l'exécution AJAX
    wp_die();
}
add_action('wp_ajax_filter_photos', 'filter_photos_ajax');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos_ajax');
