/* privilégier "jQuery" à la place de "$" pour éviter conflits avec autres scripts */
jQuery(document).ready(function() {
    const $burgerMenu = jQuery('#menu-burger');
    const $menuModal = jQuery('#menu-mobile');
    
    $burgerMenu.on('click', function() {
        jQuery(this).toggleClass('active');
        $menuModal.toggleClass('show');
    });
});