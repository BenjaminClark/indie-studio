<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #page-wrapper div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package IndieStudio
 * @since IndieStudio 1.0.0
 */

?>   
        </div> <!-- Page Wrapper Close -->        
        
    </div> <!-- Footer Pusher Close -->    
    
    <footer id="colophon" role="contentinfo">

        <div id="site-publisher" class="page-inner-wrap" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">

            <meta itemprop="name" content="<?php echo get_bloginfo( 'name', 'display' ); ?>" />
            <meta itemprop="url" content="<?php echo home_url( '/' ); ?>" />

            <p class="copyright">Website &copy; <?php echo indie_studio_name() . ' ' . date('Y'); ?></p>
            
            <p class="designer"><a href="http://www.justlikethis.co.uk">Created by JLT</a></p>

        </div>

    </footer>      

    <a class="toTop smooth"><i class="fa fa-angle-up"></i></a>
        
    <?php wp_footer();?>
    
    <?php echo get_theme_mod('indie_studio_scripts_footer', ''); ?>
 
</body>
</html>