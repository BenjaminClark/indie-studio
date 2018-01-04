<header class="entry-header">
   
    <?php if ( ! is_search() ) { ?>
   
        <h1 class="entry-title p-name" itemprop="name headline"><a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h1>
    
        <div class="entry-meta group">
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
            
        </div>
    
    <?php } else { ?>
       
        <h2 class="entry-title p-name" itemprop="name headline"><a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url"><?php the_title(); ?></a></h2>
    
        <div class="entry-meta group">
            <?php indie_studio_posted_on(); ?>
        </div>
    
    <?php } ?>
   

    
</header>