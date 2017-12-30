<?php

/**
 * Add Social Section
 */

$wp_customize->add_section( 'indie_studio_social_settings', array(
    'title'    => __('Social Media', indie_studio_text_domain()),
) );
  
$social_sites = indie_studio_social_media_array();
  
/**
 * Here we loop through the social media array
 **/ 

foreach( $social_sites as $social_site ) {
  
    $wp_customize->add_setting( "$social_site", array(
        'default' => '',
    ) );
 
    //Capitalize Names
    $name = implode('-', array_map('ucfirst', explode('-', $social_site)));
    
    $wp_customize->add_control( $social_site, array(
        'label'   => __( "$name URL:", 'social_icon' ),
        'section' => 'indie_studio_social_settings',
        'type'    => 'text',
        'priority'=> 10,
    ) );
    
}


/**
 * Hold all the required social media site names.
 * Ensure these are all lower case.
 * @return array
 */

function indie_studio_social_media_array() {
    $social_sites = array('twitter', 'facebook', 'google-plus', 'flickr', 'pinterest', 'youtube', 'vimeo', 'tumblr', 'dribbble', 'linkedin', 'instagram');
    return $social_sites;
}


/**
 * Call this function to output all required social media sites.
 * 
 * Calls the indie_studio_social_media_array() and checks against
 * the sites that have values in the Customizer. If a site
 * has been used, it will be outputted with the correct Font
 * Awesome icon.
 * 
 * @return string final social media output
 */

function my_social_media_icons() {
  
    $social_sites = my_customizer_social_media_array();
  
    // any inputs that aren't empty are stored in $active_sites array
    foreach($social_sites as $social_site) {
        if( strlen( get_theme_mod( $social_site ) ) > 0 ) {
            $active_sites[] = $social_site;
        }
    }
  
    // for each active social site, add it as a list item
    if($active_sites) {
        echo "<ul class='social-media-icons'>";
        foreach ($active_sites as $active_site) {?>

            <li>
                <a class="external" href="<?php echo get_theme_mod( $active_site ); ?>" target="new">
                <?php if( $active_site == "vimeo") { ?>
                        <i class="fa fa-<?php echo $active_site; ?>-square"></i> <?php
                    } else { ?>
                        <i class="fa fa-<?php echo $active_site; ?>"></i><?php
                    } ?>
                </a>
            </li>

        <?php
        }
        echo "</ul>";
    }
}