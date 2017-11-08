<?php
        
function indie_studio_theme_setup() { 

    /**
     * Add support for WordPress 3.0's custom menus
     * Register area for custom menu
     *
     * See: https://codex.wordpress.org/Function_Reference/register_nav_menus
     */

    function register_my_menu() {
        // This theme uses wp_nav_menu() in two locations.
        register_nav_menus( 
            array(
                'primary'   => __( 'Main Menu',   'indie_studio' ),
                'footer'    => __( 'Footer Menu', 'indie_studio' )
            ) 
        );
    }
    add_action( 'init', 'register_my_menu' );

    require( 'theme_support.php' ); //Enqueues all code for supporting custom themes
}

add_action( 'after_setup_theme', 'indie_studio_theme_setup' );