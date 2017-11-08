<?php

/**
 * Customized search form
 * 
 * Output a HTML5 schema/microformat search form 
 * to be used though the get_search_form function
 * 
 * @link https://codex.wordpress.org/Function_Reference/_x
 * @link https://developer.wordpress.org/reference/functions/get_search_form/
 * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search
 * 
 * @since IndieStudio 1.0.0
 */

function customized_search_form( $form ) {
    
    $form = '<form role="search" id="searchform" class="header-search" method="get" action="' . esc_url( home_url( '/' ) ) . '" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">';

        $form .= '<label>';
    
        $form .= '<span class="screen-reader-text">' . _x( 'Search for:', 'label' ) . '</span>';
       
            $form .= '<div class="reveal smooth">';

                $form .= '<input id="header-search-input" type="text" id="s" name="s" value="' . esc_attr( the_search_query() ) . '" placeholder="' .  esc_attr_x( 'Search …', 'placeholder' ) . '" title="' . esc_attr_x( 'Search for:', 'label' ) . '" itemprop="query-input" autocomplete="off">';

            $form .= '</div>';

        $form .= '</label>';
    
        $form .= '<button class="search-submit hover smooth"><i class="fa fa-search" aria-hidden="true"></i></button>';
        
        $form .= '<meta itemprop="target" content="' . site_url( '/?s={search} ' ) . '"/>';
    
    $form .= '</form>';    

	return $form;
    
}
add_filter( 'get_search_form', 'customized_search_form' );