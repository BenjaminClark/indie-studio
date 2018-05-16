<?php

/**
 * Indie Studio Recent_Posts widget class
 *
 * @since 0.0.53
 * 
 * @link https://developer.wordpress.org/reference/classes/wp_widget_recent_posts/
 */

class Indie_Studio_Widget_Recent_Posts extends WP_Widget {
 
    /**
     * Sets up a new Recent Posts widget instance.
     *
     * @since 0.0.53
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'widget_recent_entries related-posts',
            'description' => __( 'Your site&#8217;s most recent Posts as modules' ),
            'customize_selective_refresh' => true,
        );
        parent::__construct( 'indie-studio-recent-posts', __( 'Indie Studio Recent Posts' ), $widget_ops );
        $this->alt_option_name = 'indie_studio_widget_recent_entries';
    }
 
    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 0.0.53
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    public function widget( $args, $instance ) {
        if ( ! isset( $args['widget_id'] ) ) {
            $args['widget_id'] = $this->id;
        }
        
        global $post;
 
        $title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Recent Posts' );
 
        /** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
        $title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
 
        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 4;
        if ( ! $number ) {
            $number = 4;
        }
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;
 
        /**
         * Filters the arguments for the Recent Posts widget.
         *
         * @since 0.0.53
         *
         * @see WP_Query::get_posts()
         *
         * @param array $args     An array of arguments used to retrieve the recent posts.
         * @param array $instance Array of settings for the current widget.
         */
        $recent_posts = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
        ), $instance ) );
 
        if ( ! $recent_posts->have_posts() ) {
            return;
        }
        ?>
        
        <?php echo $args['before_widget']; ?>
        <?php
        if ( $title ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        ?>

        <div class="grid-container basic">

            <?php      
            foreach ( $recent_posts->posts as $post ) :
        
                /**
                 * Set post as as main query for the moment
                 * 
                 * @link https://codex.wordpress.org/Function_Reference/setup_postdata
                 **/
                setup_postdata( $post );

                get_template_part( 'template-parts/post/widget-module-recent', get_post_format() );

            endforeach;
        
            /**
             * Bring the original query back
             **/ 
            wp_reset_postdata();

            echo $args['after_widget'];

            ?>

        </div>

    <?php        
    }

 
    /**
     * Handles updating the settings for the current Recent Posts widget instance.
     *
     * @since 0.0.53
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Updated settings to save.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = sanitize_text_field( $new_instance['title'] );
        $instance['number'] = (int) $new_instance['number'];
        $instance['show_date'] = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
        return $instance;
    }
 
    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 0.0.53
     *
     * @param array $instance Current settings.
     */
    public function form( $instance ) {
        $title     = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $number    = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>
 
        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
        <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>
 
        <p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>
<?php
    }
}

add_action( 'widgets_init', function(){
	register_widget( 'Indie_Studio_Widget_Recent_Posts' );
});