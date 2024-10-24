<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php wp_head(); ?> <!-- Ceci charge les styles et scripts enregistrés -->
</head>

<body <?php body_class(); ?>>

    <header class="site-header">
    <div class="site-logo">
    <?php
        if ( function_exists( 'the_custom_logo' ) ) {
        the_custom_logo();
    }
    ?>
    </div>

<nav class="main-navigation">
    <div class="header-menu">
    <?php
        wp_nav_menu( array(
        'theme_location' => 'header',
        'container' => 'nav',
        'container_class' => 'header',
    ) );
    ?>
    </div>
    <div class="move-toggle">
    <button id="menu-burger" class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
    </button>
    </div>
</nav>

<div id="menu-mobile" class="menu-modal">
        <div class="menu-content">
            <?php
            wp_nav_menu( array(
            'theme_location' => 'header',
            'container' => 'nav',
            'container_class' => 'header',
            ) );
            ?>
        </div>
</div>	
</header>
</html>