<?php

/**
 * Add Font and Theme Colours Section
 */ 

$wp_customize->add_section('indie_studio_fonts_colours_section', array(
    'title'         => __('Fonts and Theme Colours', indie_studio_text_domain()),
    'description'   => __('Here you can edit the Fonts used across the site, as well as pick essential theme colours', indie_studio_text_domain()),
));


/**
 * Add Body Colour Controls
 */ 

$wp_customize->add_setting('indie_studio_background_colour', array(
    'default'	        => '#ffffff',
    'transport'         => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
        $wp_customize,  'indie_studio_background_colour', array(
            'settings'  => 'indie_studio_background_colour',
            'label'	    => __('Theme Background Colour', indie_studio_text_domain()),
		    'section'	=> 'indie_studio_fonts_colours_section',
	   ) 
    ) 
);


/**
 * Add Font Controls
 */ 

$wp_customize->add_setting('indie_studio_font_api_missing', array(
    'default'	 => '0',
) );

$wp_customize->add_control( 
    new Google_Font_API_Checker_Section (
        $wp_customize,
        'indie_studio_font_api_missing',
        array (
            'settings' => 'indie_studio_font_api_missing',
            'label'    => __('Google Font API Key Missing', indie_studio_text_domain()),
            'section'  => 'indie_studio_fonts_colours_section',
        )
    )
);
    
$wp_customize->add_setting('indie_studio_heading_font_selector', array(
    'default'	 => '0',
) );


$wp_customize->add_control(
    new Google_Font_Dropdown_Custom_Control (
        $wp_customize,
        'indie_studio_heading_font_selector',
        array (
            'settings' => 'indie_studio_heading_font_selector',
            'label'    => __('Heading Font Select', indie_studio_text_domain()),
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
            'label'    => __('Body Font Select', indie_studio_text_domain()),
            'section'  => 'indie_studio_fonts_colours_section',
        )
    )
);


/**
 * Add Colour Controls
 */ 

$wp_customize->add_setting('indie_studio_heading_text_colour', array(
    'default'	        => '#484848',
    'transport'         => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
        $wp_customize,  'indie_studio_heading_text_colour', array(
            'settings'  => 'indie_studio_heading_text_colour',
            'label'	    => __('Heading Text Color', indie_studio_text_domain()),
		    'section'	=> 'indie_studio_fonts_colours_section',
	   ) 
    ) 
);

$wp_customize->add_setting('indie_studio_paragraph_text_colour', array(
    'default'	        => '#484848',
    'transport'         => 'postMessage',
    'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( 
    new WP_Customize_Color_Control( 
        $wp_customize,  'indie_studio_paragraph_text_colour', array(
            'settings'  => 'indie_studio_paragraph_text_colour',
            'label'	    => __('Paragraph Text Color', indie_studio_text_domain()),
		    'section'	=> 'indie_studio_fonts_colours_section',
	   ) 
    ) 
);