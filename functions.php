<?php
function nathalie_mota_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'nathalie_mota_enqueue_styles');
