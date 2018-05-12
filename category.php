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

            <?php get_template_part( 'loop' );?>       
            
        </div>
    </main><!-- #main -->
</section><!-- #primary -->

<?php get_footer();