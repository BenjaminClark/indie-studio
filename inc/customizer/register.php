<?php

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

    $wp_customize->add_section('indie_studio_header', array(
        'title'    => __('Header', indie_studio_text_domain()),
        'priority' => 30,
    ));
    
    
    /** 
     * Show/hide Search from header
     */
    
    $wp_customize->add_setting('indie_studio_header_search', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    
    $wp_customize->add_control('display_header_search', array(
        'settings' => 'indie_studio_header_search',
        'label'    => __('Display Header Search'),
        'section'  => 'indie_studio_header',
        'type'     => 'checkbox',
    ));
    
    
    /**
     * Add Font Controls
     */ 
    
    $wp_customize->add_setting('indie_studio_heading_font_selector');
    
    $wp_customize->add_control(
        new Google_Font_Dropdown_Custom_Control (
            $wp_customize,
            'indie_studio_heading_font_selector',
            array (
                'settings' => 'indie_studio_heading_font_selector',
                'label'    => __('Heading Font Select'),
                'section'  => 'indie_studio_header',
            )
        )
    );
    
    $wp_customize->add_setting('indie_studio_paragraph_font_selector', array(
        'capability' => 'edit_theme_options',
        'type'       => 'option',
    ));
    
    $wp_customize->add_control(
        new Google_Font_Dropdown_Custom_Control (
            $wp_customize,
            'indie_studio_paragraph_font_selector',
            array (
                'settings' => 'indie_studio_paragraph_font_selector',
                'label'    => __('Body Font Select'),
                'section'  => 'indie_studio_header',
            )
        )
    );

    
    
}
    
add_action( 'customize_register', 'indie_studio_customize_register' );