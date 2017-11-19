<?php

/**
 * Get the first Iframe for the post
 
 * @param Int $post_id The post ID to get the video from
 */

function get_first_iframe( $post_id ){
    //Get the IFrames from the WYSIWYG and return the first one found
    $content = apply_filters('the_content', get_post_field('post_content', $post_id));
    $iframes = get_media_embedded_in_content( $content, 'iframe' );
    if(isset($iframes)){
        return $first_vid = $iframes[0];
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
        return $matches[1];
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
 * Get the video placeholder from video URL
 * 
 * @param string $url Video Url
 *                          
 * @return string
 */
function get_video_placeholder( $url = null ){

    if ( $url ){

        $provider = get_video_provider( $url );

        if ( $provider == 'youtube' ){
            $youtube_id = get_youtube_video_id( $url );
            if ( $youtube_id ){
                return 'https://img.youtube.com/vi/' . $youtube_id . '/0.jpg';
            }
        }
        
        if ( $provider == 'vimeo' ){
            $vimeo_id = get_vimeo_video_id( $url );
            if ( $vimeo_id ){
                $vimeo_api = unserialize( file_get_contents("http://vimeo.com/api/v2/video/$vimeo_id.php") );#
                if ( !empty( $vimeo_api[0]['thumbnail_large'] ) ) {
                    return $vimeo_api[0]['thumbnail_large'];
                }
            }
        }

    }

    return false;
    
}