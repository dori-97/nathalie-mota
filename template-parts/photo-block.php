<div class="related-photos gallery-container">
    <div class="related-photo">
        <!-- Lien vers la page individuelle de la photo -->
        <a href="<?php the_permalink(); ?>" class="photo-link" title="<?php the_title_attribute(); ?>">
            <div class="thumbnail-container">
                <?php if (has_post_thumbnail()) : ?>
                    <?php
                    // Récupérer l'URL de l'image complète pour chaque image de la galerie
                    $full_image_url = esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full'));


                    // Récupérer la référence
                    $reference = get_post_meta(get_the_ID(), 'Reference', true);


                    // Récupérer les catégories
                    $categories = get_the_terms(get_the_ID(), 'photo-categorie');
                    $category_names = !empty($categories) && !is_wp_error($categories)
                        ? implode(', ', wp_list_pluck($categories, 'name'))
                        : '';
                    ?>
                    <!-- Image miniature -->
                    <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title_attribute(); ?>">
                    <div class="overlay">
                        <!-- Bouton pour accéder à la page individuelle -->
                        <span class="icon-eye" title="Voir les détails">
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/eye.png"
                                alt="Voir les détails">
                        </span>


                        <!-- Bouton pour ouvrir la lightbox -->
                        <span
                            class="icon-fullscreen lightbox-trigger"
                            title="Afficher en plein écran"
                            data-img="<?php echo $full_image_url; ?>"
                            data-index="<?php echo get_the_ID(); ?>"
                            data-reference="<?php echo esc_attr($reference); ?>"
                            data-category="<?php echo esc_attr($category_names); ?>"
                        >
                            <img
                                src="<?php echo get_template_directory_uri(); ?>/assets/images/fullscreen.png"
                                alt="Mode plein écran">
                        </span>


                        <!-- Affichage des informations sous forme d'attributs dans la lightbox -->
                        <?php if ($reference) : ?>
                            <p class="ref-icon"><?php echo esc_html($reference); ?></p>
                        <?php endif; ?>


                        <?php if ($category_names) : ?>
                            <p class="category-icon"><?php echo esc_html($category_names); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </a>
    </div>
</div>






