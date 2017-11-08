<?php

if ( ! function_exists( 'indie_studio_comment' ) ) {

	/**
	 * Template for comments and pingbacks.
	 *
	 * Used as a callback by wp_list_comments() for displaying the comments.
	 *
     * @link https://codex.wordpress.org/Function_Reference/wp_list_comments
     * @link https://codex.wordpress.org/Function_Reference/comment_class
     
	 * @since IndieStudio 1.0.0
	 */

	function indie_studio_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;

		switch ( $comment->comment_type ) :
			case 'pingback' :
			case 'trackback' :
			case 'webmention' :
	?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment <?php $comment->comment_type; ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
				<div class="comment-content p-summary p-name" itemprop="text name description">
					<?php comment_text(); ?>
				</div>
				<footer>
					<div class="comment-meta commentmetadata">
						<address class="comment-author p-author author vcard hcard h-card" itemprop="creator" itemscope itemtype="http://schema.org/Person">
							<?php printf( '<cite class="fn p-name" itemprop="name">%s</cite>', get_comment_author_link() ); ?>
						</address>
						<span class="sep">-</span>
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time class="updated published dt-updated dt-published" datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished dateModified dateCreated">
						<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', indie_studio_text_domain() ), get_comment_date(), get_comment_time() ); ?>
						</time></a>
						<?php edit_comment_link( __( '(Edit)', indie_studio_text_domain() ), ' ' ); ?>
					</div>
				</footer>
			</article>
		<?php
				break;
			default :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<article id="comment-<?php comment_ID(); ?>" class="comment <?php $comment->comment_type; ?>" itemprop="comment" itemscope itemtype="http://schema.org/Comment">
				<footer>
					<address class="comment-author p-author author vcard hcard h-card" itemprop="creator" itemscope itemtype="http://schema.org/Person">
				<?php echo get_avatar( $comment, 50 ); ?>
				<?php printf( __( '%s <span class="says">says:</span>', indie_studio_text_domain() ), sprintf( '<cite class="fn p-name" itemprop="name">%s</cite>', get_comment_author_link() ) ); ?>
					</address><!-- .comment-author .vcard -->
					<?php if ( '0' === $comment->comment_approved ) : ?>
						<em><?php _e( 'Your comment is awaiting moderation.', indie_studio_text_domain() ); ?></em>
						<br />
					<?php endif; ?>

					<div class="comment-meta commentmetadata">
						<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>"><time class="updated published dt-updated dt-published" datetime="<?php comment_time( 'c' ); ?>" itemprop="datePublished dateModified dateCreated">
						<?php
						/* translators: 1: date, 2: time */
						printf( __( '%1$s at %2$s', indie_studio_text_domain() ), get_comment_date(), get_comment_time() ); ?>
						</time></a>
						<?php edit_comment_link( __( '(Edit)', indie_studio_text_domain() ), ' ' ); ?>
					</div><!-- .comment-meta .commentmetadata -->
				</footer>

				<div class="comment-content e-content p-summary p-name" itemprop="text name description"><?php comment_text(); ?></div>

				<div class="reply">
					<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div><!-- .reply -->
			</article><!-- #comment-## -->
		<?php
				break;
			endswitch;
	}
}