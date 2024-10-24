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
</footer>

<?php wp_footer(); ?>
</body>
</html>
