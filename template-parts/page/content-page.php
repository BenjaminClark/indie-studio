<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php schema_semantics_tags( 'post' );?>>

	<header class="entry-header">
		<h1 class="entry-title p-name" itemprop="name headline"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<?php indie_studio_the_post_thumbnail( '<div class="entry-media">', '</div>' ); ?>

	<div class="entry-content e-content" itemprop="description text">
	    <div class="wysiwyg">
		    <?php the_content(); ?>
		</div>
		<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain()  ), 'after' => '</div>' ) ); ?>
		<?php edit_post_link( __( 'Edit', indie_studio_text_domain()  ), '<span class="edit-link">', '</span>' ); ?>
	</div><!-- .entry-content -->
	
</article><!-- #post-<?php the_ID(); ?> -->