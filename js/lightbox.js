document.addEventListener('DOMContentLoaded', function () {
    const lightbox = document.getElementById('lightbox'); // Lightbox principale
    const lightboxImage = document.getElementById('lightbox-image'); // Image dans la lightbox
    const referenceText = document.getElementById('lightbox-reference'); // Texte de référence
    const categoryText = document.getElementById('lightbox-category'); // Texte de catégorie
    const closeBtn = document.getElementById('close-lightbox'); // Bouton fermer
    const prevBtn = document.getElementById('prev-photo'); // Bouton précédent
    const nextBtn = document.getElementById('next-photo'); // Bouton suivant
    let currentIndex = 0; // Index actuel dans le tableau des images
    let allImages = []; // Tableau contenant les données des images


    /**
     * **************************************
     * Fonction : populateImageArray
     * Description :
     * - Remplit le tableau `allImages` avec les données des images dans le DOM.
     * - Les données incluent : URL de l'image, référence, catégorie, et index.
     * **************************************
     */
    function populateImageArray() {
        const triggers = document.querySelectorAll('.photo-gallery .lightbox-trigger');
        allImages = []; // Réinitialiser le tableau des images


        triggers.forEach((trigger) => {
            const imgUrl = trigger.getAttribute('data-img'); // URL de l'image
            const imgIndex = trigger.getAttribute('data-index'); // Index de l'image
            const reference = trigger.getAttribute('data-reference'); // Référence associée
            const category = trigger.getAttribute('data-category'); // Catégorie associée


            // Ajouter l'image au tableau
            allImages.push({
                index: imgIndex,
                url: imgUrl,
                reference: reference,
                category: category,
            });
        });
    }



    /**
     * **************************************
     * Fonction : loadImageInLightbox
     * Description :
     * - Charge une image et ses métadonnées dans la lightbox.
     * **************************************
     * @param {number} index - Index de l'image dans `allImages`.
     */
    function loadImageInLightbox(index) {
        const imageData = allImages[index];
        if (imageData) {
            // Charger l'image dans la lightbox
            lightboxImage.src = imageData.url;


            // Mettre à jour la référence (ou afficher un message si absente)
            referenceText.textContent = imageData.reference
                ? `Référence : ${imageData.reference}`
                : 'Référence indisponible';


            // Mettre à jour la catégorie (ou afficher un message si absente)
            categoryText.textContent = imageData.category
                ? `Catégorie : ${imageData.category}`
                : 'Catégorie indisponible';


            // Afficher la lightbox
            lightbox.style.display = 'flex';
        }
    }


    /**
     * **************************************
     * Initialisation : Charger les données au démarrage
     * **************************************
     */
    populateImageArray();


    /**
     * **************************************
     * Événement : Clic sur une image pour ouvrir la lightbox
     * **************************************
     */
    document.querySelector('.photo-gallery').addEventListener('click', function (e) {
        const trigger = e.target.closest('.lightbox-trigger');
        if (trigger) {
            e.preventDefault(); // Empêcher le comportement par défaut du lien
            const imgIndex = trigger.getAttribute('data-index'); // Récupérer l'index de l'image
            currentIndex = allImages.findIndex(image => image.index === imgIndex); // Trouver l'image dans `allImages`
            loadImageInLightbox(currentIndex); // Charger l'image dans la lightbox
        }
    });


    /**
     * **************************************
     * Événement : Fermer la lightbox
     * **************************************
     */
    closeBtn.addEventListener('click', function () {
        lightbox.style.display = 'none';
    });


    /**
     * **************************************
     * Navigation : Image précédente
     * **************************************
     */
    prevBtn.addEventListener('click', function () {
        currentIndex = (currentIndex - 1 + allImages.length) % allImages.length; // Index circulaire
        loadImageInLightbox(currentIndex);
    });


    /**
     * **************************************
     * Navigation : Image suivante
     * **************************************
     */
    nextBtn.addEventListener('click', function () {
        currentIndex = (currentIndex + 1) % allImages.length; // Index circulaire
        loadImageInLightbox(currentIndex);
    });


    /**
     * **************************************
     * Événement : Mise à jour après une requête AJAX
     * **************************************
     * - Recharge les données des images si la galerie est mise à jour dynamiquement.
     */
    document.addEventListener('ajaxSuccess', function () {
        populateImageArray();
    });
});
