<?php
/**
 * The template for displaying Search Results
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

	<?php get_template_part( 'template-parts/entry/entry', 'header' ); ?>
	
	<div class="entry-meta">
        <?php get_the_title(); ?>
    </div>
    
	<div class="entry-summary p-summary" itemprop="description">
		<?php the_excerpt(); ?>
    </div>

    <?php 
    if ( is_front_page() && ! is_home() ) {
	   get_template_part( 'entry', 'footer' );
	} 
	?>
	
</article><!-- #post-<?php the_ID(); ?> -->






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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

	<?php get_template_part( 'template-parts/entry/entry', 'header' ); ?>

	<?php if ( is_search() ) { // Only display Excerpts for Search ?>

        <div class="entry-summary p-summary" itemprop="description">
            <?php the_excerpt(); ?>
        </div>
	
	<?php } ?>
	
	<?php indie_studio_the_post_thumbnail( '<div class="entry-media">', '</div>' ); ?>
	
        <div class="entry-content e-content" itemprop="description articleBody">
           
            <?php 
            the_content( __( 'Continue reading', indie_studio_text_domain() ) );
            wp_link_pages( array( 
                'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain() ), 
                'after' => '</div>' 
            ) ); 
            ?>
            
        </div>

	<?php
	if ( is_single() ) {
        get_template_part( 'template-parts/entry/entry', 'footer' );
	}
	?>
	
</article>