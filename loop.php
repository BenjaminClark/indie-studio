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

}