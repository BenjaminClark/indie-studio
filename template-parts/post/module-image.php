<?php
/**
 * Template part for displaying posts in module blocks - fallback block
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

<article id="post-<?php the_ID(); ?>" <?php post_class('col-4 module' . $module_class); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">

        <?php indie_studio_the_module_image( true ); ?>
        
        <?php indie_studio_module_footer();?>
        
	</a>
	
</article>