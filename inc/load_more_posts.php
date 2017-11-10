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

        ?>
        <div id="load-more-posts-error" class="load-more-posts-error error" style="opacity:0;"><?php echo esc_html__( 'Something has gone wrong. Please try again.', indie_studio_text_domain() );?></div>
        <button id="load-more-posts" class="load-more-posts-button" data-paged="<?php echo esc_attr__( $paged, indie_studio_text_domain() );?>" data-max-pages="<?php echo $wp_query->max_num_pages;?>" data-total-pages="<?php echo $wp_query->found_posts;?>" style="opacity:0;"><?php echo esc_html__( $button_text, indie_studio_text_domain() );?></button>
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
        
        $args = (array) $_POST['query'];
        
        $args['paged'] = sanitize_text_field( $_POST['paged'] );
        
        $query = new WP_Query( $args );
        
        $posts = $query->get_posts();
        
        ob_start();
        
        foreach( $posts as $post ) {
            setup_postdata( $post );
            
            get_template_part( 'template-parts/content', get_post_format( $post->ID ) );
            
            wp_reset_postdata();
        }
        
        $html = ob_get_clean();
        
        write_log($html);
        
        die ( json_encode ( trim(preg_replace('/\s+/', ' ', $html ) ) ) );
        
    }

    die();
    
}

add_action('wp_ajax_indie_studio_load_more_posts', 'indie_studio_load_more_posts');
add_action('wp_ajax_nopriv_indie_studio_load_more_posts', 'indie_studio_load_more_posts');