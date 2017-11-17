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

        <?php if ( have_posts() ) : ?>

            <?php
                /* Queue the first post, that way we know
                 * what author we're dealing with (if that is the case).
                 *
                 * We reset this later so we can run the loop
                 * properly with a call to rewind_posts().
                 */
                the_post();
            ?>

            <header class="page-header author vcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person">
                <h1 class="page-title"><?php printf( __( 'Author: %s', indie_studio_text_domain() ), '<a class="url u-url fn p-fn n p-name" href="' . get_author_posts_url( get_the_author_meta( 'ID' ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me author" itemprop="url"><span itemprop="name">' . get_the_author() . '</span></a>' ); ?></h1>
                <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
            <?php if ( get_the_author_meta( 'description' ) ) { ?>
                <div class="author-note note p-note" itemprop="description"><p><?php echo get_the_author_meta( 'description' ); ?></p></div>
            <?php } ?>
            </header>

            <?php
                /* Since we called the_post() above, we need to
                 * rewind the loop back to the beginning that way
                 * we can run the loop properly, in full.
                 */
                rewind_posts();
            ?>

            <div id="ajax-post-wrap">

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'template-parts/post/content', 'search' ); ?>

                <?php endwhile; ?>

            </div>

            <?php indie_studio_content_nav( 'nav-below', 'Load More' ); ?>

        <?php else : ?>

            <article id="post-0" class="post no-results not-found">

                <header class="entry-header">
                    <h1 class="entry-title p-entry-title"><?php _e( 'Nothing Found', indie_studio_text_domain() ); ?></h1>
                </header><!-- .entry-header -->

                <div class="entry-content e-entry-content">
                    <p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', indie_studio_text_domain() ); ?></p>
                    <?php get_search_form(); ?>
                </div>

            </article>

        <?php endif; ?>
        
        </div>

    </main>
</section>

<?php get_footer(); ?>