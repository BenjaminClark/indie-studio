<footer class="entry-meta">

    <meta itemprop="wordCount" content="<?php echo word_count($post->ID);?>">
    <meta itemprop="inLanguage" content="<?php echo get_locale();?>">
    <meta itemprop="isFamilyFriendly" content="true">

	<?php
	if ( in_array( get_post_format(), array( 'aside', 'link', 'status', 'quote' ) ) ) {
		indie_studio_posted_on();
	} else {
		_e( 'Posted', indie_studio_text_domain() );
	}
	?>
	
	<?php
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ', ', indie_studio_text_domain() ) );
	if ( $categories_list ) {
	?>
	
	<span class="cat-links">
		<?php printf( __( 'in %1$s', indie_studio_text_domain() ), $categories_list ); ?>
	</span>
	
	<?php } // End if categories ?>

	<?php
	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ', indie_studio_text_domain() ) );
	if ( $tags_list ) {
	?>
	
	<span class="sep"> | </span>
	<span class="tag-links" itemprop="keywords">
		<?php printf( __( 'Tagged %1$s', indie_studio_text_domain() ), $tags_list ); ?>
	</span>
	
	<?php } // End if $tags_list ?>

	<?php if ( comments_open() || ( '0' != get_comments_number() && ! comments_open() ) ) { ?>
	
	<span class="sep"> | </span>
	<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', indie_studio_text_domain() ), __( '1 Comment', indie_studio_text_domain() ), __( '% Comments', indie_studio_text_domain() ) ); ?></span>
	
	<?php } ?>

	<?php edit_post_link( __( 'Edit', indie_studio_text_domain() ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
</footer><!-- #entry-meta -->
