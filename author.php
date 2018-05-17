<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>

<section id="primary">
    <main id="content" role="main">

        <div class="page-inner-wrap">

            <?php if ( have_posts() ) { ?>

                <?php
                    /* Queue the first post, that way we know
                     * what author we're dealing with (if that is the case).
                     *
                     * We reset this later so we can run the loop
                     * properly with a call to rewind_posts().
                     */
                    the_post();
                ?>

                <header class="page-header author vcard h-card group" itemprop="author" itemscope itemtype="http://schema.org/Person">
                    <h1 class="page-title"><?php printf( __( 'Articles by %s', indie_studio_text_domain() ), '<a class="url u-url fn p-fn n p-name" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me author" itemprop="url"><span itemprop="name">' . get_the_author() . '</span></a>' ); ?></h1></header>

                <?php
                    /* Since we called the_post() above, we need to
                     * rewind the loop back to the beginning that way
                     * we can run the loop properly, in full.
                     */
                    rewind_posts();
                ?>

                <?php get_template_part( 'loop' );?>

            <?php } else { ?>

                <?php get_template_part( 'no-posts' );?>

            <?php } ?>
        
        </div>

    </main>
</section>

<?php get_footer(); ?>