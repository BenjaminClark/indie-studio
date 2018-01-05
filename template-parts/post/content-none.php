<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?>

<article id="post-0" class="post no-results not-found">
   
    <div class="thin-inner">

        <header class="entry-header">
            <h1 class="entry-title p-entry-title"><?php _e( 'Nothing Found', indie_studio_text_domain() ); ?></h1>
        </header><!-- .entry-header -->
    
        <div class="entry-content e-entry-content">
            <?php
            if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

                <p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', indie_studio_text_domain() ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

            <?php } else { ?>

                <p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', indie_studio_text_domain() ); ?></p>
                <?php
                get_search_form();

            } ?>
        </div><!-- .page-content -->
        
    </div>
        
</article><!-- .no-results -->
