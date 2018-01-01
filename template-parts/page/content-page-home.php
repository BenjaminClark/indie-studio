<?php
/**
 * The template used for displaying page content on the homepage
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('page'); ?><?php schema_semantics_tags( 'post' );?>>
	<div class="entry-content e-content" itemprop="description text">
	    <div class="wysiwyg">
		    <?php the_content(); ?>
		</div>
	</div>
</article>