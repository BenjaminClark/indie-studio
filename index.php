<?php 
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * 
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>
    
    <section id="primary" class="content-area">
        <main id="main" class="site-main" role="main">
            
            <div class="page-inner-wrap">

                <?php if ( have_posts() ) { ?>

                    <div id="ajax-post-wrap" class="grid-container bricklayer basic">

                        <?php while ( have_posts() ) : the_post();

                            get_template_part( 'template-parts/post/module', get_post_format() );


                        endwhile; // end of the loop. 

                        ?>

                    </div>
                   
                    <?php

                    indie_studio_content_nav( 'nav-below', 'load-more' );

                } else {

                    get_template_part( 'template-parts/post/content', get_post_format() );

                }
                ?>
                
            </div>

        </main><!-- #content -->
    </section><!-- #primary -->

<?php get_footer(); ?>