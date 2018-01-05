<?php

/**
 * Navigation Top - Menu
 * 
 * This content part contains the logo or site title, header menu, burger and search.
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

            if( is_home() || is_front_page() ){
            
                echo '<h1>'. get_bloginfo( 'name' ) .'</h1>';
                
            } else {
                
                //All other pages will have a proper H1 tag
                echo '<p>'. get_bloginfo( 'name' ) .'</p>';

            }
            
        } ?>
        
    </a>
</div>

<div class="header-menu-wrap group">

    <!-- Main Menu -->
    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', indie_studio_text_domain() ); ?>">
        
        <div class="push">

            <?php
            if ( has_nav_menu( 'primary' ) ) {
                $args = array(
                    'menu_class'		=> 'toggle-list',
                    'theme_location'    => 'primary',
                    'link_after'        => '<a href="#" class="toggle"><i class="fa fa-angle-down" aria-hidden="true"></i></a>',
                );
                wp_nav_menu($args); 
            }
            ?>

            <?php get_social_media_icons(); ?>
        
        </div>
            
    </nav>
    
    <div id="burger">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <div class="trig"></div>
    </div>
    
    <?php

    if ( get_theme_mod('indie_studio_header_search', true) ) {

        get_search_form();

    }

    ?>

</div>

<!-- Adds an overlay to dim content -->
<div id="overlay"><div class="push"></div></div>

<!-- Grab blog tagline -->
<?php if ( bloginfo( 'description' ) ){ ?>
    <h2 id="site-description"<?php get_schema_semantics( 'site-description' ); ?>><?php bloginfo( 'description' ); ?></h2>
<?php } ?>