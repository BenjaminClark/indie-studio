<?php


/**
 * IN FUTURE COULD THIS SYSTEM BE CONTAINED WITHIN THE MODULE ?
 **/ 


/**
 * This function directs the post IDs to individual functions depending on 
 * the content layout required, and then passes it back to the loop
 **/

function indie_studio_create_loop_layout( $post_type, $post_id, $search, $feat ){
    
    $html = '';
    
    if($post_type == 'post'){
        $html = trim(preg_replace('/\s+/', ' ', createPostBlock( $post_id )));
    }
        
    return $html;
    
}


/******************************************************
 * Below this point are the individual item creators
 *****************************************************/ 

/**
 * This section creates a POST related block to pass back as HTML
 **/
