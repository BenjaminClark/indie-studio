<?php
/**
 * Template part for displaying posts in module blocks for more recent widget
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

<article id="post-<?php the_ID(); ?>" <?php post_class('col-4 module' . $module_class); ?><?php schema_semantics_tags( 'post' );?> itemref="site-publisher">

    <a href="<?php the_permalink(); ?>" class="u-url url" title="<?php printf( esc_attr__( 'Link to %s', indie_studio_text_domain() ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark" itemprop="url">

        <?php if ( get_post_gallery_images() > 1 && get_post_format() == 'gallery' ) { 
        
            indie_studio_the_module_gallery_images(true);
        
        } else {
        
            indie_studio_the_module_image();
    
        }       
        
        if( get_the_excerpt() ){ 
        
            $post_title = get_the_title();
            $title      = ( ! empty( $post_title ) ) ? $post_title : __( '(no title)' );
            
        ?>
        
            <div class="entry-text sneak-in">
                <h2 class="entry-title p-name" itemprop="name headline"><?php echo $title; ?></h2>
                
                <?php indie_studio_posted_on(); ?>
                
                <?php if( get_the_excerpt() ){ ?>
                    <p><?php echo get_the_excerpt(); ?></p>
                <?php } ?>
                
            </div>
	
        <?php        
        }
        ?>

	</a>
	
</article>