<?php
get_header(); // Inclut l'en-tête du thème
?>

<main id="primary" class="site-main">

    <?php
    get_template_part( 'templates-part/hero-header' );
    ?>

<div class="filters">
    <div class="lists-container">
    <?php
// Récupérer toutes les catégories liées au CPT "photo"
$categories = get_categories(array(
    'taxonomy' => 'category', // Ici on met la taxonomie des catégories
    'hide_empty' => true, // Ne pas afficher les catégories vides
));
?>

<div class="category-filter">
    <label for="category-select"></label>
    <select id="category-select" onchange="location = this.value;">
        <option value="">CATÉGORIES</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                <?php echo esc_html($category->name); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<?php
// Récupérer toutes les termes de la taxonomie 'format'
$formats = get_terms(array(
    'taxonomy' => 'format',
    'hide_empty' => false, // Montre même les formats sans photo
));

// Créer une liste des formats disponibles
if (!empty($formats) && !is_wp_error($formats)) : ?>
    <div class="format-filter">
        <label for="format-select"></label>
        <select id="format-select" onchange="location = this.value;">
            <option value="">FORMATS</option>
            <?php foreach ($formats as $format) : ?>
                <option value="<?php echo esc_url(get_term_link($format)); ?>">
                    <?php echo esc_html($format->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>

<?php
// Récupérer toutes les termes de la taxonomie 'trier_par'
$tri_terms = get_terms(array(
    'taxonomy' => 'trier_par',
    'hide_empty' => false, // Montre même les options sans photo
));

// Créer une liste des options de tri disponibles
if (!empty($tri_terms) && !is_wp_error($tri_terms)) : ?>
    <div class="sort-filter">
        <label for="sort-select"></label>
        <select id="sort-select" onchange="location = this.value;">
            <option value="">TRIER PAR</option>
            <?php foreach ($tri_terms as $term) : ?>
                <option value="<?php echo esc_url(get_term_link($term)); ?>">
                    <?php echo esc_html($term->name); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
<?php endif; ?>
            </div>
            </div>
            



            
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

            <div class="load-more-container">
                <button type="button" id="load-more" class="load-more-button" data-page="1">Charger plus</button>
            </div>
</main>


<?php
get_footer(); // Inclut le pied de page du thème
?>
