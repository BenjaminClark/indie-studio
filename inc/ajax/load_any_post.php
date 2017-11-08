<?php

/**
 * This page is used to house the post ajax loading for archive pages.
 * 
 * The code within this section should not be needed to be altered for any custom work.
 * All changes should be handled in sub functions - such as in the create_post_layout page
 **/


/**
 * Loads each article element by ajax
 */
 
function get_any_posts_ajax() {
    
    //check if its an ajax request, exit if not
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    }
    
    check_ajax_referer( 'indie_studio_nonce', 'security' );
    
    //How far through the posts are we?   
    $settings = array();
    
    //Post Type
    if( isset($_GET['pTy']) ){
         $settings['post_type'] = filter_var ( $_GET['pTy'], FILTER_SANITIZE_STRING);
    }
    
    //Posts Offset
    if( isset($_GET['pOf']) ){
        $settings['offset'] = filter_var ( $_GET['pOf'], FILTER_SANITIZE_STRING);
    }   
    
    //Posts Shown
    if( isset($_GET['pSh']) ){
        $settings['posts_shown'] = array_filter(explode(',', $_GET['pSh']), 'filter_json_post_ids');
    }
    
    //Post Search
    if( isset($_GET['pSe']) ){
        $settings['search'] = filter_var ( $_GET['pSe'], FILTER_SANITIZE_STRING);
    }
    
    //Post taxonomy
    if(isset($_GET['pTa'])){
        $settings['tax'] = filter_var ( $_GET['pTa'], FILTER_SANITIZE_STRING);
    }
    
    //Post Category
    if(isset($_GET['pCa'])){
        $settings['cat'] = filter_var ( $_GET['pCa'], FILTER_SANITIZE_STRING);
    }
    
    //Post year
    if(isset($_GET['pYe'])){
        $settings['year'] = filter_var ( $_GET['pYe'], FILTER_SANITIZE_STRING);
    }
    
    //Post Month
    if(isset($_GET['pMo'])){
        $settings['month'] = filter_var ( $_GET['pMo'], FILTER_SANITIZE_STRING);
    }
    
    //Post Order
    if(isset($_GET['pOr'])){             
        $posts_orderby_string = $_GET['pOr'];
        $orderby_decoded = json_decode( stripslashes( $posts_orderby_string ), true ); //If JSON is not formatted correctly, this will error
        $settings['orderby'] = array_filter($orderby_decoded, 'filter_json_post_order'); //Clean php array       
    }
                
    die( json_encode( get_any_posts( $settings ) ) );
    
} //end function

add_action('wp_ajax_get_any_posts_ajax', 'get_any_posts_ajax');
add_action('wp_ajax_nopriv_get_any_posts_ajax', 'get_any_posts_ajax');


/**
 * This function runs the loop for the archive posts
 * @param  [int array] [$posts_shown = null] [This argument is an array of post IDs already shown]
 * @return [array] [Returns an array including the html and posts shown]
 **/

