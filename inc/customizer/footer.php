<?php

/**
 * Add Footer Section
 */

$wp_customize->add_section('indie_studio_footer_section', array(
    'title'    => __('Footer Options', indie_studio_text_domain()),
));


/**
 * Add Google API Key
 */

$wp_customize->add_setting( 'indie_studio_footer', array(
    'default' => 'Your Content Is Yours',
    'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control('indie_studio_footer', array(
    'settings' => 'indie_studio_footer',
    'label'    => __('Footer Text'),
    'section'  => 'indie_studio_footer_section',
    'type'     => 'textarea',
));