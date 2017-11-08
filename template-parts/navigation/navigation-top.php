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
    <a href="<?php echo site_url();?>">
    

			<?php
			if ( has_custom_logo() ) {
				$image = wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ) );
			?>
				<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
					<meta itemprop="url" content="<?php echo current( $image ); ?>" />
					<meta itemprop="width" content="<?php echo next( $image ); ?>" />
					<meta itemprop="height" content="<?php echo next( $image ); ?>" />
				</div>
			<?php } ?>
    

    </a>
</div>

<div class="header-menu-wrap group">

    <!-- Main Menu -->
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', indie_studio_text_domain() ); ?>">
        <div class="page-inner-wrap full group">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                $args = array(
                    'menu_class'		=> '',
                    'theme_location'    => 'primary',
                );
                wp_nav_menu($args); 
            }
            ?>
        </div>
    </nav>

    <div class="burger-wrapper">

        <div id="burger">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>

        <?php
        
        /**
         * @TODO Add checkbox in customizer to allow users
         * to pick if they want to show a search box in the header
         */
        
        if ( get_theme_mod('indie_studio_header[show_search]', true) ) {
        
            get_search_form();
        
        }
        
        ?>

    </div>

</div>