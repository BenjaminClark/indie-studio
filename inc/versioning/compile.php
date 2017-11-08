<?php

/**
 * Enqueues and/or minifies CSS/JS
 * 
 * Takes all CSS/JS and enqueues them. If set, it will pass
 * them through the minifier and output as single file.
 * 
 * @param array     $final_array        Array of files to enqueue
 * @param string    $type               css or js
 * @param array     $localized_values   Array to pass to localise function
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 * 
 * @todo break into smaller more accessable functions
 **/

function indie_studio_create_theme_css_js( $final_array, $type, $localized_values = null ){
        
    if( $type == 'css' || $type == 'js' ){
    
        /**
         * Only run this function if we are NOT running an ajax or cron call
         **/

        if( !request_is_ajax_or_cron() ){

            //If we have files to enqueue
            if( isset( $final_array ) ){ 

                if( $type == 'css' ) {
                
                    //Check to see if any new files have been added to compile
                    check_css_files_for_compiler( $final_array );

                    //Only create minified if out of debug mode
                    if ( defined('INDIE_STUDIO_MINIFY_CSS') && true === INDIE_STUDIO_MINIFY_CSS ){

                        //Get inportant info
                        $process = true; //Used for error checking
                        $theme_dir = get_stylesheet_directory_uri();
                        $direct_path = get_stylesheet_directory();

                        //Check if a minified file exists 
                        // OR check if minified is older than newest updated file
                        // OR if a new file has been added to the compiler
                        if ( !file_exists( $direct_path . '/css/theme/style.min.css' ) || !indie_studio_is_mini_css_newest() || indie_studio_has_new_css_file_been_added_to_compiler() ) {

                            $new_css = indie_studio_compile_css_files( $final_array );

                            if ( $new_css ){

                                $output_path = get_template_directory() . '/css/theme/style.min.css';

                                $file_success = file_put_contents($output_path, $new_css);

                                //Check file was written correctly
                                if( !$file_success ){
                                    $process = false;
                                }

                                //Reset the css compiler tracker
                                indie_studio_reset_css_file_compiler_tracker();

                            }

                        }

                        //Check that minified file exists and enqueue
                        if ( file_exists( $direct_path . '/css/theme/style.min.css' ) && $process) {

                            wp_enqueue_style( 'indie_studio_minfied_css', $theme_dir . '/css/theme/style.min.css', array(), indie_studio_get_file_version_number( 'indie_studio_minfied_css', $direct_path . '/css/theme/style.min.css' ) );

                            return true;

                        }

                    }

                    //If not in debug, or script minifed failed. Load normally
                    indie_studio_basic_enqueue_css_files( $final_array );
                    
                }
                
                if( $type == 'js' ) {
                    
                   //Check to see if any new files have been added to compile
                    check_js_files_for_compiler( $final_array );

                    //Only create minified if set
                    if ( defined('INDIE_STUDIO_MINIFY_JS') && true === INDIE_STUDIO_MINIFY_JS ){

                        //Get inportant info
                        $process = true; //Used for error checking
                        $theme_dir = get_stylesheet_directory_uri();
                        $direct_path = get_stylesheet_directory();

                        //Check if a minified file exists 
                        // OR check if minified is older than newest updated file
                        // OR if a new file has been added to the compiler
                        if ( !file_exists( $direct_path . '/js/theme/theme-main.min.js' ) || !indie_studio_is_mini_js_newest() || indie_studio_has_new_js_file_been_added_to_compiler() ) {

                            $new_js = indie_studio_compile_js_files( $final_array );

                            if ( $new_js ){

                                $output_path = get_template_directory() . '/js/theme/theme-main.min.js';

                                $file_success = file_put_contents($output_path, $new_js);

                                //Check file was written correctly
                                if( !$file_success ){
                                    $process = false;
                                }

                                //Reset the css compiler tracker
                                indie_studio_reset_js_file_compiler_tracker();

                            }

                        }

                        //Check that minified file exists and enqueue
                        if ( file_exists( $direct_path . '/js/theme/theme-main.min.js' ) && $process) {

                            wp_enqueue_script( 'indie_studio_minfied_js', $theme_dir . '/js/theme/theme-main.min.js', array('jquery'), indie_studio_get_file_version_number( 'indie_studio_minfied_js', $direct_path . '/js/theme/theme-main.min.js' ), true );

                            //Localise script if values exist
                            if( $localized_values ){
                                wp_localize_script( 'theme_script', 'indie_studio_ajax', $localized_values );
                            }

                            return true;

                        }

                    }
                    
                    //If not in debug, or script minifed failed. Load normally
                    indie_studio_basic_enqueue_js_files( $final_array );

                    //Localise script if values exist
                    if( $localized_values ){

                        //If we have a specific localised js file. use that.
                        if( in_array( 'indie_studio_localisation', indie_studio_get_js_names_from_compiler_tracker() ) ){
                            wp_localize_script( 'indie_studio_localisation', 'indie_studio_ajax', $localized_values );
                        } else {
                            //We dont have a localised file. use standard
                            wp_localize_script( 'theme_script', 'indie_studio_ajax', $localized_values );
                        }
                    }
                    
                }

            }
        }
    }
}


