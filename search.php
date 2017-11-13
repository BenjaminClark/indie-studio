<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>

<section id="primary">
    <main id="content" role="main">

    <?php if ( have_posts() ) { ?>

        <header class="page-header">
            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', indie_studio_text_domain() ), '<span>' . get_search_query() . '</span>' ); ?></h1>
        </header>

        <?php /* Start the Loop */ ?>
        <?php while ( have_posts() ) : the_post(); ?>

            <?php get_template_part( 'content', 'search' ); ?>

        <?php endwhile; ?>

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

    <?php } ?>

    </main>
</section>

<?php get_footer(); ?>