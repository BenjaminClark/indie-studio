<div class="related-posts">

    <div class="page-inner-wrap group">
   
        <h2><?php _e( 'Related Articles', indie_studio_text_domain() ); ?></h2>

        <div class="grid-container basic">

            <?php

            $args = array(
                'post_type'     => get_post_type($post->ID),
                'orderby'       => 'ASC',
                'post__in'      => get_related_posts(),
            );

            $related_loop = new WP_Query( $args );

            while ($related_loop->have_posts()) : $related_loop->the_post(); 

                get_template_part( 'template-parts/post/module', 'child' );

            endwhile;

            wp_reset_postdata();

            ?>
            
        </div>

    </div>

</div>