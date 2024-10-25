<footer>
    <nav class="footer-navigation">
    <?php
        wp_nav_menu( array(
        'theme_location' => 'footer',
        'container' => 'nav',
        'container_class' => 'footer',
    ) );
    ?>
    </nav>

    <?php get_template_part('templates-part/modal-contact'); ?>

</footer>
    <?php wp_footer(); ?>
</body>
</html>
