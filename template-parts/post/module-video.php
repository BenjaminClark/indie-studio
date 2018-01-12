<?php
/**
 * Template part for displaying posts in module blocks - video block
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 * @link https://codex.wordpress.org/Function_Reference/get_post_gallery_images
 * @link https://codex.wordpress.org/Function_Reference/get_post_gallery
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

$module_class = get_post_format();
if ( $module_class ) {
    $module_class = ' module-' . $module_class;
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('col-4 module masonry-brick' . $module_class); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Permalink to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">

        <?php indie_studio_the_module_video_image();?>
        
        <?php if( get_the_excerpt() ){ ?>
        
            <div class="entry-text sneak-in">
                <h2 class="entry-title p-name" itemprop="name headline"><?php the_title(); ?></h2>
                <?php indie_studio_posted_on(); ?>
                
                <?php if( get_the_excerpt() ){ ?>
                    <p><?php echo get_the_excerpt(); ?></p>
                <?php } ?>
            </div>
	
        <?php
                                
            indie_studio_interaction_bar(); 
       
        } else {

            indie_studio_interaction_bar( true ); 
        
        }
        ?>
        
	</a>
	
</article>