<?php 
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>
  
<section id="primary">
    <main id="content" role="main">
        <div class="page-inner-wrap">

            <?php if ( have_posts() ) { ?>

                <header class="page-header">
                    <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        the_archive_description( '<div class="taxonomy-description">', '</div>' );
                    ?>
                </header><!-- .page-header -->

                <?php rewind_posts(); ?>

                <?php get_template_part( 'loop' );?>
                
            <?php } ?>

        </div>
    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer();