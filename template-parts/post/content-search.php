<?php
/**
 * The template for displaying Search Results
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">
	
    <div class="thin-inner">
	
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
        
    </div>
	
</article><!-- #post-<?php the_ID(); ?> -->