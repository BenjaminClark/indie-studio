<?php
/**
 * The template for the theme
 * 
 * This is the template that displays all of the <head> section and everything up until <div id="page-wrapper">
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    
<head>
    
    <meta charset="<?php bloginfo( 'charset' ); ?>" />   
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Hide due to conflict with WC3 recommendations -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"> -->
    
    <meta name="viewport" content="width=device-width">
    
    <link rel="profile" href="http://microformats.org/profile/specs" />
    <link rel="profile" href="http://microformats.org/profile/hatom" />    

    <?php
    
	wp_head(); 
        
    /**
     * Custom Header Scripts
     */

    echo get_theme_mod('indie_studio_scripts_header', '');
    
    ?>
    
</head>
   
<body <?php body_class(); ?><?php schema_semantics_tags( 'body' ); ?>>
     
    <div id="footer-pusher"><!-- Push footer to bottom -->
    
        <header id="header"> 
                       
            <div class="page-inner-wrap">
                
                <div class="header-inner">

                    <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
                    
                </div>
                <a class="customizer-edit" title="Add the Google API key" data-control="indie_studio_google_api">Add key here</a>
            </div>
            
        </header>
        
        <div id="page-wrapper">