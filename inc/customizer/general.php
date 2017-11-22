<?php

/**
 * Add General Section
 */

$wp_customize->add_section('indie_studio_general_section', array(
    'title'    => __('General Options', indie_studio_text_domain()),
));


/** 
 * Show/hide Search from header
 */

$wp_customize->add_setting('indie_studio_header_search', array(
    'default'	 => true,
    'transport'  => 'postMessage',
) );

$wp_customize->add_control('indie_studio_header_search', array(
    'settings' => 'indie_studio_header_search',
    'label'    => __('Display Header Search'),
    'section'  => 'indie_studio_general_section',
    'type'     => 'checkbox',
));


/** 
 * Click to load, or scroll to load
 */

$wp_customize->add_setting('indie_studio_infinite_scroll', array(
    'default'	 => true,
) );

$wp_customize->add_control('indie_studio_infinite_scroll', array(
    'settings' => 'indie_studio_infinite_scroll',
    'label'    => __('Infinite Scroll'),
    'section'  => 'indie_studio_general_section',
    'type'     => 'checkbox',
));