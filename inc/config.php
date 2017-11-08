<?php

/**
 * The base configuration for the Indie Studio theme
 *
 * This file contains the following configurations:
 *
 * * Theme detail constants
 * * Minification constants
 * * Custom post type AJAX return rules
 * 
 * @package IndieStudio
 */

/**
 * Get the theme version from the stylesheet
 * 
 * May seem pointless, but it avoids any
 * errors from changes later in the day
 * 
 * @return string version
 */
function indie_studio_version(){
    $theme_details = wp_get_theme();
    return $theme_details->get('Version');
}


/**
 * Get the theme name from the stylesheet
 * 
 * May seem pointless, but it avoids any
 * errors from changes later in the day
 * 
 * @return string theme name
 */
function indie_studio_name(){
    $theme_details = wp_get_theme();
    return $theme_details->get('Name');
}


/**
 * Get the text domain from the stylesheet
 * 
 * May seem pointless, but it avoids any
 * errors from changes later in the day
 * 
 * @return string The text domain of the theme
 */
function indie_studio_text_domain(){
    $theme_details = wp_get_theme();
    return $theme_details->get('TextDomain');
}

/** Set the CSS to be minified */
define('INDIE_STUDIO_MINIFY_CSS', false); 


/** Set the JS to be minified */
define('INDIE_STUDIO_MINIFY_JS', false);


/** 
 * Set the CSS to have comments removed 
 * during minification
 */
define('INDIE_STUDIO_REMOVE_CSS_COMMENTS', false);


/** 
 * Set the JS to have comments removed 
 * during minification
 */
define('INDIE_STUDIO_REMOVE_JS_COMMENTS', false);


/** 
 * Set the CSS to have lines removed 
 * during minification
 */
define('INDIE_STUDIO_REMOVE_CSS_NEWLINES', false);


/** 
 * Set the JS to have lines removed 
 * during minification
 */
define('INDIE_STUDIO_REMOVE_JS_NEWLINES', false);


/** 
 * Set the CSS to have line breaks removed 
 * during minification
 */
define('INDIE_STUDIO_REMOVE_CSS_LINEBREAKS', false);


/** 
 * Set the JS to have line breaks removed 
 * during minification
 */
define('INDIE_STUDIO_REMOVE_JS_LINEBREAKS', false);


/**
 * If you have put the website behind basic auth,
 * you need to enter the user/pass here for the compiler
 * to function correctly
 **/ 
define('INDIE_STUDIO_AUTH_USER', '');
define('INDIE_STUDIO_AUTH_PASS', '');


/**
 * Set post type to be AJAX loaded
 * 
 * This function holds an array of post type names.
 * It works alongside the ajax/load_any_post to 
 * limit posts that can be returned, so media items/cats
 * dont get returned.
 *
 * @return array Returns an array of accepted ajaxable post types
 */
function indie_studio_allow_ajax_post_types(){
    $array = array(
        'search',
        'post',
    );
    return $array;
}