<?php

/**
 * Add rewrite rule and flush on plugin activation
 */ 
register_activation_hook( __FILE__, 'htaccess_activate' );
function htaccess_activate() {
    htaccess_rewrite();
    flush_rewrite_rules();
}
 

/**
 * Flush on plugin deactivation
 */ 
register_deactivation_hook( __FILE__, 'htaccess_deactivate' );
function htaccess_deactivate() {
    flush_rewrite_rules();
}
 

/**
 * Create new rewrite rule
 */ 
add_action( 'init', 'htaccess_rewrite' );
function htaccess_rewrite() {
    add_rewrite_rule( 'login/?$', 'wp-login.php', 'top' );
}


/**
 * Remove login wordpress link
 */ 
add_filter('login_headerurl', 'remove_wordpress_login_link');
function remove_wordpress_login_link(){
     return ""; // your URL here
}


/**
 * If the user is a subscriber, stop them from getting to the dash / hide admin bar
 **/ 
function disable_dashboard() {
    if (!is_user_logged_in()) {
        return null;
    }
    
    $user = wp_get_current_user();
    if ( in_array( 'subscriber', (array) $user->roles ) ) {
        wp_redirect(home_url());
        exit;
    }

}
add_action('admin_init', 'disable_dashboard');


/**
 * Remove the admin bar for subscribers
 */ 
function disable_admin_bar() {
    $user = wp_get_current_user();
    if ( in_array( 'subscriber', (array) $user->roles ) ) {
        show_admin_bar(false);
    }
}
add_action('admin_init', 'disable_admin_bar');


/**
 * Check to see if the user is logged in
 * 
 * If so, add the role name to the body class 
 * 
 * @since IndieStudio 1.0.0
 */

function add_user_type_to_body_class( $classes ){
    
    $current_user = wp_get_current_user();
    
    if( $current_user->ID != 0 ){
        
        /**
         * No need to add "logged-in". Wordpress already
         * adds this in the get_body_class filter
         **/
        
        $user = new WP_User( get_current_user_id() ); 
                
        //Add user roles to the class list
        foreach ( $user->roles as $role ){
            $classes[] = $role;
        }
        
    }
    
    return $classes;
    
}
add_filter( 'body_class', 'add_user_type_to_body_class' );


/**
 * Add custom css to the login page
 * 
 * Nothing super fancy, but it makes it less WordPress
 * and more Indie Studio
 */ 
function indie_studio_login_fix() { ?>
    <style type="text/css">
        html, body {
            background: #fff!important;
        }
        
        #loginform {
            background-color: #fff; 
        }
        
        .login #login h1 {
            padding: 0;
        }
        
        .login #nav a,
        .login #backtoblog a {
            color: #fff;
        }
        
        .login #backtoblog a:hover, .login #nav a:hover, .login h1 a:hover {
            color: #b1b1b1!important;
        }
        
        #wp-auth-check-wrap #wp-auth-check {
            background-color: #fff;
        }

    </style>
<?php }
add_action( 'login_enqueue_scripts', 'indie_studio_login_fix' );