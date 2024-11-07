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


// ETAPE 4 : fonction pour img aléatoire hero header //
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
        $random_image_url = get_template_directory_uri() . '/assets/images/nathalie-10.jpeg';
        }
        wp_reset_postdata();
        return $image_url;
    }
    return false;


add_action('wp_ajax_get_random_hero_image', 'ajax_get_random_hero_image');
add_action('wp_ajax_nopriv_get_random_hero_image', 'ajax_get_random_hero_image');

//suite étape du dessus avec AJAX pour récupérer l'image//
function ajax_get_random_hero_image() {
    $image_url = get_random_hero_image();
    if ($image_url) {
        echo $image_url;
    }
    wp_die();
}