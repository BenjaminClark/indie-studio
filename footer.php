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

            <p class="copyright"><a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/"><img alt="Creative Commons Licence" style="border-width:0" src="https://i.creativecommons.org/l/by-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type">IndieStudio</span> by <a xmlns:cc="http://creativecommons.org/ns#" href="https://github.com/BenjaminClark/indie-studio" property="cc:attributionName" rel="cc:attributionURL">Robert Marshall and Ben Clark</a> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-sa/4.0/">Creative Commons Attribution-ShareAlike 4.0 International License</a>.<br />Based on a work at <a xmlns:dct="http://purl.org/dc/terms/" href="https://indieweb.org/" rel="dct:source">https://indieweb.org/</a>.</p>
            
            <p class="designer"><a href="http://www.justlikethis.co.uk">Created by JLT</a></p>

        </div>

    </footer>      

    <a class="toTop smooth"><i class="fa fa-angle-up"></i></a>
        
    <?php wp_footer();?>
    
    <?php echo get_theme_mod('indie_studio_scripts_footer', ''); ?>
 
</body>
</html>
