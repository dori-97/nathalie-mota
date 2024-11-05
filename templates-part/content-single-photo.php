<?php
/**
 * The template for displaying the single photo content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
?>

<!-- Conteneur principal de la publication -->
<article id="post-<?php the_ID(); ?>" <?php post_class('single-photo'); ?>>
            <!-- En-tête de la publication -->
            <header class="content-container">
                <div class="post-content">
                    <h1 class="photo-title"><?php the_title(); ?></h1>
                    <div class="custom-fields"> 
                        <?php
                        // Récupérer les références et les afficher
                        $reference = get_post_meta(get_the_ID(), 'Reference', true);
                        if ($reference) {
                            echo '<p><strong>RÉFÉRENCE :</strong> ' . esc_html($reference) . '</p>';
                        } 
                        
                        // Récupérer et afficher les catégories
                        $categories = get_the_terms(get_the_ID(), 'category');
                        if (!empty($categories) && !is_wp_error($categories)) {
                            echo '<p><strong>CATÉGORIE :</strong> ';
                            $category_links = array();
                            foreach ($categories as $category) {
                                $category_links[] = esc_html($category->name);
                            }
                            echo implode(', ', $category_links);
                            echo '</p>';
                        }

                        // Afficher le format
                        $formats = get_the_terms(get_the_ID(), 'format');
                        if (!empty($formats) && !is_wp_error($formats)) {
                            echo '<p><strong>FORMAT :</strong> ';
                            $format_links = array();
                            foreach ($formats as $format) {
                                $format_links[] = esc_html($format->name);
                            }
                            echo implode(', ', $format_links);
                            echo '</p>';
                        }

                        // Afficher le type
                        $type = get_post_meta(get_the_ID(), 'type', true);
                        if ($type) {
                            echo '<p><strong>TYPE :</strong> ' . esc_html($type) . '</p>';
                        }

                        // Date de publication avec uniquement l'année
                        echo '<p class="photo-date">ANNÉE : ' . get_the_date('Y') . '</p>';
                        ?>
                    </div>
                </div>
                
                <!-- Contenu principal de la publication -->
                <div class="photo-content">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="photo-image">
                            <?php the_post_thumbnail('large'); ?> <!-- Affiche l’image en grande taille -->
                        </div>
                    <?php endif; ?>
                    
                    <div class="photo-description">
                        <?php the_content(); ?> <!-- Affiche le contenu principal de la publication -->
                    </div>
                </div>
            </header>

            <section class="section-popup">
                <div class="popup-line"></div>
                    <div class="popup-single">
                        <div class="text-and-button">
                            <p>Cette photo vous intéresse ?</p>
                            <button id="contact-link" class="btn-style">Contact</button>
                            <?php get_template_part('templates-part/modal-contact'); ?>
                            <?php the_tags('<p>Mots-clés : ', ', ', '</p>'); ?> <!-- Affiche les tags -->
                        </div>
                        
                    <!-- Script jQuery pour modale -->
                    <script type="text/javascript">
                        jQuery(document).ready(function($) {
                            const modal = $("#contact-modal");
                            const openModal = $(".btn-style");
                            const closeModal = $(".close-modal");

                            openModal.on("click", function(event) {
                                event.preventDefault();
                                const refPhoto = "<?php echo esc_js(get_post_meta(get_the_ID(), 'Reference', true)); ?>";
                                $('.ref-photo').val(refPhoto);
                                modal.show();
                            });

                            closeModal.on("click", function() {
                                modal.hide();
                            });
                        });
                    </script>

           <!-- Navigation pour les articles précédent et suivant -->
                <nav class="post-navigation">
                    <div class="nav-links">
                        <div class="thumbnail-preview" id="thumbnail-preview"></div>
                        <?php
                         $current_post_id = get_the_ID();
                         $all_photos = get_posts(array(
                         'post_type' => 'photo',
                         'posts_per_page' => -1,
                         'fields' => 'ids',
                         'orderby' => 'date',
                         'order' => 'ASC'
                        ));

                    if (!empty($all_photos)) {
                         $current_index = array_search($current_post_id, $all_photos);

                        if ($current_index !== false) {
                         $prev_index = ($current_index - 1 + count($all_photos)) % count($all_photos);
                         $next_index = ($current_index + 1) % count($all_photos);
                         $prev_id = $all_photos[$prev_index];
                         $next_id = $all_photos[$next_index];
                        } else {
                         $prev_id = $next_id = null;
                        }

                    } else {
                        $prev_id = $next_id = null;
                    }

                        if ($prev_id) :
                        ?>

                        <div class="nav-previous">
                            <a href="<?php echo get_permalink($prev_id); ?>" class="arrow-left nav-link" data-thumbnail="<?php echo get_the_post_thumbnail_url($prev_id, 'thumbnail'); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/line-left.png" alt="Flèche gauche">
                            </a>
                        </div>
                        <?php endif;

                        if ($next_id) :
                         ?>

                        <div class="nav-next">
                            <a href="<?php echo get_permalink($next_id); ?>" class="arrow-right nav-link" data-thumbnail="<?php echo get_the_post_thumbnail_url($next_id, 'thumbnail'); ?>">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/line-right.png" alt="Flèche droite">
                            </a>
                        </div>
                        <?php endif; ?>
                        </div>
                </nav>
                    </div> <!--- Fermeture div popup single pour y inclure la nav ---->
            

            <!-- Section des articles similaires -->
            <section class="must-like">
                <p>VOUS AIMEREZ AUSSI</p>

                <div class="related-container">
                    <?php
                    $current_categories = get_the_terms(get_the_ID(), 'category');
                    if ($current_categories) {
                        $category_ids = array_map(function($cat) {
                            return $cat->term_id;
                        }, $current_categories);

                        // Arguments pour WP_Query
                        $args = array(
                            'post_type' => 'photo',
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'category',
                                    'field' => 'term_id',
                                    'terms' => $category_ids,
                                ),
                            ),
                            'post__not_in' => array(get_the_ID()),
                            'posts_per_page' => 2,
                            'orderby' => 'rand',
                        );

                        $related_posts = new WP_Query($args);

                        if ($related_posts->have_posts()) {
                        echo '<div class="related-photos">';
                        while ($related_posts->have_posts()) {
                        $related_posts->the_post();

                        // inclusion de template photo-block 
                        get_template_part('templates-part/photo-block');
                    }
                        echo '</div>';
                    } else {
                        echo '<p>Aucun article similaire trouvé dans cette catégorie.</p>';
                    }

                        wp_reset_postdata();
                    } else {
                        echo '<p>Aucune catégorie trouvée pour cet article.</p>';
                    }
                    ?>
                </div>
            </section>
        </article>