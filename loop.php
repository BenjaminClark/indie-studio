<?php

/**
 * This file creates the most basic loop required for the theme
 **/ 

if ( have_posts() ) { ?>

    <div id="ajax-post-wrap" class="grid-container masonry basic">
        <div class="masonry-column-sizer"></div>
        <div class="masonry-gutter-sizer"></div>

        <?php 
        while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/post/module', get_post_format() );

        endwhile; // end of the loop. 
        ?>

    </div>

    <?php

    indie_studio_content_nav( 'nav-below', 'load-more' );

}  else { ?>

    <article class="post no-results not-found">

        <header class="entry-header">
            <h1 class="entry-title p-entry-title"><?php _e( 'Nothing Found', indie_studio_text_domain() ); ?></h1>
        </header><!-- .entry-header -->

        <?php main_search_form(); ?>

        <div class="entry-content e-entry-content">
            <p><?php _e( 'Sorry, we can&rsquo;t find what you&rsquo;re looking for. Try searching', indie_studio_text_domain() ); ?></p>
        </div>
        
    </article>

<?php } ?>