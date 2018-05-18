<?php

/**
 * Hold all the required social media site names.
 * Ensure these are all lower case.
 * @return array
 */

function indie_studio_social_media_array() {
    $social_sites = 
    array(
        'twitter', 
        'facebook', 
        'google-plus', 
        'flickr', 
        'pinterest', 
        'youtube', 
        'vimeo', 
        'tumblr', 
        'dribbble', 
        'linkedin', 
        'instagram',
        'behance',
        'github',
        'medium',
    );
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

function get_social_media_icons() {
  
    $social_sites = indie_studio_social_media_array();
    $active_sites = array();
    
    // any inputs that aren't empty are stored in $active_sites array
    foreach($social_sites as $social_site) {
        if( strlen( get_theme_mod( $social_site ) ) > 0 ) {
            $active_sites[] = $social_site;
        }
    }
  
    // for each active social site, add it as a list item
    if( $active_sites ) {
        echo "<ul class='social-media-icons'>";
        foreach ($active_sites as $active_site) {?>

            <li>
                <a class="external social smooth <?php echo $active_site; ?>" href="<?php echo get_theme_mod( $active_site ); ?>" onclick="creatGaEvent('Link', 'Social', <?php echo $active_site; ?>')">
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