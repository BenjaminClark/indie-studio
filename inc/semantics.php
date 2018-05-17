<?php
/**
 * IndieStudio Semantics
 *
 * @link http://microformats.org/wiki/microformats
 * @link http://microformats.org/wiki/microformats2
 * @link http://schema.org
 * @link http://indiewebcamp.com
 *
 * @package IndieStudio
 * @subpackage semantics
 * @since IndieStudio 1.0.0
 */ 

/**
 * Adds custom classes to the array of body classes.
 * 
 * No need to add any extra classes like "single" "attachedment" ect.
 * The get_body_class filter takes care of this.
 *
 * @since IndieStudio 1.0.0
 */

function get_semantic_body_classes( $classes ) {
    
    global $wp_query;

    //Sort single or not single classes first
    if ( ! is_singular() ) {
        
        $classes[] = 'hfeed';
		$classes[] = 'h-feed';
		$classes[] = 'feed';
        
	} else {
        
        $classes = semantic_get_post_classes( $classes );
        
    }

    return $classes;
    
}
//Take the body classes and pass to the body class filter
add_filter( 'body_class', 'get_semantic_body_classes' );



/**
 * Adds custom classes to the array of post classes.
 *
 * @since IndieStudio 1.0.0
 */
function semantic_post_classes( $classes ) {
	$classes = array_diff( $classes, array( 'hentry' ) );

	if ( ! is_singular() ) {
		return semantic_get_post_classes( $classes );
	} else {
		return $classes;
	}
}
add_filter( 'post_class', 'semantic_post_classes', 99 );


/**
 * Adds custom classes to the array of comment classes.
 * Used in inc/comments.php
 *
 * @since IndieStudio 1.0.0
 */
function semantic_comment_classes( $classes ) {
	$classes[] = 'h-as-comment';
	$classes[] = 'h-entry';
	$classes[] = 'h-cite';
	$classes[] = 'p-comment';
	$classes[] = 'comment';

	return array_unique( $classes );
}
add_filter( 'comment_class', 'semantic_comment_classes', 99 );


/**
 * encapsulates post-classes to use them on different tags
 */

function semantic_get_post_classes( $classes = array() ) {
    
	// Adds a class for microformats v2
	$classes[] = 'h-entry';

	// adds microformats 2 activity-stream support
	// for pages and articles
	if ( get_post_type() === 'page' ) {
		$classes[] = 'h-as-page';
	}
	if ( ! get_post_format() && 'post' === get_post_type() ) {
		$classes[] = 'h-as-article';
	}
    
    if ( is_singular() ){
    
        if ( ! is_multi_author() ) {
            $classes[] = 'single-author';
        }

        if ( is_attachment() ){
            $classes[] = 'attachment';
        } else {
            $classes[] = 'single';
        }
        
        // adds some more microformats 2 classes based on the
        // posts "format"
        switch ( get_post_format() ) {
            case 'aside':
            case 'status':
                $classes[] = 'h-as-note';
                break;
            case 'audio':
                $classes[] = 'h-as-audio';
                break;
            case 'video':
                $classes[] = 'h-as-video';
                break;
            case 'gallery':
            case 'image':
                $classes[] = 'h-as-image';
                break;
            case 'link':
                $classes[] = 'h-as-bookmark';
                break;
        }
        
    }

	return array_unique( $classes );
}

/**
 * Adds microformats v2 support to the comment_author_link.
 *
 * @since IndieStudio 1.0.0
 */
function semantic_author_link( $link ) {
	// Adds a class for microformats v2
	return preg_replace( '/(class\s*=\s*[\"|\'])/i', '${1}u-url ', $link );
}
add_filter( 'get_comment_author_link', 'semantic_author_link' );

/**
 * Adds microformats v2 support to the get_avatar() method.
 *
 * @since IndieStudio 1.0.0
 */
function semantic_pre_get_avatar_data( $args, $id_or_email ) {
	if ( ! isset( $args['class'] ) ) {
		$args['class'] = array();
	}

	// Adds a class for microformats v2
	$args['class'] = array_unique( array_merge( $args['class'], array( 'u-photo' ) ) );
	$args['extra_attr'] = 'itemprop="image"';

	return $args;
}
add_filter( 'pre_get_avatar_data', 'semantic_pre_get_avatar_data', 99, 2 );


/**
 * add semantics
 *
 * @param string $id the class identifier
 * @return array
 */
