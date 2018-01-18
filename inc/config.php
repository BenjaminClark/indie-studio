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