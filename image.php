<?php
/**
 * The template for displaying image attachments.
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

get_header(); ?>

<section id="primary" class="image-attachment full-width">
    <main id="content" role="main">
        
        <div class="page-inner-wrap">

        <?php while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>itemscope itemtype="http://schema.org/ImageObject">
                <header class="entry-header">
                   
                    <h1 class="entry-title p-entry-title" itemprop="name"><?php the_title(); ?></h1>

                    <div class="entry-meta">
                        <?php
                            $metadata = wp_get_attachment_metadata();
                            printf( __( 'Published <time class="entry-date updated dt-updated" datetime="%1$s" itemprop="dateModified">%2$s</time> at <a href="%3$s" title="Link to full-size image">%4$s &times; %5$s</a> in <a href="%6$s" title="Return to %7$s" rel="gallery">%7$s</a>', indie_studio_text_domain() ),
                                esc_attr( get_the_time() ),
                                get_the_date(),
                                wp_get_attachment_url(),
                                $metadata['width'],
                                $metadata['height'],
                                get_permalink( $post->post_parent ),
                                get_the_title( $post->post_parent )
                            );
                        ?>
                        <?php edit_post_link( __( 'Edit', indie_studio_text_domain() ), '<span class="sep">|</span> <span class="edit-link">', '</span>' ); ?>
                    </div><!-- .entry-meta -->
                    
                </header><!-- .entry-header -->

                <div class="entry-content e-content" itemprop="description">

                    <div class="entry-attachment">
                       
                        <div class="attachment">
                            <?php
                            echo wp_get_attachment_image( $post->ID, array( '1200', '1200' ), null, array( 'itemprop' => 'image contentURL' ) ); // filterable image width with, essentially, no limit for image height.
                            ?>
                        </div><!-- .attachment -->

                        <?php if ( ! empty( $post->post_excerpt ) ) : ?>
                        <div class="entry-caption">
                            <?php the_excerpt(); ?>
                        </div>
                        <?php endif; ?>
                    </div><!-- .entry-attachment -->

                    <?php the_content(); ?>

                </div><!-- .entry-content -->

                <footer class="entry-meta">
                    <?php if ( comments_open() && pings_open() ) : // Comments and trackbacks open ?>
                        <?php printf( __( '<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', indie_studio_text_domain() ), get_trackback_url() ); ?>
                    <?php elseif ( ! comments_open() && pings_open() ) : // Only trackbacks open ?>
                        <?php printf( __( 'Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', indie_studio_text_domain() ), get_trackback_url() ); ?>
                    <?php elseif ( comments_open() && ! pings_open() ) : // Only comments open ?>
                        <?php _e( 'Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', indie_studio_text_domain() ); ?>
                    <?php elseif ( ! comments_open() && ! pings_open() ) : // Comments and trackbacks closed ?>
                        <?php _e( 'Both comments and trackbacks are currently closed.', indie_studio_text_domain() ); ?>
                    <?php endif; ?>
                    <?php edit_post_link( __( 'Edit', indie_studio_text_domain() ), ' <span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-meta -->
                
            </article>

            <?php comments_template(); ?>

        <?php endwhile; // end of the loop. ?>

        </div>
   
    </main>
</section>

<?php get_footer(); ?>