<?php
/**
 * Template part for displaying posts in module blocks - fallback block
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('module col-4'); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">

        <?php indie_studio_the_module_image( '<div class="entry-media">', '</div>' ); ?>
        
        <h2 class="entry-title p-name" itemprop="name headline"><?php the_title(); ?></h2>
	
	</a>
	
</article>