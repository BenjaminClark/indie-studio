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
		printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark" class="url u-url"><time class="entry-date updated published dt-updated dt-published" datetime="%3$s" itemprop="dateModified datePublished">%4$s</time></a><address class="byline"> <span class="sep"> by </span> <span class="author p-author vcard hcard h-card" itemprop="author " itemscope itemtype="http://schema.org/Person">%5$s <a class="url uid u-url u-uid fn p-name" href="%6$s" title="%7$s" rel="author" itemprop="url"><span itemprop="name">%8$s</span></a></span></address>', indie_studio_text_domain() ),
			esc_url( get_permalink() ),
			esc_attr( get_the_time() ),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			get_avatar( get_the_author_meta( 'ID' ), 40 ),
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', indie_studio_text_domain() ), get_the_author() ) ),
			esc_html( get_the_author() )
		);
	}
}


if ( ! function_exists( 'indie_studio_content_nav' ) ) {
    
	/**
	 * Display navigation to next/previous pages when applicable
	 *
	 * @since IndieStudio 1.0.0
	 */
    
	function indie_studio_content_nav( $nav_id, $load_more = null ) {
		global $wp_query;

        if ( $wp_query->max_num_pages > 1 ){
        
		?>
            <nav id="<?php echo esc_attr( $nav_id ); ?>">
                <h1 class="assistive-text section-heading"><?php _e( 'Post navigation', indie_studio_text_domain() ); ?></h1>

                <?php if ( is_single() ) { // navigation links for single posts

                    the_posts_pagination( array(
                        'prev_text' => '<span class="screen-reader-text"><i class="fa fa-angle-left" aria-hidden="true"></i> ' . __( 'Previous post', indie_studio_text_domain() ) . '</span>',
                        'next_text' => '<span class="screen-reader-text">' . __( 'Next post', indie_studio_text_domain() ) . '</span> <i class="fa fa-angle-right" aria-hidden="true"></i>',
                        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Post', indie_studio_text_domain() ) . ' </span>',
                    ) );

                } elseif ( ( is_home() || is_archive() || is_search() ) ) { // navigation links for home, archive, and search pages

                    if ( get_previous_posts_link() ) { ?>

                        <div class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav"><i class="fa fa-angle-left" aria-hidden="true"></i></span> Older posts', indie_studio_text_domain() ) ); ?></div>

                    <?php } ?>

                    <?php if ( get_next_posts_link() ) { ?>

                        <div class="nav-next"><?php next_posts_link( __( 'Newer posts <span class="meta-nav"><i class="fa fa-angle-right" aria-hidden="true"></i></span>', indie_studio_text_domain() ) ); ?></div>

                    <?php } ?>

                <?php } ?>

            </nav>
		
		<?php
            
        }
            
	    /** 
         * If the load more button is required
         * 
         * Only include the button holder, the button will be added with
         * JS and the above navigation removed. This allows elegant fallback
         * if a user does not have javascript enabled
         **/
        
        if ( $load_more && $wp_query->max_num_pages > 1 && get_next_posts_link() ) { ?>
            
            <div id="load-more-wrap">
               
                <?php indie_studio_load_more_button( $button_text = 'Load More' );?>
                
            </div>
            
        <?php }
        
    } // indie_studio_content_nav
    
}
        
/**
 * Adds post-thumbnail support
 *
 * @since IndieStudio 1.0.0
 */
function indie_studio_the_post_thumbnail( $before = '', $after = '' ) {
	if ( '' != get_the_post_thumbnail() ) {
		$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'post-thumbnail' );
		$class = '';

		if ( $image['1'] < '300' ) {
			$class = 'alignright';
		}

		echo $before;
		the_post_thumbnail( 'post-thumbnail', array( 'class' => $class . ' photo u-photo u-featured', 'itemprop' => 'image' ) );
		echo $after;
	}
}