/** 
 * Check Minified CSS
 *
 * This function checks to see if the minifed css is newer than the most recent individual css file saved
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_is_mini_css_newest(){
    
    $direct_path = get_stylesheet_directory();
    
    $file = $direct_path . '/style.min.css';
        
    if ( file_exists( $file ) ){
            
        return indie_studio_is_stamp_newer( $new_stamp = get_file_last_mod_stamp( $file ), indie_studio_get_master_timestamp( 'css' ) );
                       
    }
    
    return false;
    
}


/**
 * Check Minified CSS
 * 
 * This function checks to see if the minifed js is newer than the most recent individual js file saved
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_is_mini_js_newest(){
    
    $direct_path = get_stylesheet_directory();
    
    $file = $direct_path . '/js/theme-main.min.js';
        
    if ( file_exists( $file ) ){
    
        return indie_studio_is_stamp_newer( $new_stamp = get_file_last_mod_stamp( $file ), indie_studio_get_master_timestamp( 'js' ) );
                       
    }
    
    return false;
    
}
 

/**
 * Basic CSS Enqueuer
 * 
 * Loop through enqueue array and enqueue in the standard
 * WordPress way. All files are separate.
 * 
 * @param array     $final_array        Array of files to enqueue
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_basic_enqueue_css_files( $css_array ){
    
    if( isset( $css_array ) ){
    
        foreach ( $css_array as $file ) {
                        
            if ( isset( $file[0] ) && isset( $file[1] ) && isset( $file[2] ) ){
            
                wp_enqueue_style(
                    $file[0], 
                    $file[1], 
                    false, 
                    $file[2], 
                    'all'
                );  
            }
        }
    }
}


/**
 * Basic JS Enqueuer
 * 
 * Loop through enqueue array and enqueue in the standard
 * WordPress way. All files are separate.
 * 
 * @param array     $final_array        Array of files to enqueue
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_basic_enqueue_js_files( $js_array ){
    
    if( isset( $js_array ) ){
    
        foreach ( $js_array as $file ) {
                        
            if ( isset( $file[0] ) && isset( $file[1] ) && isset( $file[2] ) ){
                            
                wp_enqueue_script(
                    $file[0], 
                    $file[1], 
                    array('jquery'), 
                    $file[2], 
                    true
                );  
                
            }
        }
    }
}


/**
 * Compile CSS Holder
 * 
 * This passes a string to the indie_studio_compress_css function
 * to make the file smaller. This is then returned.
 * 
 * @param array     $css_array        Array of CSS files to enqueue
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_compile_css_files( $css_array ){ 
    if ( !empty( $css_array ) ){
        $css_file = indie_studio_group_files( $css_array );
        $new_file = indie_studio_compress_css( $css_file );
        return $new_file;
    }
    return false;
}

/**
 * Compile JS Holder
 * 
 * This passes a string to the indie_studio_compress_css function
 * to make the file smaller. This is then returned.
 * 
 * @param array     $js_array        Array of JS files to enqueue
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_compile_js_files( $js_array ){ 
    if ( !empty( $js_array ) ){
        $js_file = indie_studio_group_files( $js_array );
        $new_file = indie_studio_compress_js( $js_file );
        return $new_file;
    }
    return false;
}


/**
 * Multi-file to single string
 * 
 * This function takes an array of css files, loops through
 * and adds them all to a single string.
 * 
 * @param array     $file_array        Array of CSS files to loop through
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */

function indie_studio_group_files( $file_array ){
    
    /**
     * Set content to NULL, otherwise file_get_contents has a strop
     * 
     * @http://php.net/file_get_contents
     */
    
    $context = null;
    
    
    /**
     * At this point the config file is checked.
     * 
     * If the user has put the site behind a basic auth, they must update
     * there auth user/pass in the config file, otherwise the compiler will
     * not be able to find the files.
     */ 
    
    if ( defined('INDIE_STUDIO_AUTH_USER') && strlen ( INDIE_STUDIO_AUTH_USER ) > 0 && defined('INDIE_STUDIO_AUTH_PASS') && strlen ( INDIE_STUDIO_AUTH_PASS ) > 0 ){

        
        /**
         * Use this if we want to pass files through protected hosting
         */
        
        $context = stream_context_create(array(
            'http' => array(
                'header'  => "Authorization: Basic " . base64_encode("user:pass")
            )
        ));
    
    }
    
    if ( !empty( $file_array ) ){
        $buffer = "";
        //Loop through all css files
        foreach ($file_array as $file) {
            if( $file[1] ){//If we have a file
                $buffer .= file_get_contents($file[1], false, $context);
            }
        } 
        return $buffer;
    }
    return false;
}


