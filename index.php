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
           
                <?php get_template_part( 'loop' );?>
            
            <?php } else { ?>

                <?php get_template_part( 'no-posts' );?>

            <?php } ?>

        </div>
    </main><!-- #content -->
</section><!-- #primary -->

<?php get_footer(); ?>