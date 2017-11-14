<?php

//Add image functions here
add_image_size( '#', 800, 800 );


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