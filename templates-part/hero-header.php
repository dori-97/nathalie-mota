<!---------- Récupère une image aléatoire ------>
<?php
$random_image = get_random_hero_image(); 
?>

<!---------- Définition de l'URL d'AJAX ------>
<?php
$ajax_url = esc_url(admin_url('admin-ajax.php'));
?>

<!---------- Hero header  ------>
<section id="hero" class="hero" <?php if ($random_image) : ?> 
    style="background-image: url('<?php echo esc_url($random_image); ?>');" 
    <?php endif; ?>>
    <h1>PHOTOGRAPHE EVENT</h1>
</section>