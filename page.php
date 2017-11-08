<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @link https://codex.wordpress.org/Post_Type_Templates
 * @link https://www.tsartsaris.gr/how-to-properly-makrup-your-blog-and-blogposts-with-html5-schema-microdata
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php
        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/page/content', 'page' );

            // If comments are open or we have at least one comment, show the comment template
            if ( comments_open() || get_comments_number() != 0 ){
                comments_template( '', true );
            }

        endwhile; // End of the loop.
        ?>

    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer();