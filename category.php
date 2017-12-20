<?php
/**
 * The template for displaying Category Archive pages.
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>

<section id="primary">
    <main id="content" role="main">
        
        <div class="page-inner-wrap">

            <?php if ( have_posts() ) { ?>



                <div id="ajax-post-wrap" class="grid-container masonry basic">
               
                    <?php /* Start the Loop */ ?>
                    <?php while ( have_posts() ) : the_post(); ?>

                        <?php
                            /* Include the Post-Format-specific template for the content.
                             * If you want to overload this in a child theme then include a file
                             * called content-___.php (where ___ is the Post Format name) and that will be used instead.
                             */
                            get_template_part( 'template-parts/post/module', get_post_format() );
                        ?>

                    <?php endwhile; ?>

                </div>
               
                <?php 
                indie_studio_content_nav( 'nav-below', 'load-more' );

            } else {

                get_template_part( 'template-parts/post/content', 'none' );

            } ?>
        
        </div>

    </main>
</section>

<?php get_footer(); ?>