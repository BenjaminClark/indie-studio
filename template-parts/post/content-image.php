<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <figure class="entry-media">
    
        <?php indie_studio_the_post_thumbnail(); ?>
        
        <figcaption><?php echo get_post( get_post_thumbnail_id() )->post_excerpt; ?></figcaption>
        
    </figure>
    
    <div class="thin-inner">

        <?php get_template_part( 'template-parts/entry/entry', 'header' ); ?>

        <?php if ( is_search() ) { // Only display Excerpts for Search ?>

            <div class="entry-summary p-summary" itemprop="description">
                <?php the_excerpt(); ?>
            </div>

        <?php } else { ?>

            <div class="entry-content e-content" itemprop="description articleBody">

               <div class="wysiwyg group">

                    <?php 
                    the_content( __( 'Continue reading', indie_studio_text_domain() ) );
                    wp_link_pages( array( 
                        'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain() ), 
                        'after' => '</div>' 
                    ) ); 
                    ?>

                </div>

            </div>
            
        <?php } ?>
        
        <?php get_template_part( 'template-parts/entry/entry', 'footer' );?>
	
	</div>
	
</article>