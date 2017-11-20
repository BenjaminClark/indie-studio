<?php

/**
 * Get the first video for the post
 
 * @param Int $post_id The post ID to get the video from
 */

function get_first_wordpress_video( $post_id ){
    //Get the IFrames from the WYSIWYG and return the first one found
    $content = apply_filters('the_content', get_post_field('post_content', $post_id));
    $videos = get_media_embedded_in_content( $content, array('video', 'iframe' ) );    
    if( !empty($videos)){
        return $first_vid = $videos[0];
    }
    return false;
}


/**
 * Is the video hosting on WordPress
 * 
 * Checks a URL or Iframe string to see if the URL is from the current site
 * 
 * @param string $url The video URL or Iframe string
 */

function is_wordpress_hosted_video( $url ){    
    if ( strpos($url, content_url() ) !== false ) {
        return true;   
    }
    return false;
}


/**
 * Get the URL from an Iframe
 * 
 * @param string $iframe Complete Iframe string
 */

function get_url_from_iframe( $iframe ){
    preg_match('/src="([^"]*)"/i', $iframe, $matches);
    if( isset($matches[1]) ){
        return strtok($matches[1], '?');
    }
    return false;    
}


/**
 * Extracted the video provider from a URL
 * 
 * @param string $url Video URL
 */

function get_video_provider( $url ){
    if ( strpos($url, 'youtube' ) !== false ) {
        return 'youtube';
    }
    if ( strpos($url, 'vimeo' ) !== false ) {
        return 'vimeo';
    }
    return false;
}


/**
 * Return ID from Youtube link
 * 
 * @param string $url Youtube link
 */

function get_youtube_video_id( $url ){
    preg_match("#([\/|\?|&]vi?[\/|=]|youtu\.be\/|embed\/)(\w+)#", $url, $matches);
    if( isset($matches[2]) ){
        return $matches[2];
    }
    return false;   
}


/**
 * Return ID from Vimeo link
 * 
 * @param string $url Vimeo link
 */

function get_vimeo_video_id( $url ){
    if(preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $url, $matches)) {
        return $matches[5];
    }
    return false;   
}


/**
 * Get Youtube Video Still from API
 * 
 * @param string $id The video ID
 * @return string Still image URL
 */
function get_youtube_video_still( $id = null ){
    if ( $id ){
        return 'https://img.youtube.com/vi/' . $id . '/0.jpg';
    }
    return false;
}


/**
 * Get Vimeo Video Still from API
 * 
 * @param string $id The video ID
 * @return string Still image URL
 */
function get_vimeo_video_still( $id = null ){
    if ( $id ){
        $vimeo_api = unserialize( file_get_contents("http://vimeo.com/api/v2/video/$vimeo_id.php") );#
        if ( !empty( $vimeo_api[0]['thumbnail_large'] ) ) {
            return $vimeo_api[0]['thumbnail_large'];
        } 
    }
    return false;
}

/**
 * Get the video placeholder from video URL
 * 
 * @param string $url Video Url              
 * @return string placeholder URL
 */

function get_video_placeholder( $url = null ){

    if ( $url ){

        $provider = get_video_provider( $url );

        if ( $provider == 'youtube' ){
            return get_youtube_video_still( get_youtube_video_id( $url ) );
        }
        
        if ( $provider == 'vimeo' ){
            return get_vimeo_video_still( get_vimeo_video_id( $url ));
        }

    }

    return false;
    
}