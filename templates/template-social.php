<?php 
/** 
 * Template Name: Social
 * 
 * The template for displaying the feed page.
 * 
 * @link https://developer.wordpress.org/reference/functions/query_posts/
 * 
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */ 

get_header(); ?>
   
<section id="primary">
    <main id="content" role="main">

        <div class="page-inner-wrap">

            <?php
            
            /**
             * Here we show the home content first
             **/
            
            if ( have_posts() ){
               
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    if( !empty_content ($post->post_content) ){
                
                        get_template_part( 'template-parts/page/content', 'page-home' );
                        
                    }
                
                endwhile;

            }
            
            /**
             * Now lets get the home loop
             **/
                                    
            $args = array(
                'category_name' => 'social',
            );

            query_posts( $args );

            if ( have_posts()  ) { 
                ?>

                <div id="ajax-post-wrap" class="grid-container masonry basic">
                    <div class="masonry-column-sizer"></div>
                    <div class="masonry-gutter-sizer"></div>
                    
                    <?php
                    while ( have_posts() ) : the_post();

                        get_template_part( 'template-parts/post/module', get_post_format() );

                    endwhile
                    ?>

                </div>

                <?php

                indie_studio_content_nav( 'nav-below', 'load-more' );

            }

            //Clean up post
            wp_reset_query();
                
            ?>           
            
        </div>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer();