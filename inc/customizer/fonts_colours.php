<?php

/**
 * Add Font and Theme Colours Section
 */ 

$wp_customize->add_section('indie_studio_fonts_colours_section', array(
    'title'    => __('Fonts and Theme Colours', indie_studio_text_domain()),
));


/**
 * Add Font Controls
 */ 

$wp_customize->add_setting('indie_studio_font_api_missing');

$wp_customize->add_control( 
    new Google_Font_API_Checker_Section (
        $wp_customize,
        'indie_studio_font_api_missing',
        array (
            'settings' => 'indie_studio_font_api_missing',
            'label'    => __('Google Font API Key Missing'),
            'section'  => 'indie_studio_fonts_colours_section',
        )
    )
);

    
$wp_customize->add_setting('indie_studio_heading_font_selector');

$wp_customize->add_control(
    new Google_Font_Dropdown_Custom_Control (
        $wp_customize,
        'indie_studio_heading_font_selector',
        array (
            'settings' => 'indie_studio_heading_font_selector',
            'label'    => __('Heading Font Select'),
            'section'  => 'indie_studio_fonts_colours_section',
        )
    )
);

$wp_customize->add_setting('indie_studio_paragraph_font_selector');

$wp_customize->add_control(
    new Google_Font_Dropdown_Custom_Control (
        $wp_customize,
        'indie_studio_paragraph_font_selector',
        array (
            'settings' => 'indie_studio_paragraph_font_selector',
            'label'    => __('Body Font Select'),
            'section'  => 'indie_studio_fonts_colours_section',
        )
    )
);