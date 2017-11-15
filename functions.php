<?php

/* This page loads all files related to functions */

//Theme based config file - keeps big stuff in one place
include ( 'inc/config.php' );

//Auto Install plugins
require ( 'plugins/auto_install.php' );

//Sets up error logging
include ( 'inc/error_log.php' );                    

include ( 'inc/admin_notices.php' );

//Include all editor customisations 
include ( 'inc/editor.php' );                       

include ( 'inc/essentials.php' );
include ( 'inc/semantics.php' );

include ( 'inc/search.php' );

include ( 'inc/customizer/customizer_init.php' );

include ( 'inc/preset_cats.php' );

include ( 'inc/menu.php' );    

include ( 'inc/comments.php' );

//Cleanup Wordpress frontend scripts
include ( 'inc/cleanup.php' );  

//Set up custom login page
include ( 'inc/login.php' );                        

//Image Sizing
include ( 'inc/images.php' );

//Enqueue and register all scripts
include ( 'inc/enqueue_scripts.php' );              

//Sorts all customiser css
include ( 'inc/dynamic_css.php' );

//Custom Compiler and versioning
include ( 'inc/versioning/version.php' );
include ( 'inc/versioning/compile.php' );

//Ajax
include ( 'inc/load_more_posts.php' );

//Alter admin/dashboard based layout
include ( 'inc/admin.php' );                        