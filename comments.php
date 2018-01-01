<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */


/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

?>

<div id="comments" class="comments-area">

    <div class="thin-inner">

        <div class="comments_wrapper">

        <?php if ( post_password_required() ) { ?>
            <p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', indie_studio_text_domain() ); ?></p>

        </div><!-- End Comments -->

        <?php } else { ?>

            <?php
            // You can start editing here -- including this comment!
            if ( have_comments() ) { ?>
                <h2 class="comments-title">
                    <?php
                    $comments_number = get_comments_number();
                    if ( '1' === $comments_number ) {
                        /* translators: %s: post title */
                        printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', indie_studio_text_domain() ), '<span>' . get_the_title() . '</span>' );
                    } else {
                        printf(
                            /* translators: 1: number of comments, 2: post title */
                            _nx(
                                '%1$s Reply to &ldquo;%2$s&rdquo;',
                                '%1$s Replies to &ldquo;%2$s&rdquo;',
                                $comments_number,
                                'comments title',
                                indie_studio_text_domain()
                            ),
                            number_format_i18n( $comments_number ),
                            '<span>' . get_the_title() . '</span>'
                        );
                    }
                    ?>
                </h2>


                <?php 
                /**
                 * If there are is more than 1 page of comments
                 * 
                 * @link https://codex.wordpress.org/Function_Reference/get_comment_pages_count
                 */
                if ( get_comment_pages_count() > 1 ){ // are there comments to navigate through ?>
                <nav id="comment-nav">
                    <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', indie_studio_text_domain() ); ?></h1>
                    <?php the_comments_pagination( array(
                        'prev_text' => '<span class="screen-reader-text"><i class="fa fa-angle-left" aria-hidden="true"></i> ' . __( 'Older Comments', indie_studio_text_domain() ) . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . __( 'Newer Comments', indie_studio_text_domain() ) . ' <i class="fa fa-angle-right" aria-hidden="true"></i></span>',
                    ) );?>
                </nav>
                <?php } ?>

                <ol class="commentlist">
                    <?php
                        /* Loop through and list the comments. Tell wp_list_comments()
                         * to use indie_studio_comment() to format the comments.
                         * If you want to overload this in a child theme then you can
                         * define indie_studio_comment() and that will be used instead.
                         */
                        wp_list_comments( array( 'callback' => 'indie_studio_comment', 'format' => 'html5' ) );
                    ?>
                </ol>

                <?php if ( get_comment_pages_count() > 1 ){ // are there comments to navigate through ?>
                <nav id="comment-nav">
                    <h1 class="assistive-text section-heading"><?php _e( 'Comment navigation', indie_studio_text_domain() ); ?></h1>
                    <?php the_comments_pagination( array(
                        'prev_text' => '<span class="screen-reader-text"><i class="fa fa-angle-left" aria-hidden="true"></i> ' . __( 'Older Comments', indie_studio_text_domain() ) . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . __( 'Newer Comments', indie_studio_text_domain() ) . ' <i class="fa fa-angle-right" aria-hidden="true"></i></span>',
                    ) );?>
                </nav>
                <?php } ?>

                <div id="likes"></div>

                <?php

                // If comments are closed and there are comments, let's leave a little note, shall we?
                if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
                    <p class="no-comments"><?php _e( 'Comments are closed.', indie_studio_text_domain() ); ?></p>
                <?php
                endif;

            } //End comments

            /**
             * Show the comment form
             * 
             * @link https://developer.wordpress.org/reference/functions/comment_form/
             */
            comment_form( array( 'format' => 'html5' ) ); 

            ?>
        </div>

</div><!-- #comments -->

<?php } //End comments IF statement