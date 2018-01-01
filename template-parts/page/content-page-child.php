<?php
/**
 * The template used for displaying child page content
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('child'); ?><?php schema_semantics_tags( 'post' );?>>

	<?php indie_studio_the_article_banner( '<div class="post-banner"><div class="media-fit">', '</div></div>' ); ?>
    
	<header class="entry-header">
		<h1 class="entry-title p-name" itemprop="name headline"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<div class="entry-content e-content" itemprop="description text">
	    <div class="wysiwyg">
		    <?php the_content(); ?>
		</div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain()  ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', indie_studio_text_domain()  ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->