/**
 * Compress CSS
 * 
 * This function takes a string of CSS content taken from multiple
 * files and removes all spaces, all comments, orders by media query
 * and returns as a smaller string.
 * 
 * @param array     $minify        CSS files as string to clean
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_compress_css( $minify ){
        
    if ( defined('INDIE_STUDIO_REMOVE_CSS_COMMENTS') && true === INDIE_STUDIO_REMOVE_CSS_COMMENTS ){
        $minify = indie_studio_remove_file_comments( $minify );
    }
    if ( defined('INDIE_STUDIO_REMOVE_CSS_LINEBREAKS') && true === INDIE_STUDIO_REMOVE_CSS_LINEBREAKS ){
        $minify = indie_studio_remove_file_breaks( $minify );
    }
    if ( defined('INDIE_STUDIO_REMOVE_CSS_NEWLINES') && true === INDIE_STUDIO_REMOVE_CSS_NEWLINES ){
        $minify = indie_studio_remove_file_new_lines( $minify );
    }
        
    /* sort media queries */
    $match = array();
    $media = array();
    $final = '';
    
    // search media query in CSS
    // $match will hold all strings matching $pattern.
    preg_match_all('#@media(.*?)\{(.+?}[ \n])\}#si',$minify,$match,PREG_SET_ORDER);

    // group same media query
    foreach ($match as $val){
        if (!isset($media[$val[1]])) {
            $media[$val[1]] = '';
        }
        $media[$val[1]] .= $val[2];
    }

    foreach ($media as $id => $val){
        $final .= "\n" . '@media' . $id . '{' . $val . '}' . "\n";
    }

    return $minify;
}


/**
 * Compress JS
 * 
 * This function takes a string of JS content taken from multiple
 * files and removes all spaces, all comments, orders by media query
 * and returns as a smaller string.
 * 
 * @param string     $minify        JS files as string to clean
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_compress_js( $minify ){
        
    if ( defined('INDIE_STUDIO_REMOVE_JS_COMMENTS') && true === INDIE_STUDIO_REMOVE_JS_COMMENTS ){
        $minify = indie_studio_remove_file_comments( $minify );
    }
    if ( defined('INDIE_STUDIO_REMOVE_JS_LINEBREAKS') && true === INDIE_STUDIO_REMOVE_JS_LINEBREAKS ){
        $minify = indie_studio_remove_file_breaks( $minify );
    }
    if ( defined('INDIE_STUDIO_REMOVE_JS_NEWLINES') && true === INDIE_STUDIO_REMOVE_JS_NEWLINES ){
        $minify = indie_studio_remove_file_new_lines( $minify );
    }

    return $minify;
}


/**
 * Remove file comments
 * 
 * This function removes all comments from a section of text
 * 
 * @param string $string  string to clean
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_remove_file_comments( $string ){
    
    // Remove stacked comments
    $string = preg_replace( '!/\*.*?\*/!s', '', $string );
    
    // Removes single line '//' comments, treats blank characters
    $string = preg_replace( '/^\h*\/\/.*$/m', "\n", $string );
    
    return $string;    
}


/**
 * Remove file breaks
 * 
 * This function removes all line breaks, and white space from a section
 * of text
 * 
 * @param string $string  string to clean
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_remove_file_breaks( $string ){
    // Strip blank lines
    $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string );
    return $string; 
}


/**
 * Remove file new lines
 * 
 * This function removes all new lines from a string
 * 
 * @param string $string  string to clean
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_remove_file_new_lines( $string ){
    // Remove line breaks
    $string = preg_replace( "/\r|\n/", "", $string );
    return $string; 
}


/**
 * Check if process is frontend
 * 
 * This function checks to see if a request is being made by a user on a frontend ajax call,
 * or if this a backend general process run
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */

function request_is_frontend_ajax(){
    
    $script_filename = isset($_SERVER['SCRIPT_FILENAME']) ? $_SERVER['SCRIPT_FILENAME'] : '';

    //Try to figure out if frontend AJAX request... If we are DOING_AJAX; let's look closer
    if((defined('DOING_AJAX') && DOING_AJAX)){
        
        //From wp-includes/functions.php, wp_get_referer() function.
        //Required to fix: https://core.trac.wordpress.org/ticket/25294
        $ref = '';
        
        if ( ! empty( $_REQUEST['_wp_http_referer'] ) ){
            
            $ref = wp_unslash( $_REQUEST['_wp_http_referer'] );
            
        } elseif ( ! empty( $_SERVER['HTTP_REFERER'] ) ){
            
            $ref = wp_unslash( $_SERVER['HTTP_REFERER'] );
            
        }

        //If referer does not contain admin URL and we are using the admin-ajax.php endpoint, this is likely a frontend AJAX request
        if(((strpos($ref, admin_url()) === false) && (basename($script_filename) === 'admin-ajax.php'))){
            return true;
        }
    }

    //If no checks triggered, we end up here - not an AJAX request.
    return false;
}



function request_is_ajax_or_cron(){
    if( defined( 'DOING_CRON' ) && DOING_CRON || request_is_frontend_ajax() ){
        return true;
    }
    return false;
}

