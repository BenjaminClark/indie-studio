<?php
/**
 * Template part for displaying gallery posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

	<?php get_template_part( 'template-parts/entry/entry', 'header' ); ?>

	<?php if ( is_search() ) { // Only display Excerpts for Search ?>

        <div class="entry-summary p-summary" itemprop="description">
            <?php the_excerpt(); ?>
        </div>
	
	<?php } ?>
		
	<?php    
        if ( '' !== get_the_post_thumbnail() && ! is_single() && ! get_post_gallery() ) { 
            indie_studio_the_post_thumbnail( '<div class="entry-media">', '</div>' );
        }
	?>
       
        <div class="entry-content e-content" itemprop="description articleBody">
           
           <div class="wysiwyg">

                <?php
                if ( ! is_single() ) {

                    // If not a single post, highlight the gallery.
                    if ( get_post_gallery() ) {
                        echo '<div class="entry-gallery">';
                            echo get_post_gallery();
                        echo '</div>';
                    };

                };

                if ( is_single() || ! get_post_gallery() ) {

                    the_content( __( 'Continue reading', indie_studio_text_domain() ) );
                    wp_link_pages( array( 
                        'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain() ), 
                        'after' => '</div>' 
                    ) ); 

                }
                ?>
            
            </div>
            
        </div>

	<?php
	if ( is_single() ) {
        get_template_part( 'template-parts/entry/entry', 'footer' );
	}
	?>
	
</article>