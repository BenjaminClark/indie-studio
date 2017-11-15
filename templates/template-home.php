<?php 
/** 
 * Template Name: Home
 * 
 * The template for displaying the home page.
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
            
            if ( have_posts() ) {
               
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /* Include the Post-Format-specific template for the content.
                     * If you want to overload this in a child theme then include a file
                     * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                     */
                    get_template_part( 'template-parts/post/content', get_post_format() );
                

                endwhile;

            } else {

                get_template_part( 'template-parts/post/content', 'none' );

            } 
            
            /**
             * Now lets get the home loop
             **/
                                    
            $args = array(
                'category_name' => 'home',
            );

            query_posts( $args );

            if ( have_posts()  ) { 
                ?>

                <div id="ajax-post-wrap">

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