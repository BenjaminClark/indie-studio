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
            
            <p class="copyright" xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type"><a xmlns:cc="http://creativecommons.org/ns#" href="https://github.com/BenjaminClark/indie-studio" property="cc:attributionName" rel="cc:attributionURL">IndieStudio</a> by 
                
                <a class="external" xmlns:cc="http://creativecommons.org/ns#" href="https://github.com/BenjaminClark" property="cc:attributionName" rel="cc:attributionURL">Ben Clark</a> and <a class="external" href="http://www.justlikethis.co.uk">Robert Marshall</a> is licensed under <a class="external" rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">CC BY-SA 4.0</a>. Inspired by <a class="external" xmlns:dct="http://purl.org/dc/terms/" href="https://indieweb.org/" rel="dct:source">IndieWeb</a>.</p>
            
            <p class="custom"><?php echo get_theme_mod('indie_studio_footer'); ?></p>

        </div>

    </footer>      

    <a class="toTop smooth"><i class="fa fa-angle-up"></i></a>
        
    <?php wp_footer();?>
    
    <?php echo get_theme_mod('indie_studio_scripts_footer', ''); ?>
 
</body>
</html>
