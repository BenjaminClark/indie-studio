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
    public function render_content(){
        
        /**
         * @TODO check the API key is correct, at the moment we only check if it exists
         */
        
        if(!empty($this->fonts)){
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

            $googleApi = 'https://www.googleapis.com/webfonts/v1/webfonts?sort=popularity&key=';

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
            
            //We had an error, return no list
            return '';
            
        } else {
        
            if($amount == 'all'){
                return $content->items;
            } else {
                return array_slice($content->items, 0, $amount);
            }
            
        }
    }
}