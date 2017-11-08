<?php

/**
 * The main enqueuing scripts file
 *
 * This page enqueues all scripts for this theme.
 *
 * For more info see:
 *
 * @link https://codex.wordpress.org/Function_Reference/wp_register_script
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script
 * @link http://code.tutsplus.com/articles/the-ins-and-outs-of-the-enqueue-script-for-wordpress-themes-and-plugins--wp-22509
 * @link https://codex.wordpress.org/Function_Reference/wp_dequeue_script
 * @link https://developer.wordpress.org/reference/functions/wp_script_add_data/
 */

/**
 * Enqueue all JS scripts
 * 
 * This function is used to contain all JS scripts
 * needed to be included within the theme. It will
 * add all scripts into an array and pass to the
 * minifier/basic enqueuer
 */
function indie_studio_enqueue_scripts(){    
    
    /**
     * Set up any localisation values
     * 
     * All localisation is applied to theme-script script. This is to encourage the use of the minifier.
     * If the site is being run without minification, the main code must be called theme-script
     **/
    
    $localize_this = array (
        //General Data
        'ajax_url'                  => admin_url('admin-ajax.php'), //Standard ajax init
        'base_url'                  => site_url(),
        'img_url'                   => get_stylesheet_directory_uri() . '/img/',
        'security'                  => wp_create_nonce('indie_studio_nonce'),
    );
    
    
    //Set the CSS directory for this theme
    $JS_3rdP_dir    = get_stylesheet_directory_uri() . '/js/third_party/';
    $JS_theme_dir   = get_stylesheet_directory_uri() . '/js/theme/';
    $JS_direct_path = get_stylesheet_directory() . '/js/theme/';    
    
    
    /**
     * Scripts to be added in the header
     **/
        
    /**
    * Load Respond.js
    * 
    * This allows responsive web design to work on IE 6-8. Run before all scripts to ensure it
    */
    wp_enqueue_script(
        'respond', 
        $JS_3rdP_dir . 'respond.min.js', 
        false , 
        '1.4.2', 
        false
    );
    wp_script_add_data( 'respond', 'conditional', 'lt IE 9' ); //Add the condition to show if below IE9
    
    
    /**
    * Load HTML5 Shiv
    * 
    * Allows the use of HTML in legacy IE
    */
    wp_enqueue_script(
        'html5_shiv', 
        $JS_3rdP_dir . 'html5shiv.js', 
        false , 
        '3.7.3', 
        false
    );
    wp_script_add_data( 'html5_shiv', 'conditional', 'lt IE 9' ); //Add the condition to show if below IE9
    
        
    /**
     * We can only compile JS files that are to be enqueued in the footer
     * header files must be enqueued as standard
     **/ 
    
    $js_to_compile = array();  
    
        
    
    /**
    * Load SmoothScroll
    * 
    * Everyone loves Smoothscroll
    */
    $js_to_compile[] = array(
        'smooth_scroll', 
        $JS_3rdP_dir . 'smoothscroll.js',
        '1.4.4', 
    );
    
    
    /**
     * Load Scroll Reveal
     **/
    $js_to_compile[] = array(
        'smooth_reveal', 
        $JS_3rdP_dir . 'scrollreveal.min.js',
        '3.3.4', 
    );
    
    
    /**
    * Load Fancybox 3
    */
    $js_to_compile[] = array(
        'fancy_box_3', 
        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.js', 
        '3.2.0', 
    );
    
    
    /**
     * Now all the custom theme scripts
     **/
            
    $js_to_compile[] = array(
        'indie_studio_localisation', 
        $JS_theme_dir . 'localisation.js', 
        indie_studio_get_file_version_number( 'indie_studio_localisation', $JS_direct_path . 'localisation.js' ), 
    );
    
    $js_to_compile[] = array(
        'indie_studio_ajax', 
        $JS_theme_dir . 'ajax.js', 
        indie_studio_get_file_version_number( 'indie_studio_ajax', $JS_direct_path . 'ajax.js' ), 
    );
        
    
    //Only load logging if debug is turned on
    if (defined('WP_DEBUG') && true === WP_DEBUG) {
    
        $js_to_compile[] = array(
            'indie_studio_logging', 
            $JS_theme_dir . 'logging.js', 
            indie_studio_get_file_version_number( 'indie_studio_logging', $JS_direct_path . 'logging.js' ), 
        );
    
    }
        
    $js_to_compile[] = array(
        'indie_studio_essentials', 
        $JS_theme_dir . 'essentials.js', 
        indie_studio_get_file_version_number( 'indie_studio_essentials', $JS_direct_path . 'essentials.js' ), 
    );
    
    $js_to_compile[] = array(
        'indie_studio_parralax', 
        $JS_theme_dir . 'parralax.js', 
        indie_studio_get_file_version_number( 'indie_studio_parralax', $JS_direct_path . 'parralax.js' ), 
    );
                
    $js_to_compile[] = array(
        'indie_studio_menu', 
        $JS_theme_dir . 'menu.js', 
        indie_studio_get_file_version_number( 'indie_studio_menu', $JS_direct_path . 'menu.js' ), 
    );
        
    $js_to_compile[] = array(
        'indie_studio_archive', 
        $JS_theme_dir . 'archive.js', 
        indie_studio_get_file_version_number( 'indie_studio_archive', $JS_direct_path . 'archive.js' ), 
    );

    
    /**
    * Load the main JS file for the theme
    */
    
    $js_to_compile[] = array(
        'theme_script', 
        $JS_theme_dir . 'theme-main.js', 
        indie_studio_get_file_version_number( 'theme_script', $JS_direct_path . 'theme-main.js' ), 
    );
        
    indie_studio_create_theme_css_js( $js_to_compile, 'js', $localize_this );
        
}
add_action( 'wp_enqueue_scripts', 'indie_studio_enqueue_scripts' );




