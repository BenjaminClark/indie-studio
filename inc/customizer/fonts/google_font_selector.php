<?php

/**
 * Thanks to Paul Underwood
 * 
 * @link https://github.com/paulund/wordpress-theme-customizer-custom-controls/blob/master/select/google-font-dropdown-custom-control.php
 */

if ( ! class_exists( 'WP_Customize_Control' ) )
    return NULL;

/**
 * A class to create a dropdown for all google fonts
 */
 class Google_Font_Dropdown_Custom_Control extends WP_Customize_Control
 {
    private $fonts = false;

    public function __construct($manager, $id, $args = array(), $options = array())
    {
        $this->fonts = $this->get_fonts();
        parent::__construct( $manager, $id, $args );
    }

    /**
     * Render the content of the category dropdown
     *
     * @return HTML
     */
    public function render_content()
    {
        if(!empty($this->fonts))
        {
            ?>
                <label>
                    <span class="customize-category-select-control"><?php echo esc_html( $this->label ); ?></span>
                    <select <?php $this->link(); ?>>
                        <?php
                            foreach ( $this->fonts as $k => $v )
                            {
                                printf('<option value="%s" %s>%s</option>', $k, selected($this->value(), $k, false), $v->family);
                            }
                        ?>
                    </select>
                </label>
            <?php
        }
    }

    /**
     * Get the google fonts from the API or in the cache
     *
     * @param  integer $amount
     *
     * @return String
     */
    public function get_fonts( $amount = 'all' ){

        $fontFile = get_google_fonts_cache_file();

        //Total time the file will be cached in seconds, set to a week
        $cachetime = 86400 * 7;

        //Set content to empty
        $content = false;
        
        if(file_exists($fontFile) && $cachetime < filemtime($fontFile)){
            
            $content = json_decode(file_get_contents($fontFile));
            
        } else {

            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=AIzaSyDrh3G5OKARgE8W5SKll4lv8RCQVrF6swM';

            $fontContent = wp_remote_get( $googleApi, array('sslverify'   => false) );

            $fp = fopen($fontFile, 'w');
            fwrite($fp, $fontContent['body']);
            fclose($fp);

            $content = json_decode($fontContent['body']);
            
        }
        
        if ( isset ( $content->error ) ) {
            
            //First, catch any errors
            $error = $content->error->errors;
            
            if ( $error[0]->message ){
            
                write_log('Font API needs enabling');
                
            }
            
        } else {
        
            if($amount == 'all')
            {
                return $content->items;
            } else {
                return array_slice($content->items, 0, $amount);
            }
            
        }
    }
}


/**
 * Get the location of the Google Fonts cache
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
 */

function get_font_from_cache( $font ){
    
    $fontFile = get_google_fonts_cache_file();
    
    if ( $fontFile ){
    
        $content = json_decode( file_get_contents( $fontFile ) );

        if ( isset ( $content->error ) ) {
        //First, catch any errors
            $error = $content->error->errors;

            if ( $error[0]->message ){

                write_log('Font API needs enabling');

            }

        } else {

            //Check that font exists
            if ( isset ( $content->items[$font] ) ){
            
                return $content->items[$font];
                
            }

        }
        
    }
    
    return false;
    
}



function get_font_family_name( $font ){
    
    if ( isset ( $font['family'] ) ) {
        
        $family_name = str_replace( ' ', '+', $font['family'] );
        
        return $family_name;
        
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
    
    if ( isset ( $font['variants'] ) && count( $required ) > 0 ) {
        
        /**
         * Google has different options in the array
         * This cleans up the array so we can select from it
         */
                
        foreach ( $required as $require ){
            
            if ( in_array( $require, $font['variants'] ) ) {
                
                //Add our variant
                $variants[] = $require;
                
            }
            
        }
        
        return $variants;
        
    } 
    
    return false;
    
}