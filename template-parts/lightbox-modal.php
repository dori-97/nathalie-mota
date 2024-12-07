<div id="lightbox" class="lightbox-overlay">
    <span id="close-lightbox" class="close-btn">&times;</span>


    <div class="lightbox-content">
        <!-- Bouton navigation gauche -->
        <div class="navigation">
            <button id="prev-photo" class="nav-btn">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/white-line-left.png" alt="Flèche gauche">
                Précédente
            </button>
        </div>


        <!-- Image principale -->
        <div class="lightbox-photo">
            <img id="lightbox-image" src="" alt="Image en plein écran">
        </div>


        <!-- Bouton navigation droite -->
        <div class="navigation">
            <button id="next-photo" class="nav-btn">
                Suivante
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/white-line-right.png" alt="Flèche droite">
            </button>
        </div>


        <!-- Informations dynamiques (référence et catégorie) -->
        <div class="lightbox-info">
            <p id="lightbox-reference" class="ref-icon"></p>
            <p id="lightbox-category" class="category-icon"></p>
        </div>
    </div>
</div>