function get_schema_semantics( $id = null ) {
	$classes = array();

	// add default values
	switch ( $id ) {
            
		case 'body':
			if ( ! is_singular() ) {
				$classes['itemscope'] = array( '' );
				$classes['itemtype'] = array( 'http://schema.org/Blog', 'http://schema.org/WebPage' );
			} elseif ( is_single() ) {
				$classes['itemscope'] = array( '' );
				$classes['itemtype'] = array( 'http://schema.org/BlogPosting' );
			} elseif ( is_page() ) {
				$classes['itemscope'] = array( '' );
				$classes['itemtype'] = array( 'http://schema.org/WebPage' );
			}
			break;
		case 'site-title':
			if ( ! is_singular() ) {
				$classes['itemprop'] = array( 'name' );
				$classes['class'] = array( 'p-name' );
			}
			break;
		case 'site-description':
			if ( ! is_singular() ) {
				$classes['itemprop'] = array( 'description' );
				$classes['class'] = array( 'p-summary', 'e-content' );
			}
			break;
		case 'site-url':
			if ( ! is_singular() ) {
				$classes['itemprop'] = array( 'url' );
				$classes['class'] = array( 'u-url', 'url' );
			}
			break;
		case 'post':
			if ( ! is_singular() ) {
				$classes['itemprop'] = array( 'blogPost' );
				$classes['itemscope'] = array( '' );
				$classes['itemtype'] = array( 'http://schema.org/BlogPosting' );
			}
			break;
	}

	return $classes;
    
}

/**
 * Output the correct schema depending on the page
 * This is obtained using the indiestudio_get_semantics function
 *
 * @param string $id the class identifier
 */
function schema_semantics_tags( $id ) {
    
	$classes = get_schema_semantics( $id );

	if ( ! $classes ) {
		return;
	}

	foreach ( $classes as $key => $value ) {
		echo ' ' . esc_attr( $key ) . '="' . esc_attr( join( ' ', $value ) ) . '"';
	}
    
}


if ( ! function_exists( 'indie_studio_posted_on' ) ) {
    
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
    
	function indie_studio_posted_on() {
		printf( __( '<p><time class="entry-date updated published dt-updated dt-published" datetime="%1$s" itemprop="dateModified datePublished">%2$s</time></p>', indie_studio_text_domain() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_time_difference( get_the_date('Y-m-d H:i:s') ) )
		);
	}
}


