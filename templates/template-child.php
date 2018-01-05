<?php 
/** 
 * Template Name: Child Page
 * 
 * The template for displaying the parent page. This is used to display all of its sub pages within it.
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

                        /* Include the Post-Format-specific template for the content.
                         * If you want to overload this in a child theme then include a file
                         * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                         */
                        get_template_part( 'template-parts/page/content','page-child');
                
                    }

                endwhile;

            }
            
         ?>
            
        </div>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer();