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
        
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    
    <link rel="profile" href="http://microformats.org/profile/specs"/>
    <link rel="profile" href="http://microformats.org/profile/hatom"/>    
    <?php if( get_option( 'page_for_posts' ) ){ ?>
    <link rel="feed" href="<?php echo get_permalink( get_option( 'page_for_posts' ) ); ?>"/>
    <?php } ?>
    <link href="<?php echo site_url();?>" rel="me"/>
    <?php
    
	wp_head(); 
        
    /**
     * Custom Header Scripts
     */

    echo get_theme_mod('indie_studio_scripts_header', '');
    
    ?>
    
</head>
   
<body <?php body_class('no-js no-touch'); ?><?php get_schema_semantics( 'body' ); ?>>
    
    <!-- Remove no-js tag immediately -->
    <script>document.querySelector('body').classList.remove('no-js');</script>
    
    <div id="footer-pusher"><!-- Push footer to bottom -->
    
        <header id="header"> 
                       
            <div class="page-inner-wrap group">

                <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>

            </div>
            
        </header>
        
        <div id="page-wrapper">