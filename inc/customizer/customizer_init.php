<?php

/**
 * This file includes all files required 
 * to run the Customizer
 **/

/**
 * Here we include custom Customizer classes
 */ 

include ( 'fonts/google_font_functions.php' );

include ( 'fonts/google_font_selector.php' );

include ( 'fonts/google_font_api_checker.php' );


/**
 * Add our Customizer content
 * 
 * @link https://maddisondesigns.com/2017/05/the-wordpress-customizer-a-developers-guide-part-1/
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * Examples
 * @link https://gist.github.com/Abban/2968549
 *
 * @since IndiePress 1.0.0
 */


/**
 * All Customizer content (i.e. Panels, Sections, Settings & Controls) 
 * are registered here
 */

function indie_studio_customize_register( $wp_customize ) {
    
    //Add Site Identity Settings
    include ( 'identity.php' );
    
    //Add any general settings
    include ( 'general.php' );
    
    //Add font and theme colour options
    include ( 'fonts_colours.php' );
    
    //Add custom scripts fields
    include ( 'scripts.php' );
    
    //Add API key fields
    include ( 'API.php' );
    
}
    
add_action( 'customize_register', 'indie_studio_customize_register' );