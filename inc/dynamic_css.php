<?php

/**
 * This page creates the dynamic css
 **/

function indie_studio_create_dynamic_css(){ ?>
<?php
    
    /**
     * Get fonts details from Customizer
     */ 
    
    $fonts          = get_google_font_details();
    $heading_font   = $fonts['heading']['name'];
    $paragraph_font = $fonts['paragraph']['name'];  
    
    ?>
html { 
    font-family: '<?php echo $paragraph_font;?>', Verdana, Geneva, sans-serif;
}

h1,
h2,
h3,
h4,
h5 {
    font-family: '<?php echo $heading_font;?>', Verdana, Geneva, sans-serif;
    color: <?php get_theme_mod('indie_studio_heading_text_colour', '#484848'); ?>;
} 

p, li, a {
    color: <?php echo get_theme_mod('indie_studio_paragraph_text_colour', '#484848');?>;
}

body {
    background-color: <?php echo get_theme_mod('indie_studio_background_colour', '#ffffff');?>;
}

<?php    
}



/**
 * This function takes PHP generated CSS and 
 * allows it to be used within the main CSS file
 */

function indie_studio_dynamic_css(){
    header('Content-Type: text/css');
    indie_studio_create_dynamic_css();
    exit;
}
add_action('wp_ajax_indie_studio_dynamic_css', 'indie_studio_dynamic_css');
add_action('wp_ajax_nopriv_indie_studio_dynamic_css', 'indie_studio_dynamic_css');