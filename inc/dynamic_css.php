<?php

/**
 * This page creates the dynamic css
 **/

function indie_studio_create_dynamic_css(){ ?>
/** Add dynamic CSS below this line
/** -------------------------------
  
<?php
//Add fonts from Customizer
    
    print_error ( get_google_font_details() );
    
    /**
    
    $query_args = array(
        'family' => urlencode( implode( '|', array_unique($font_families) ) ),
    );

    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
        
        */
    
}

/**
 * This function takes PHP generated CSS and 
 * allows it to be used within the main CSS file
 */

function indie_studio_dynamic_css(){
    header('Content-Type: text/css');
    indie_studio_create_dynamic_css();
    exit;
}
add_action('wp_ajax_indie_studio_dynamic_css', 'indie_studio_dynamic_css');
add_action('wp_ajax_nopriv_indie_studio_dynamic_css', 'indie_studio_dynamic_css');