<?php

/**
 * Navigation Top - Menu
 * 
 * This content part contains the logo or site title, header menu, burger and search.
 *
 * @TODO If there is no logo, add site title
 * allow SVG addition with customizer as well (text area)
 */

?>

<div class="logo">
    <a class="smooth" href="<?php echo site_url();?>">

        <?php
        
        //Get logo filepath
        $custom_logo =  get_theme_mod( 'indie_studio_site_logo' );
        
        if ( $custom_logo ){
        
            if ( isSvg( $custom_logo ) ){ ?>

                <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <img itemprop="url" src="<?php echo $custom_logo; ?>" />
                </div>
                
            <?php } else { 
            
                $logo_dimensions = getimagesize( $custom_logo );
                
                ?>
                
                <div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
                    <img itemprop="url" src="<?php echo $custom_logo; ?>" alt="<?php get_bloginfo( 'name' );?> logo"/>
                    <meta itemprop="width" content="<?php echo $logo_dimensions[0]; ?>" />
                    <meta itemprop="height" content="<?php echo $logo_dimensions[1]; ?>" />
                </div>
            
            <?php } //end is svg ?>
            
        <?php } else {

            echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
            
        } ?>
            
    </a>
</div>

<div class="header-menu-wrap group">

    <!-- Main Menu -->
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', indie_studio_text_domain() ); ?>">
        <?php
        if ( has_nav_menu( 'primary' ) ) {
            $args = array(
                'menu_class'		=> '',
                'theme_location'    => 'primary',
            );
            wp_nav_menu($args); 
        }
        ?>
    </nav>

    <div class="burger-wrapper">

        <div id="burger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <div class="trig"></div>
        </div>

        <?php
        
        /**
         * @TODO Add checkbox in customizer to allow users
         * to pick if they want to show a search box in the header
         */
        
        if ( get_theme_mod('indie_studio_header_search', true) ) {
        
            get_search_form();
        
        }
        
        ?>

    </div>

</div>