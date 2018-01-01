<?php
/**
 * Template part for displaying parent child posts in module blocks
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @link https://codex.wordpress.org/Function_Reference/get_post_gallery_images
 * @link https://codex.wordpress.org/Function_Reference/get_post_gallery
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

$module_class = get_post_format();
if ( $module_class ) {
    $module_class = ' module-' . $module_class;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-4 module masonry-brick child' . $module_class); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Link to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">

        <?php if ( get_post_gallery_images() > 1 && get_post_format() == 'gallery' ) { 
        
            indie_studio_the_module_gallery_images(true);
        
        } else {
        
            indie_studio_the_module_image();
    
        }
        
        ?>

        <div class="entry-text sneak-in">
            <h2 class="entry-title p-name" itemprop="name headline"><?php the_title(); ?></h2>
        </div>
        
	</a>
	
</article>