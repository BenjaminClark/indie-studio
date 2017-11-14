<?php

/**
 * This file adds Customizer settings to the Site Identity section
 **/

$wp_customize->add_setting('indie_studio_site_logo', array(
    'transport'  => 'postMessage',
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'indie_studio_site_logo', array(
    'settings' => 'indie_studio_site_logo',
    'label' => 'Website Logo',
    'section' => 'title_tagline',
) ) );