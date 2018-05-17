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
    'label'    => __('Display Header Search', indie_studio_text_domain()),
    'section'  => 'indie_studio_general_section',
    'type'     => 'checkbox',
));


/** 
 * Click to load, or scroll to load
 */

$wp_customize->add_setting('indie_studio_loading_type', array(
    'default'	 => 'paging',
) );

$wp_customize->add_control('indie_studio_loading_type', array(
    'settings' => 'indie_studio_loading_type',
    'label'    => __('Blog Loading Type', indie_studio_text_domain()),
    'section'  => 'indie_studio_general_section',
    'type'     => 'select',
    'choices' => array(
        'paging'    => __( 'Paging', indie_studio_text_domain() ),
        'button'    => __( 'Button', indie_studio_text_domain() ),
        'infinite'  => __( 'Infinite Scroll', indie_studio_text_domain() ),
    ),
));