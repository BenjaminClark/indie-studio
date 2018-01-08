<?php

//Add image functions here
//add_image_size( 'module', 400, 400 );

add_image_size( 'module', 520, 400 ); //New size, kept old incase revision was needed

add_image_size( 'article-banner', 2000, 824, true );

/**
 * Add SVG support
 **/

function add_svg_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'add_svg_mime_types');


//https://www.sitepoint.com/wordpress-svg/
//call our function when initiated from JavaScript
add_action('wp_ajax_get_attachment_url_media_library', 'get_attachment_url_media_library');

//called via AJAX. returns the full URL of a media attachment (SVG) 
function get_attachment_url_media_library(){

    $url = '';
    $attachmentID = isset($_REQUEST['attachmentID']) ? $_REQUEST['attachmentID'] : '';
    if($attachmentID){
        $url = wp_get_attachment_url($attachmentID);
    }

    echo $url;

    die();
}


/** 
 * Check if a file is an SVG 
 * 
 * @param  string $filePath Filepath for file to check
 * @return boolean
**/

function isSvg( $filePath ){
    if( get_extension($filePath) == 'svg' ){
        return true;
    } else {
        return false;
    }
}


/** 
 * Add Custom Images for gallery
 * 
 * Adds gallery shortcode defaults of size="medium" and columns="3"
 **/

function indie_studio_gallery_atts( $out, $pairs, $atts ) {
    $atts = shortcode_atts( array(
      'columns' => '3',
      'size' => 'medium',
    ), $atts );
 
    $out['columns'] = $atts['columns'];
    $out['size'] = $atts['size'];
 
    return $out;
 
}
add_filter( 'shortcode_atts_gallery', 'indie_studio_gallery_atts', 10, 3 );