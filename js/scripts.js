// ETAPE 1 : Gérer ouverture/fermeture menu toggle + affichage modale contact
document.addEventListener("DOMContentLoaded", function() {
    const burgerMenu = document.getElementById("menu-burger");
    const menuModal = document.getElementById("menu-mobile");
    const modal = document.getElementById("contact-modal");
    const openModal = document.getElementById("contact-link");
    const closeModal = document.querySelector(".close-modal");

    // Fonction pour ouvrir la modale de contact
    function openContactModal(event) {
        event.preventDefault();
        modal.style.display = "block";
    }

    // Fonction pour fermer la modale de contact
    function closeContactModal() {
        modal.style.display = "none";
    }

    // Fonction pour basculer l'état du menu burger
    function toggleBurgerMenu() {
        burgerMenu.classList.toggle("active");
        menuModal.classList.toggle("show");
    }

    // Gestion des événements
    burgerMenu.addEventListener("click", toggleBurgerMenu);
    openModal.addEventListener("click", openContactModal);
    closeModal.addEventListener("click", closeContactModal);

    // Gestion des clics sur le document
    document.addEventListener("click", function(event) {
        // Fermeture du menu mobile si clic en dehors
        if (!menuModal.contains(event.target) && !burgerMenu.contains(event.target)) {
            menuModal.classList.remove("show");
            burgerMenu.classList.remove("active");
        }

        // Fermeture de la modale si clic en dehors
        if (!modal.contains(event.target) && modal.style.display === "block") {
            closeContactModal();
        }

        // Ouverture de la modale pour les liens de contact dans le menu mobile
        if (event.target.id === "contact-link" || event.target.closest("#contact-link")) {
            openContactModal(event);
        }
    });
});

// ETAPE 3 : Gestion de la navigation entre article sur single-photo.php //
document.addEventListener('DOMContentLoaded', function() {
    const preview = document.getElementById('thumbnail-preview');
    const navLinks = document.querySelectorAll('.nav-link');
    const navContainer = document.querySelector('.post-navigation'); 

    function showThumbnail(event) {
        const thumbnailUrl = event.currentTarget.getAttribute('data-thumbnail');
        if (!thumbnailUrl) {
            console.error("Thumbnail URL not found");
            return;
        }

        preview.style.backgroundImage = `url(${thumbnailUrl})`;
        preview.style.display = "block";

        if (navContainer) {
            const navRect = navContainer.getBoundingClientRect();
            
            // Ajuster la position horizontale ici
            const horizontalOffset = 38; // Augmenter cette valeur pour déplacer vers la droite la miniature
            preview.style.left = `${navRect.left + window.scrollX + (navRect.width / 2) - (preview.offsetWidth / 2) + horizontalOffset}px`;
            
            // Ajuster la position verticale ici
            const verticalOffset = 0; // Baisser cette valeur pour baisser la miniature
            preview.style.top = `${navRect.top + window.scrollY - verticalOffset}px`;
        } else {
            console.error("Navigation container not found");
        }
    }

    function hideThumbnail() {
        preview.style.display = "none";
    }

    navLinks.forEach(link => {
        link.addEventListener('mouseenter', showThumbnail);
        link.addEventListener('mouseleave', hideThumbnail);
    });
});

//ETAPE 4 : script pour charger l'img aléatoire hero header//
document.addEventListener('DOMContentLoaded', function() {
    var hero = document.getElementById('hero');
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var imageUrl = xhr.responseText;
                hero.style.backgroundImage = 'url(' + imageUrl + ')';
            }
        }
    };
    var ajaxUrl = '<?php echo $ajax_url; ?>';
    xhr.open('GET', ajaxUrl + '?action=get_random_hero_image', true);
    xhr.send();
});
