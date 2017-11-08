<?php

/**
 * Add API Section
 */

$wp_customize->add_section('indie_studio_api_section', array(
    'title'    => __('APIs', indie_studio_text_domain()),
));


/**
 * Add Google API Key
 */

$wp_customize->add_setting('indie_studio_google_api');

$wp_customize->add_control('indie_studio_google_api', array(
    'settings' => 'indie_studio_google_api',
    'label'    => __('Google API Key'),
    'section'  => 'indie_studio_api_section',
    'type'     => 'textarea',
));
