<?php

/**
 * Create the load more button with all required WP_Query data
 * 
 * @param string $button_text The text to show in the button
 */

function indie_studio_load_more_button( $button_text = '' ){
 
    global $wp_query;
            
    //If there are more than 1 page to show, and there is a next page avalible
    if ( $wp_query->max_num_pages > 1 && get_next_posts_link() ){
       
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        
        /**
         * Decide is a custom template is required for AJAX
         */ 
        
        $template = '';
        
        if( is_search() || is_author() ){
            $template = 'search';
        } 
        
        ?>
        <div id="load-more-posts-error" class="load-more-posts-error error smooth"><p><?php echo esc_html__( 'Something has gone wrong. Please try again.', indie_studio_text_domain() );?></p></div>
        <button id="load-more-posts" class="load-more-posts-button" data-paged="<?php echo esc_attr__( $paged, indie_studio_text_domain() );?>" data-query='<?php echo json_encode ( $wp_query->query ) ;?>' data-custom-template="<?php echo $template;?>" style="opacity:0;"><?php echo esc_html__( $button_text, indie_studio_text_domain() );?></button>
    <?php
    }
}


/**
 * Ajax handler for load more posts
 */

function indie_studio_load_more_posts() {
    
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    }
    
    check_ajax_referer( 'indie_studio_nonce', 'security' );
    
    if ( !empty( $_POST['paged'] ) ) {

        global $post;
        
        //Increase the page by 1, as we have been given the "CURRENT" page. Not the next page
        $return = array(
            'html'      => '',
            'load_more' => false,
            'paged'     => ( intval ( sanitize_text_field( $_POST['paged'] ) ) + 1 ),
        );
                
        // Get query from JS, turn back into array, sanitize
        $args = (array) clean_all( json_decode( stripslashes( $_POST['query'] ), true ) );
           
        //If we require a custom template, get that here
        $custom_template = sanitize_text_field ( $_POST['template'] );
        
            
        //Updated paged
        $args['paged'] = $return['paged'];
        
        //This is needed to force "drafts" not to show when logged in
        $args['post_status'] = 'publish';
        
        $query = new WP_Query( $args );        
                
        $posts = $query->get_posts();
        
        //Are there more posts to load?
        $total_posts_per_page =  get_option( 'posts_per_page' );
        $num_of_posts = $query->found_posts;
        $num_of_pages = round( $num_of_posts / $total_posts_per_page );

        
        //If the total number of pages, is greater than the current page
        //show the load more button
        if ( $num_of_pages > $args['paged'] ){
            $return['load_more'] = true;
        }

        
        /**
         * Capture all that post template goodness
         **/ 
                
        foreach( $posts as $post ) {
            setup_postdata( $post );
            
            ob_start();
            
            /**
             * Here we use the get_template_part to repeatedly create each post we need.
             * 
             * This does not feel 100% right, but it eliminates the need repeating the template code.
             *
             * A soloution to come back to, might be to make a module like function
             * to pass template_parts, and ajax requests to. However, this seems like just 
             * rewriting the template_part functionality.
             * 
             * @TODO Revisit
             **/ 
            
            /**
             * If the query is for search, show search templates
             */ 
            
            if ( $custom_template ){
            
                get_template_part( 'template-parts/post/content', $custom_template );
                
            } else {
                
                get_template_part( 'template-parts/post/module', get_post_format( $post->ID ) );
                
            }
            
            $return['html'][] = trim( preg_replace('/\s+/', ' ', ob_get_clean() ) );
            
            wp_reset_postdata();
            
        }
        
        die ( json_encode ($return ) );
        
    }

    die();
    
}

add_action('wp_ajax_indie_studio_load_more_posts', 'indie_studio_load_more_posts');
add_action('wp_ajax_nopriv_indie_studio_load_more_posts', 'indie_studio_load_more_posts');