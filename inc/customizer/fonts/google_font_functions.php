<?php

/**
 * Get the location of the Google Fonts cache
 * 
 * @return string Returns the url for the Google Fonts cache file
 *    
 * @TODO This "could" be turned into a WordPress option, however this may
 * be very heavy. Seems more sensible to keep as a txt.
 */ 

function get_google_fonts_cache_file(){
    
    $fontFile = get_stylesheet_directory().'/inc/customizer/fonts/cache/google-web-fonts.txt';
    
    if ( file_exists( $fontFile ) ){
        return $fontFile;
    }
       
    return false;
    
}


/**
 * Return the selected font
 * 
 * @param  array $font Google font array from JSON
 * @return array Returns the font array from the cached file
 */

function get_font_from_cache( $font = null ){
    
    $fontFile = get_google_fonts_cache_file();
    
    if ( $fontFile && $font ){
            
        $content = json_decode( file_get_contents( $fontFile ) );

        if ( isset ( $content->error ) ) {
        //First, catch any errors
            $error = $content->error->errors;

            if ( $error[0]->message ){

                write_log('Font API needs enabling');
                
            }
            
            write_log('Unknown error');

        } else {

            //Check that font exists
            if ( isset ( $content->items[$font] ) ){
            
                return $content->items[$font];
                
            }

        }
        
    }
    
    return false;
    
}


/**
 * Returns font family name
 * 
 * @param  array $font Google font array from JSON
 * @return mixed Return the font family name, or false
 */

function get_font_family_name( $font ){
    
    if ( isset ( $font->family ) ) {
                        
        return $font->family;
        
    }
    
    return false;
    
}


/**
 * Return an array of the variations avalible for the font
 * 
 * @param array $required An array of the required varations
 * @param array $font     Font array passed from get_font_from_cache
 * @returns array An array of variants avalible to use
 *                                              
 * $required accepts some weird variable due to Google using un-standard rules
 * eg:
 *
 *   [0] => 100
 *   [1] => 100italic
 *   [2] => 300
 *   [3] => 300italic
 *   [4] => regular
 *   [5] => italic
 *   [6] => 500
 *   [7] => 500italic
 *   [8] => 700
 *   [9] => 700italic
 *   [10] => 900
 *   [11] => 900italic
 */

function get_font_variations( $required, $font ){
    
    $variants = array();
        
    if ( isset ( $font->variants ) && count( $required ) > 0 ) {
        
        /**
         * Google has different options in the array
         * This cleans up the array so we can select from it
         */
                
        foreach ( $required as $require ){
            
            if ( in_array( $require, $font->variants ) ) {
                
                //Add our variant
                $variants[] = $require;
                
            }
            
        }
        
        return $variants;
        
    } 
    
    return false;
    
}


/**
 * Sets up font defaults, as well as gets any user selected fonts
 */

function get_google_font_details(){
    
    /**
     * Set the fallback fonts, as well as the required variants
     */ 
        
    $default_fonts = array(
        'heading' => array (
            'name'      => 'Raleway',
            'variants'  => array (
                '300',
                'regular',
                'italic',
                '700',
                '700italic',
            ),
        ),
        'paragraph' => array (
            'name'      => 'Open+Sans',
            'variants'  => array (
                '300',
                'regular',
                'italic',
                '700',
                '700italic',
            ),
        ),
    );
        
    /**
     * Get user selected fonts
     */
    
    $selected_fonts = array(
        array (
            'type' => 'heading',
            'font' => get_theme_mod('indie_studio_heading_font_selector', false),
        ),
        array (
            'type' => 'paragraph',
            'font' => get_theme_mod('indie_studio_paragraph_font_selector', false),
        ),
    );
    
    
    /**
     * Loop through user selected fonts
     * 
     * Get correct details, or provide properly formatted fallback
     */ 
    
    foreach ( $selected_fonts as $font ){
        
        if( isset( $font['font'] ) ){
            
            $font_array = get_font_from_cache( $font['font'] );
            
            if ( $font_array ){
                
                //Overwrite default font family name
                $default_fonts[ $font['type'] ]['name'] = get_font_family_name( $font_array );
                                
                //Get the default font array for this particular selected font
                //Pull out the required variants
                $required_variants = $default_fonts[ $font['type'] ]['variants'];
                
                //Overwrite variants with those provided for selected font            
                $default_fonts[ $font['type'] ]['variants'] = get_font_variations( $required_variants, $font_array );
                
            }
        }
    }
    
    return $default_fonts;
    
}


/**
 * Get all font details and turn into Google API URL
 * to be used with the WordPress enqueuing function
 */

function get_google_fonts_enqueue_url(){
   
    $fonts          = get_google_font_details();    
    $font_output = array();
    
    foreach ( $fonts as $font ){
        
        $new_font = $font['name'] . ':';
        
        foreach ( $font['variants'] as $variant ){
            
            $new_font .= $variant . ',';
            
        }
        
        $font_output[] = $new_font;
        
    }
    
    return add_query_arg(
        array(
            "family"=>urlencode(implode("|", $font_output)),
        ),'https://fonts.googleapis.com/css');

}


/**
 * Get the font details to preview in the customizer
 * 
 * @TODO First font in list doesnt get previewed. Not super important. Put on backburner
 */

function google_fonts_customizer_preview(){
    
    $font       = ( isset($_POST['font']) ) ? $_POST['font'] : false;
    $location   = ( isset($_POST['location']) ) ? $_POST['location'] : false;
                
    if ( $location ){
        
        $retrieved_font = get_font_from_cache( $font );
                
        //Does font exist?
        if ( $retrieved_font ){                    
                                
            $font_array = array(
                'location'  => $location,
                'url'       => add_query_arg( array(
                                    "family"=>urlencode( get_font_family_name( $retrieved_font ) ),
                            ),'https://fonts.googleapis.com/css'),
                'family'    => get_font_family_name( $retrieved_font ),
            );
            
            die ( json_encode ( $font_array ) );
            
        }
        
    }
    
    die( false );
    
}
add_action('wp_ajax_google_fonts_customizer_preview', 'google_fonts_customizer_preview');
add_action('google_fonts_customizer_preview', 'google_fonts_customizer_preview');