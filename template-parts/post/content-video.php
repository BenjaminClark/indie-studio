<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <div class="thin-inner">

	    <?php get_template_part( 'template-parts/entry/entry', 'header' ); ?>
       
        <?php if ( is_search() ) { // Only display Excerpts for Search ?>

            <div class="entry-summary p-summary" itemprop="description">
                <?php the_excerpt(); ?>
            </div>

        <?php } ?>

        <?php
            $content = apply_filters( 'the_content', get_the_content() );
            $video = false;

            // Only get video from the content if a playlist isn't present.
            if ( false === strpos( $content, 'wp-playlist-script' ) ) {
                $video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
            }

            if ( '' !== get_the_post_thumbnail() && ! is_single() && empty( $video ) ) { 
                indie_studio_the_post_thumbnail( '<div class="entry-media">', '</div>' );
            }
        ?>

            <div class="entry-content e-content" itemprop="description articleBody">

                <div class="wysiwyg group">

                    <?php
                    if ( ! is_single() ) {

                        // If not a single post, highlight the video file.
                        if ( ! empty( $video ) ) {
                            foreach ( $video as $video_html ) {
                                echo '<div class="entry-video">';
                                    echo $video_html;
                                echo '</div>';
                            }
                        };

                    };

                    if ( is_single() || empty( $video ) ) {

                        the_content( __( 'Continue reading', indie_studio_text_domain() ) );
                        wp_link_pages( array( 
                            'before' => '<div class="page-link">' . __( 'Pages:', indie_studio_text_domain() ), 
                            'after' => '</div>' 
                        ) ); 

                    }
                    ?>
                    
                    <?php echo get_syndication_links(); ?>

                </div>

            </div>

        <?php
        if ( is_single() ) {
            get_template_part( 'template-parts/entry/entry', 'footer' );
        }
        ?>
        
    </div>
	
</article>