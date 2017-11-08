<?php

/**
 * Add API Section
 */

$wp_customize->add_section('indie_studio_scripts_section', array(
    'title'    => __('Custom Scripts', indie_studio_text_domain()),
));


/**
 * Add Header Scripts
 */

$wp_customize->add_setting('indie_studio_scripts_header');

$wp_customize->add_control('indie_studio_scripts_header', array(
    'settings' => 'indie_studio_scripts_header',
    'label'    => __('Custom Header Scripts'),
    'section'  => 'indie_studio_scripts_section',
    'type'     => 'textarea',
));


/**
 * Add Footer Scripts
 */

$wp_customize->add_setting('indie_studio_scripts_footer');

$wp_customize->add_control('indie_studio_scripts_footer', array(
    'settings' => 'indie_studio_scripts_footer',
    'label'    => __('Custom Header Scripts'),
    'section'  => 'indie_studio_scripts_section',
    'type'     => 'textarea',
));