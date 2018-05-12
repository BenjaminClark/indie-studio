<?php

/**
 * This creates the header section for all articles
 * 
 * If it is not a search item - show categories
 **/ 

?>

<header class="entry-header">
   
    <h1 class="entry-title p-name" itemprop="name headline"><a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h1>

    <div class="entry-meta group">
       
        <?php if ( ! is_search() ) { ?>

            <?php indie_studio_posted_details(); ?>

            <?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list( __( ', ', indie_studio_text_domain() ) );
            if ( $categories_list ) {
            ?>

            <span class="cat-links">
                <?php printf( __( 'in %1$s', indie_studio_text_domain() ), $categories_list ); ?>
            </span>

            <?php } // End if categories ?>

            <?php edit_post_link( __( 'Edit', indie_studio_text_domain() ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
            
        <?php } else { ?>
        
            <?php indie_studio_posted_on(); ?>
        
        <?php } ?>

    </div>
   
</header>