if ( ! function_exists( 'indie_studio_posted_details' ) ) {
    
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
    
	function indie_studio_posted_details() {
		printf( __( 'Published by <address class="byline"><a class="url uid u-url u-uid fn p-name" href="%1$s" title="%2$s" rel="author" itemprop="url"><span class="author p-author vcard hcard h-card" itemprop="author" itemscope itemtype="http://schema.org/Person"><span itemprop="name">%3$s</span></span></a></address> on <a href="%4$s" title="%5$s" rel="bookmark" class="entry-date-link url u-url"><time class="entry-date updated published dt-updated dt-published" datetime="%6$s" itemprop="dateModified datePublished">%7$s</time></a>', indie_studio_text_domain() ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_attr( sprintf( __( 'View all posts by %s', indie_studio_text_domain() ), get_the_author() ) ),
            get_the_author(), // Removed "esc_html" due to Microformat plugin adding spans
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
	}    
    
}


if ( ! function_exists( 'indie_studio_content_nav' ) ) {
    
	/**
	 * Display navigation when applicable
	 *
	 * @since IndieStudio 0.0.54
	 */
    
	function indie_studio_content_nav( $nav_id, $button_text = null ) {
        
		global $wp_query;

        if ( $wp_query->max_num_pages > 1 ){
        
		?>
            <nav id="<?php echo esc_attr( $nav_id ); ?>">
               
                <h1 class="assistive-text section-heading screen-reader-text"><?php _e( 'Post navigation', indie_studio_text_domain() ); ?></h1>

                <?php if ( is_single() ) { // navigation links for single posts

                    the_posts_pagination( array(
                        'prev_text' => '<span class="screen-reader-text"><i class="fa fa-angle-left" aria-hidden="true"></i> ' . __( 'Previous post', indie_studio_text_domain() ) . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . __( 'Next post', indie_studio_text_domain() ) . '</span> <i class="fa fa-angle-right" aria-hidden="true"></i>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Post', indie_studio_text_domain() ) . ' </span>',
                    ) );

                } elseif ( ( is_home() || is_archive() || is_search() ) ) { // navigation links for home, archive, and search pages
            
                    ?>

                    <div id="load-more-wrap">
                        
                        <?php

                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

                        /**
                         * Decide is a custom template is required for AJAX
                         */ 

                        $template = '';

                        /**
                         * Use this to set a custom template if it does not
                         * use the standard module style.
                         * 
                         * The Template part should be added as a content part.
                         * 
                         * i.e. If template-part is content-search, you set
                         * the template var below as "search".
                         * 
                         * Go on, I dare you to be fancy!
                         * 

                        if(  ){
                            $template = '';
                        } 

                        **/

                        /**
                         * Set loading option
                         */

                        $load_type = 'paging';
                        if ( get_theme_mod('indie_studio_loading_type') ) {
                            $load_type = get_theme_mod('indie_studio_loading_type');
                        }

                        $paging_class = '';
                        if( $load_type == 'paging' ){
                            $paging_class = ' active';
                        }
            
                        if( !$button_text ){
                            $button_text = __( 'Load More', indie_studio_text_domain() );
                        }

                        ?>

                        <div class="pagination<?php echo $paging_class;?>">

                            <?php 
                            echo paginate_links( array(
                                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                                'total'        => $wp_query->max_num_pages,
                                'current'      => max( 1, get_query_var( 'paged' ) ),
                                'format'       => '?paged=%#%',
                                'show_all'     => false,
                                'type'         => 'plain',
                                'end_size'     => 2,
                                'mid_size'     => 1,
                                'prev_next'    => true,
                                'prev_text'    => '<i><i class="fa fa-chevron-left" aria-hidden="true"></i></i>',
                                'next_text'    => '<i><i class="fa fa-chevron-right" aria-hidden="true"></i></i>',
                                'add_args'     => false,
                                'add_fragment' => '',
                            ) );
                            ?>

                        </div>

                        <?php if ( $load_type != 'paging' ) { ?>

                            <div id="load-more-posts-error" class="load-more-posts-error error smooth"><p><?php echo esc_html__( 'Something has gone wrong. Please try again.', indie_studio_text_domain() );?></p></div>
                            <button id="load-more-posts" class="load-more-posts-button" data-paged="<?php echo esc_attr__( $paged, indie_studio_text_domain() );?>" data-query='<?php echo json_encode ( $wp_query->query ) ;?>' data-custom-template="<?php echo $template;?>" data-loadtype="<?php echo $load_type;?>" style="display: none;"><?php echo $button_text;?></button>

                        <?php } ?>

                    </div>

                <?php } ?>

            </nav>
		
		<?php
            
        }        
        
    } // indie_studio_content_nav
    
}
        
/**
 * Adds post-thumbnail support
 * 
 * @param string $before = '' HTML to prepend to the image
 * @param string $after = ''] HTML to append to the image
 *                                                  
 * @since IndieStudio 1.0.0
 */
function indie_studio_the_post_thumbnail( $before = '', $after = '' ) {
	if ( '' != get_the_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		$class = '';

		if ( $image['1'] < '300' ) {
			$class = 'alignright ';
		}

		echo $before;
		the_post_thumbnail( 'post-thumbnail', array( 'class' => $class . 'photo u-photo u-featured', 'itemprop' => 'image' ) );
		echo $after;
	}
}


/**
 * Adds article banner support
 * 
 * @param string $before = '' HTML to prepend to the image
 * @param string $after = ''] HTML to append to the image
 *                                                  
 * @since IndieStudio 1.0.0
 */
function indie_studio_the_article_banner( $before = '', $after = '' ) {
	if ( '' != get_the_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'article-banner' );

		echo $before;
		the_post_thumbnail( 'article-banner', array( 'class' => 'photo u-photo u-featured obj-fit cover rellax', 'itemprop' => 'image' ) );
		echo $after;
	}
}

/**
 * Adds module thumbnail support
 *                                                  
 * @since IndieStudio 1.0.0
 */
function indie_studio_the_module_image() {
	if ( '' != get_the_post_thumbnail() ) {
		echo '<div class="entry-media"><div class="media-fit">';
        echo '<div class="overlay smooth"></div>';
		the_post_thumbnail( 'module', array( 'class' => 'photo u-photo u-featured obj-fit cover smooth', 'itemprop' => 'image' ) );
		echo '</div></div>';
	};
}


/**
 * Adds module gallery thumbnail support
 *                                                  
 * @since IndieStudio 1.0.0
 */
