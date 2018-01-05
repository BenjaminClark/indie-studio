<?php

/**
 * This page holds all the functions that pull together likes etc
 * 
 * @param int $id the post ID you want to get like counts for
 * @return int
 */


 /**
  * Return the number of likes for a particular post
  * 
  * @param int $id the post ID you want to get like counts for
  * @return int
  */
 
function get_post_like_count( $id = null ){
    
    $counter = null;
    
    if( !$id ){
        $id = get_the_ID();
    }
    
    if ( $id ){
    
        $counter = 0;
        
        $comments = get_approved_comments( $id );
        
        if( count( $comments ) > 0 ){
            
            foreach ( $comments as $comment ){
                
                if( $comment->comment_type == 'webmention'){
                    
                    $counter++;
                    
                }
                
            }
            
        }
        
    }
    
    return $counter;
    
}


 /**
  * Return the number of comments for a particular post
  * 
  * This is needed as the comments count WordPress function is 
  * unable to differentiate between likes and comments
  * 
  * @param int $id the post ID you want to get like counts for
  * @return int
  */

function get_comments_count( $id = null ){
    
    $counter = null;
    
    if( !$id ){
        $id = get_the_ID();
    }
    
    if ( $id ){
    
        $counter = 0;
        
        $comments = get_approved_comments( $id );
        
        if( count( $comments ) > 0 ){
            
            foreach ( $comments as $comment ){
                
                if( !$comment->comment_type == 'webmention'){
                    
                    $counter++;
                    
                }
                
            }
            
        }
        
    }
    
    return $counter;
    
}