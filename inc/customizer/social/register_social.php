<?php

/**
 * Add Social Section
 */

$wp_customize->add_section( 'indie_studio_social_settings', array(
    'title'    => __('Social Media', indie_studio_text_domain()),
) );
  
$social_sites = indie_studio_social_media_array();
  
/**
 * Here we loop through the social media array
 **/ 

foreach( $social_sites as $social_site ) {
  
    $wp_customize->add_setting( "$social_site", array(
        'default' => '',
    ) );
 
    //Capitalize Names
    $name = implode('-', array_map('ucfirst', explode('-', $social_site)));
    
    $wp_customize->add_control( $social_site, array(
        'label'   => __( "$name URL:", 'social_icon' ),
        'section' => 'indie_studio_social_settings',
        'type'    => 'text',
        'priority'=> 10,
    ) );
    
}