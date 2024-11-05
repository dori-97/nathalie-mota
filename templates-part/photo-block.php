<div class="related-photos">
    <div class="related-photo">
        <a href="<?php the_permalink(); ?>" class="photo-link">
            <div class="thumbnail-container">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('medium'); ?>
                    <div class="overlay">
                        <span class="icon-eye" title="Accéder aux infos de la photo"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/eye.png" alt="Mode plein écran"></span>
                        <span class="icon-fullscreen" title="Afficher en plein écran"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/fullscreen.png" alt="Mode plein écran"></span>
                        <span class="ref-icon">RÉFÉRENCE DE LA PHOTO</span>
                        <span class="category-icon">CATÉGORIE</span>
                    </div>
                <?php endif; ?>
            </div>
        </a>
    </div>
</div>