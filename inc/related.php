<?php

/**
 * This function returns an array of post ids 
 * that are related to the current post
 * 
 * @return array Related post IDs
 */

function get_related_posts(){
        
    $related = getTagRelatedIDs();
    
    if( count($related) < 4 ){
        $related = getTopLevelRelatedIds( $related );
    }
    
    if( count($related) < 4 ){
        $related = getLastPostIDs( $related );
    }
    
    return $related;
      
}



/**
 * Get the most related IDs for the post ID using tags
 * 
 * @param  array $not_in This contains post ids that are already used
 * @return array Related post IDs
 */

function getTagRelatedIDs(){

    global $post;
    
    $tags = wp_get_post_tags($post->ID);
    $ids = '';

    if ($tags) {

        $tag_ids = array();
        foreach($tags as $individual_tag) {
            $tag_ids[] = $individual_tag->term_id;
        }

        $args = array(
            'post_type'         => get_post_type($post->ID),
            'post_status'       => 'publish',
            'tag__in'           => $tag_ids,
            'post__not_in'      => array($post->ID),
            'posts_per_page'    => 4, // Number of related posts to display.
            'fields'            => 'ids',
        );

        $ids = buildRelatedIds( $args, array() );

    }  
    
    return $ids;
    
}


/**
 * Get the related IDs for the post ID from the cateory
 * 
 * @param  array $not_in This contains post ids that are already used
 * @return array Related post IDs
 */

function getTopLevelRelatedIds( $passed_ids ){
    
    global $post;
    
    $term_ids = buildPostTermsArray( $post->ID );
    
    $number = 4 - count( $passed_ids );
    
    $not_in = $passed_ids;
    $not_in[] = $post->ID;
    
    $args = array(
        'post_type'             => get_post_type($post->ID),
        'post_status'           => 'publish',
        'posts_per_page'        => $number,
        'cat'                   => $term_ids,
        'post__not_in'          => $not_in,
        'fields'                => 'ids',
    );
    
    return buildRelatedIds( $args, $passed_ids );
    
}

/**
 * Get Post Terms in usable array
 */

function buildPostTermsArray( $post_id ){
        
    $post_terms = get_the_terms( $post_id, 'category' );

    $term_ids = '';
    
    if($post_terms){
        if( count($post_terms) > 0 ){
            foreach ( $post_terms as $post_term ){
                $term_ids[] = $post_term->term_id;
            }
        }
    }
    
    return $term_ids;
    
}

/**
 * Gets any post ID from the post type to act as fillers
 * @param  array $not_in This contains post ids that are already used
 * @return array Related post IDs
 */

function getLastPostIDs( $passed_ids ){
    
    global $post;
    
    $number = 4 - count( $passed_ids );
    
    $not_in = $passed_ids;
    $not_in[] = $post->ID;
    
    $args = array(
        'post_type'             => get_post_type($post->ID),
        'post_status'           => 'publish',
        'post__not_in'          => $not_in,
        'posts_per_page'        => $number,
        'fields'                => 'ids',
    );

    return buildRelatedIds( $args, $passed_ids );
    
}


/**
 * Collect all IDs that are related
 * 
 * @param  array    $args    Args for query
 * @param  array    $related_ids Current IDs
 * @return array    New ids
 */

function buildRelatedIds( $args, $related_ids ){
        
    $related_query = new wp_query( $args );

    //Add IDs to array
    if ( $related_query->have_posts() ) {
        foreach( $related_query->posts as $id ):
            $related_ids[] = $id;
        endforeach;
        wp_reset_postdata();
    } 
    
    return $related_ids;
    
}