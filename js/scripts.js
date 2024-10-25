// ETAPE 1 : Réaliser l'interactivité d'ouverture et fermeture menu toggle //
/* privilégier "jQuery" à la place de "$" pour éviter conflits avec autres scripts */
document.addEventListener("DOMContentLoaded", function() {
    const burgerMenu = document.getElementById("menu-burger");
    const menuModal = document.getElementById("menu-mobile");

    burgerMenu.addEventListener("click", function() {
        burgerMenu.classList.toggle("active");
        menuModal.classList.toggle("show");
    });
});

// ETAPE 1 : Apparition et disparition de la modale de contact // 
document.addEventListener("DOMContentLoaded", function() {
    const modal = document.getElementById("contact-modal");
    const openModalBtn = document.getElementById("open-modal-btn");
    const closeModal = document.querySelector(".close-modal");

    openModalBtn.addEventListener("click", function() {
        modal.style.display = "block"; // Affiche la modale
    });

    closeModal.addEventListener("click", function() {
        modal.style.display = "none"; // Ferme la modale
    });
});

