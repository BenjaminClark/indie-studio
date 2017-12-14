<?php 
/**
 * The template for showing all single posts.
 * 
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 * @link https://codex.wordpress.org/Post_Type_Templates
 * @link https://www.tsartsaris.gr/how-to-properly-makrup-your-blog-and-blogposts-with-html5-schema-microdata
 * @link http://buildwpyourself.com/get-template-part/
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>

<section id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

       <div class="page-inner-wrap">

            <?php 
            while ( have_posts() ) : the_post();
           
                get_template_part( 'template-parts/post/content', get_post_format() );

                // If comments are open or we have at least one comment, show the comment template
                if ( comments_open() || get_comments_number() != 0 ){
                    comments_template( '', true );
                }

                /**
                 * @TODO Add attractive post navigation.
                 **/ 

            endwhile; // end of the loop. 
            ?>

        </div>

    </main><!-- #content -->
</section><!-- #primary -->

<?php get_footer();