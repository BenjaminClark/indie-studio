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

                <header class="page-header">
                   <?php
                        the_archive_title( '<h1 class="page-title">', '</h1>' );
                        $tag_description = tag_description();
                        if ( ! empty( $tag_description ) ) {
                            echo apply_filters( 'tag_archive_meta', '<div class="tag-archive-meta">' . $tag_description . '</div>' );
                        }
                    ?>
                </header>
                
                <?php rewind_posts(); ?>

                <?php get_template_part( 'loop' );?>
                
            <?php } else { ?>
            
                <?php get_template_part( 'no-posts' );?>
            ?>
        
        </div>

    </main>
</section>

<?php get_footer(); ?>