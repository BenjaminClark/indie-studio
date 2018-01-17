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

    <div class="entry-media">
    
        <?php
        if ( is_single() ) {
            indie_studio_the_article_banner( '<div class="post-banner"><div class="media-fit">', '</div></div>' );
        } else {
            indie_studio_the_post_thumbnail( '<div class="entry-media">', '</div>' );
        }
        ?>
        
    </div>
    
    <div class="thin-inner">

        <?php get_template_part( 'template-parts/entry/entry', 'header' ); ?>

        <?php if ( is_search() ) { // Only display Excerpts for Search ?>

            <div class="entry-summary p-summary" itemprop="description">
                <?php the_excerpt(); ?>
            </div>

        <?php } ?>

        <div class="entry-content e-content" itemprop="description articleBody">

           <div class="wysiwyg group">

                <?php 
                the_content( __( 'Continue reading', indie_studio_text_domain() ) );
                wp_link_pages( array( 
                    'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain() ), 
                    'after' => '</div>' 
                ) ); 
                ?>
                
                <?php echo get_syndication_links(); ?>

            </div>

        </div>

        <?php
        if ( is_single() ) {            
            get_template_part( 'template-parts/entry/entry', 'footer' );
        }
        ?>
	
	</div>
	
</article>