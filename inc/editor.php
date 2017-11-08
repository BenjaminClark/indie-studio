<?php

/**
 * Add underline back into TinyMCE
 * 
 * Other buttons can be added using this function
 * 
 * @link https://madebydenis.com/adding-custom-buttons-in-tinymce-editor-in-wordpress/
 */
function indie_studio_register_buttons( $buttons ) {
    $insert_button = 'underline';
    array_splice( $buttons, 3, 0, $insert_button );
    return $buttons;
}
add_filter( 'mce_buttons', 'indie_studio_register_buttons' );


/**
 * Stop TinyMCE messing with custom html
 * 
 * @link https://www.leighton.com/blog/stop-tinymce-in-wordpress-3-x-messing-up-your-html-code/
 */
function override_mce_options($initArray) {
	$opts = '*[*]';
	$initArray['valid_elements'] = $opts;
	$initArray['extended_valid_elements'] = $opts;
	return $initArray;
}
add_filter('tiny_mce_before_init', 'override_mce_options');


function tinymce_remove_root_block_tag( $init ) {
    $init['wpautop'] = false; 
    $init['force_p_newlines'] = false; 
    //$init['forced_root_block'] = false; 
    return $init;
}
add_filter( 'tiny_mce_before_init', 'tinymce_remove_root_block_tag' );


/**
 * Add custom editor styling
 * 
 * This function adds editor styles from the theme root. 
 * The file defaults to: 'editor-style.css'
 * 
 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
 */
function my_theme_add_editor_styles() {
    add_editor_style('css/theme/editor-style.css');
}
add_action( 'admin_init', 'my_theme_add_editor_styles' );
