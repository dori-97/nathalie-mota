<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */

get_header(); 
?>

<main id="primary" class="site-main">
    <?php
    // Démarre la boucle pour afficher le contenu de la publication actuelle
    while (have_posts()) : the_post(); 
    

    get_template_part( 'templates-part/content', 'single-photo' );


    endwhile; ?>   
</main>

<?php
get_footer(); 
?>