function get_any_posts( $settings = array() ){

    global $post, $wpdb;
    
    /**
     * Set the defaults
     */
    
    $settings_default = array (
        'post_type'     => 'post',
        'posts_shown'   => null,
        'search'        => null,
        'tax'           => null,
        'cat'           => null,
        'year'          => null,
        'month'         => null,
        'orderby'       => array('date' => 'DESC'),
        'num_to_show'   => 12,
        'offset'        => 0
    );
        
    //Add customized settings    
    $settings = array_replace( $settings_default, $settings );
    
    $posts_array = array (
        'sent'      => $posts_shown,
        'html'      => '',
        'count'     => '',
        'complete'  => false,
    );
    
    //Set the post types the user is allowed to see.
    $accessable_post_types = indie_studio_allow_post_type_to_return(); //Set in config+
    
    //If the post type passed is not on the list - stop!
    if( !in_array( $settings['post_type'], $accessable_post_types ) ){ die(); }

    $search = false;
    
    if( $post_type == 'search' ){
        
        $search = true;
        
        //Remove 'Search' from the post types
        if( in_array( 'search', $accessable_post_types )){
            $accessable_post_types = array_diff( $accessable_post_types, array('search') );
        }
        
        //include all post types
        $settings['post_type'] = $accessable_post_types;
    }
        
    // set up our archive arguments
    $archive_args = array(
        'post_type'         => $settings['post_type'],      
        'posts_per_page'    => $settings['num_to_show'],    
        'post__not_in'      => $settings['posts_shown'],
        'post_status'       => 'publish',
        'orderby'           => $settings['orderby'],
    );
    
    //Offset posts
    if( $settings['offset'] ){
        $archive_args['offset'] = $settings['offset'] * $settings['num_to_show'];           
    }
    
    if( $settings['posts_cat'] && $settings['posts_tax'] ){
        $archive_args['tax_query'] = array(
            array(
                'taxonomy' => $settings['tax'],
                'field'    => 'slug',
                'terms'    => array( $settings['posts_cat'] ),
            ),
        );
    }
    
    if( $settings['search'] ){
        $archive_args['s'] = $settings['search'];           
    }
    
    if( $settings['year'] && $settings['month'] ){
        $archive_args['date_query'] = array(
            array(
                'year' => $settings['year'],
                'month' => $settings['month'],
            ),
        );   
    }

    $html = '';
    
    // new instance of WP_Query
    $archive_query = new WP_Query( $archive_args );
    
    if ( $archive_query->have_posts() ) {

        $count = 0;
        
        while ( $archive_query->have_posts() ) : $archive_query->the_post(); // run the custom loop

            $post_id = $post->ID;

            $posts_array['html'][]      = indie_studio_create_loop_layout( $settings['post_type'], $post_id, $search );
            $posts_array['sent'][]      = $post_id;
        
            $count++;

        endwhile;    
        
        $posts_array['count'] = $count;
        
        //If there are less items than required, we have no more to load
        if( $posts_array['count'] < $settings['num_to_show'] ) {
            $posts_array['complete'] = true;
        }

        wp_reset_postdata();  

    }
        
    return $posts_array;
    
}


/**
 * Get the total count of archive posts
 */

function get_total_published_posts( $settings ){
    
    $settings_default = array(
        'post_type'     => 'post',
        'search'        => null,
        'tax'           => null,
        'cat'           => null,
        'year'          => null,
        'month'         => null
    );
    
    //Add customized settings    
    $settings = array_replace( $settings_default, $settings );
    
    if( $settings['post_type'] == 'search' ){
        
        //include all post types
        $post_type = array(
            'post',
        );
        
    }
    
    $archive_args = array(
        'post_type'         => $settings['post_type'],
        'post_status'       => 'publish',
        'posts_per_page'    => -1,         
    ); 
    
    if( $settings['cat'] && $settings['tax'] ){
        $archive_args['tax_query'] = array(
            array(
                'taxonomy' => $settings['tax'],
                'field'    => 'slug',
                'terms'    => $settings['cat'],
            ),
        );
    }
    
    if( $settings['search'] ){
        $archive_args['s'] = $settings['search'];           
    }
    
    if( $settings['year'] && $settings['month'] ){
        $archive_args['date_query'] = array(
            array(
                'year' => $settings['year'],
                'month' => $settings['month'],
            ),
        );   
    }
        
    // create a new instance of WP_Query
    $the_query = new WP_Query( $archive_args );
        
    return ( $the_query->found_posts );
    
}


/**
 * These filters allow us to sanitize the values being
 * passed in from the user through the JS script.
 **/

//Filter IDs as int
function filter_json_post_ids($var){
    $return = trim( filter_var ( $var, FILTER_SANITIZE_NUMBER_INT) );
    return $return;
}

//Filter custom post ordering
function filter_json_post_order($var){
    $return = trim( filter_var ( $var, FILTER_SANITIZE_STRING) );
    return $return;
}

?>