function indie_studio_the_module_video_image() {

    $placeholder = '';

    $first_video = get_first_wordpress_video( get_the_ID() );
    
    //Get the video placeholder
    if ( $first_video ){
        
        $video_url = get_url_from_iframe( $first_video );
        
        if( is_wordpress_hosted_video( $video_url ) ){
            
            //No way of getting a thumbnail just yet. Stay tuned!
            
        } else {
        
            $video_still = get_video_placeholder( $video_url );
            if( $video_still ){
                $placeholder = '<img src="' . $video_still . '" class="photo u-photo u-featured obj-fit cover smooth wp-post-image" alt="" itemprop="image">';
            }
            
        }
    }
    
    //If the placeholder doesnt exist, get the featured image
	if ( !$placeholder ) {        
        $placeholder = get_the_post_thumbnail( get_the_ID(), 'module', array( 'class' => 'photo u-photo u-featured obj-fit cover smooth', 'itemprop' => 'image' ) );    
	};
    
    echo '<div class="entry-media"><div class="media-fit">';
    echo '<div class="play"><i class="fa fa-play-circle" aria-hidden="true"></i></div>';
    echo '<div class="overlay smooth"></div>';
    echo $placeholder;
    echo '</div></div>';
    
}

/**
 * Adds module gallery support
 *                               
 * @since IndieStudio 1.0.0
 */
function indie_studio_the_module_gallery_images() {
    
    echo '<div class="entry-media"><div class="media-fit">';
    echo '<div class="lory-carousel js_slider">';
    echo '<div class="frame js_frame">';
    echo '<ul class="slides js_slides">';
    
    $gallery = get_post_gallery( get_the_ID(), false );
    $gallery_ids = explode(",", $gallery['ids']);

    ?>

    <?php
    $gallery_count = 0;
    foreach ( $gallery_ids as $image_id ){
        $gallery_count++;

        $image = wp_get_attachment_image( $image_id, 'module', array( 'class' => 'photo u-photo', 'itemprop' => 'image' ) ); 

        if ( $image ){ ?>
            <li class="js_slide">
                <?php echo $image;?>
            </li>
        <?php 
        }

        if($gallery_count == 3){
            break;
        }
    }
    
    echo '</ul></div>';
    echo '<ul class="js_dots dots sneak-in"></ul>';
    echo '</div></div></div>';

}

/**
 * Builds the footer for modules
 */

function indie_studio_interaction_bar( $panel = null ){
    
    $back_panel = '';
    if( $panel ){
        $back_panel = ' back-panel';
    }
    
    echo '<div class="user-interaction sneak-in' . $back_panel . '">';
        
    echo '<div class="likes"><span aria-label="' . get_post_like_count() . ' likes for this post"><i class="fa fa-heart" aria-hidden="true"></i>' . get_post_like_count() . '</span></div>';
    
    echo '<div class="comments"><span aria-label="' . get_comments_count() . ' comments for this post"><i class="fa fa-comment" aria-hidden="true"></i>' . get_comments_count() . '</span></div>';
    
    echo '</div>';
    
}


/**
 * Build social sharing links
 */

function indie_studio_social_share( $post_id ){
    
    $title = get_the_title( $post_id );
    $current_url = get_the_permalink( $post_id );
    
    ?>

    <div class="article-share">

        <div class="thin-inner">

            <h2>Share</h2>
            
            <div class="services">

                <a class="social linkedin smooth external" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $current_url;?>&title=<?php echo $title;?>&source=<?php get_home_url(); ?>"><i class="fa fa-linkedin"></i></a>

                <a class="social google smooth external" href="https://plus.google.com/share?url=<?php echo $current_url;?>"><i class="fa fa-google-plus"></i></a>

                <a class="social facebook smooth external" href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $current_url;?>&title=<?php echo $title;?>"><i class="fa fa-facebook-f"></i></a>

                <a class="social twitter smooth external" href="http://twitter.com/intent/tweet?status=<?php echo $title;?>+<?php echo $current_url;?>"><i class="fa fa-twitter"></i></a>

                <a class="print smooth" href="javascript:window.print()"><i class="fa fa-print"></i></a> 

                <a class="social email smooth" href="mailto:?subject=Check out this article: <?php echo $title; ?>body=<?php echo $current_url;?>"><i class="fa fa-envelope"></i></a> 

            </div>
                
        </div>
            
    </div>

<?php
} 