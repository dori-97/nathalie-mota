<?php
get_header(); // Inclut l'en-tête du thème
?>

<main id="primary" class="site-main">

    <?php
    get_template_part( 'templates-part/hero-header' );
    ?>


            <?php
            // Arguments pour la requête
            $args = array(
            'post_type' => 'photo', 
            'posts_per_page' => 8, // Nombre de photos à afficher
            );

            // La requête
            $photos_query = new WP_Query($args);

            // Boucle
        if ($photos_query->have_posts()) : ?>
            <div class="photo-gallery">
                <?php while ($photos_query->have_posts()) : $photos_query->the_post(); ?>
                    
                    <?php get_template_part('templates-part/photo', 'block'); ?>
                <?php endwhile; ?>
            </div>

            <?php wp_reset_postdata(); // Réinitialise la requête principale ?>

                <?php else : ?>
                    <p>Aucune photo à afficher.</p>
                <?php endif;?>
</main>

<?php
get_footer(); // Inclut le pied de page du thème
?>
