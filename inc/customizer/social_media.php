<?php

/**
 * Social Media Settings
 */ 

$wp_customize->add_section('indie_studio_social_media_section', array(
    'title'         => __('Social Media Details', indie_studio_text_domain()),
    'description'   => __('Here you can add your different social media accounts', indie_studio_text_domain()),
));



$wp_customize->add_setting( 'indie_studio_social_media_repeater' );

$wp_customize->add_control( new Customizer_Repeater( $wp_customize, 'indie_studio_social_media_repeater', array(
    'label'   => esc_html__('Add Social Medias', indie_studio_text_domain()),
    'section' => 'indie_studio_social_media_section',
    'priority' => 1,
    'customizer_repeater_icon_control' => true,
    'customizer_repeater_title_control' => true,
    'customizer_repeater_subtitle_control' => true,
    'customizer_repeater_text_control' => true,
    'customizer_repeater_link_control' => true,
    'customizer_repeater_shortcode_control' => true,
    'customizer_repeater_repeater_control' => true
) ) );