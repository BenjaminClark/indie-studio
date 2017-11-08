<?php

/**
 * This page creates the dynamic css
 **/

function indie_studio_create_dynamic_css(){ ?>
/** Add dynamic CSS below this line
/** -------------------------------
  
<?php
//Add fonts from Customizer
$fonts_url = '';
$header_font = get_theme_mod('indie_studio_heading_font_selector', '');
$content_font = get_theme_mod('indie_studio_paragraph_font_selector', '');
               
if ( 'off' !== $content_font || 'off' !== $header_font ) {
    
    $font_families = array(
        get_font_from_cache( $header_font ),
        get_font_from_cache( $content_font ),
    );
    
    $query_args = array(
        'family' => urlencode( implode( '|', array_unique($font_families) ) ),
    );

    $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
}

echo esc_url_raw( $fonts_url );
                                           
?>
    
<?php }

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