/**
* Dequeue jQuery Migrate script in WordPress.
*/
function indie_studio_remove_jquery_migrate( &$scripts) {
    if(!is_admin()) {
        $scripts->remove( 'jquery');
        $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );
    }
}
add_filter( 'wp_default_scripts', 'indie_studio_remove_jquery_migrate' );


/**
 * Enqueue all CSS scripts
 * 
 * This function is used to contain all CSS scripts
 * needed to be included within the theme. It will
 * add all scripts into an array and pass to the
 * minifier/basic enqueuer
 */
function indie_studio_enqueue_styles(){
    
    $css_to_compile = array();
    
    //Set the CSS directory for this theme
    $CSS_3rdP_dir       = get_stylesheet_directory_uri() . '/css/third_party/';
    $CSS_theme_dir      = get_stylesheet_directory_uri() . '/css/theme/';
    $CSS_direct_path    = get_stylesheet_directory() . '/css/theme/';
    
    
    /**
    * Load Normalize.CSS
    */
    $css_to_compile[] = array(
        'normalize', 
        'https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css', 
        '7.0.0',
    );
        
    
    /**
    * Load Font Awesome
    */ 
    $css_to_compile[] = array(
        'font_awesome', 
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css', 
        '4.7.0', 
    );
    
    
    /**
    * Load Fancy Box 3
    */
    $css_to_compile[] = array(
        'fancy_box_3', 
        'https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.2.0/jquery.fancybox.min.css', 
        '3.2.0', 
    );
    
    
    /**
    * Load Animate
    */ 
    $css_to_compile[] = array(
        'animate', 
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
        '3.5.2',
    );

    
    /**
     * Dynamic CSS
     */
    $css_to_compile[] = array(
        'indie_studio_dynamic', 
        admin_url('admin-ajax.php').'?action=indie_studio_dynamic_css',
        1,
    );
    
    /**
     * Now include all theme components
     **/ 
       
    //Include SCSS Compiled CSS
    $css_to_compile[] = array(
        'indie_studio_base', 
        $CSS_theme_dir . 'base.css',
        indie_studio_get_file_version_number( 'indie_studio_base', $CSS_direct_path . 'base.css' ),
    );
        
    indie_studio_create_theme_css_js( $css_to_compile, 'css' );
    
}
add_action( 'wp_enqueue_scripts', 'indie_studio_enqueue_styles' );


/**
 * Add CSS styles to admin
 * 
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 **/ 
function indie_studio_enqueue_admin_css_styles(){
    
    //Set the theme directory
    $CSS_theme_dir      = get_stylesheet_directory_uri() . '/css/';
    
    wp_enqueue_style(
        'indie_studio_admin', 
        $CSS_theme_dir . '/theme/admin.css', 
        false, 
        '1', 
        false
    );   
    
    /**
    * Load Animate
    */ 
    wp_enqueue_style(
        'animate', 
        'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
        false,
        '3.5.2',
        false
    );

}
add_action( 'admin_enqueue_scripts', 'indie_studio_enqueue_admin_css_styles' );


/**
 * Add JS scripts to admin
 * 
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
 **/ 

function indie_studio_enqueue_admin_js_scripts(){
    
    //Set the theme directory
    $JS_theme_dir   = get_stylesheet_directory_uri() . '/js/theme/';
    $JS_direct_path = get_stylesheet_directory() . '/js/theme/';
    
    $localize_this = array (
        //General Data
        'ajax_url' => admin_url('admin-ajax.php'), //Standard ajax init
    );
    
    wp_enqueue_script(
        'indie_studio_admin', 
        $JS_theme_dir . '/admin.js', 
        false, 
        '1', 
        true
    );
    wp_localize_script( 'indie_studio_admin', 'indie_studio_ajax', $localize_this );
    

    
}
add_action( 'admin_enqueue_scripts', 'indie_studio_enqueue_admin_js_scripts' );


/**
 * Add Customizer control code
 **/

function indie_studio_enqueue_customizer_control(){
    
    $JS_theme_dir   = get_stylesheet_directory_uri() . '/js/theme/';
    $JS_direct_path = get_stylesheet_directory() . '/js/theme/';

    wp_enqueue_script(
        'indie_studio_customizer', 
        $JS_theme_dir . 'customizer-control.js', 
        array('jquery'), 
        indie_studio_get_file_version_number( 'indie_studio_customizer', $JS_direct_path . 'customizer-control.js' ), 
        true
    );
    
}
add_action( 'customize_controls_enqueue_scripts', 'indie_studio_enqueue_customizer_control' );

/**
 * Add Customizer Preview code
 **/

function indie_studio_enqueue_customizer_preview(){
    
    $JS_theme_dir   = get_stylesheet_directory_uri() . '/js/theme/';
    $JS_direct_path = get_stylesheet_directory() . '/js/theme/';

    wp_enqueue_script(
        'indie_studio_customizer', 
        $JS_theme_dir . 'customizer-preview.js', 
        array('jquery'), 
        indie_studio_get_file_version_number( 'indie_studio_customizer', $JS_direct_path . 'customizer-preview.js' ), 
        true
    );
    
}
add_action( 'customize_preview_init', 'indie_studio_enqueue_customizer_preview' );