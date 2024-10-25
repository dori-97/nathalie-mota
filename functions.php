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


