<?php

/**
 * The functions in this file alter admin / dashboard based code
 */


/**
 * Remove the WordPress logo from backend
 * 
 * Not essential, but it cleans up the dashboard a little.
 */
function remove_wp_logo( $wp_admin_bar ) {
    $wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu', 'remove_wp_logo', 999);


/**
 * Change custom greeting
 * 
 * Change the custom greeting at the top right side
 * of the admin bar. Simply because I wanted to.
 */
function custom_replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy', 'Welcome', $my_account->title );
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'custom_replace_howdy', 12 );


/**
 * Customise admin footer text
 * 
 * A sneeky place to put the theme version, and 
 * allow the user to see my website. 
 */
function remove_footer_admin () {
	echo indie_studio_name() . ' - V' . indie_studio_version() . ' - Designed by <a href="http://www.justlikethis.co.uk">JustLikeThis</a>';
}
add_filter('admin_footer_text', 'remove_footer_admin');