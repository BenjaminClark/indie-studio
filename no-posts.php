<?php

/**
 * This file lets the user search if no post has been found
 **/ 

?>

<article class="post no-results not-found">

    <header class="entry-header">
        <h1 class="entry-title p-entry-title"><?php _e( 'Nothing Found', indie_studio_text_domain() ); ?></h1>
    </header><!-- .entry-header -->

    <?php main_search_form(); ?>

    <div class="entry-content e-entry-content">
        <p><?php _e( 'Sorry, we can&rsquo;t find what you&rsquo;re looking for. Try searching', indie_studio_text_domain() ); ?></p>
    </div>

</article>