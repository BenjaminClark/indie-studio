<?php

/**
 * Get file version number
 * 
 * Finds the file, and checks its last modified date.
 * If the file exists, pass to another function to get
 * the version number
 * 
 * @param string $name file name to store in transient
 * @param string $file file directory
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_get_file_version_number( $name, $file ){
    
    $timestamp = get_file_last_mod_stamp( $file );
    
    if( $name && $timestamp ){
        
        $version_num = indie_studio_set_file_version_number( $name, $timestamp );
        
        return $version_num;
        
    }
    
    return false;
    
}

/**
 * Set file version number
 * 
 * This function takes the name of the file and the timestamp
 * It will return the correct version number, depending on what has been
 * previously saved.
 * 
 * The name should be unique, that can be used to store the timestamp and version ID
 * The timestamp should be the last time the file was modified.
 * 
 * @param string $name file name to store in transient
 * @param string $file file directory
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_set_file_version_number( $name, $timestamp ){
    
    $version_option_name = 'indie_studio' . $name . '_version_number';
    
    $current_array = get_option( $version_option_name );
        
    //Set as blank
    $current_version = '';
    
    if( isset ( $current_array['timestamp'] ) && isset ( $current_array['version'] ) ) {
                
        // If the current modified stamp, is NOT newer than saved stamp
        // Minus 3 mins for server delay in saving file
        if ( ( $timestamp - 180 ) <= $current_array['timestamp'] ){
            
            // Return the current version number
            return $current_array['version'];  
            
        }
                
        $current_version = $current_array['version'];
        
    }
            
    //If a version has never been made, or the version needs updating, we
    //can do that here.
    
    //indie_studio_inc_version_number can take an empty string, or a 3 point number
    $new_version = indie_studio_inc_version_number( $current_version );

    $save_option = array(
        'timestamp' => $timestamp,
        'version'   => $new_version,
    );

    // Update option
    update_option( $version_option_name, $save_option );
    
    //Remeber to save version is master version option
    indie_studio_set_master_css_timestamp( $timestamp );

    //Return the new version number
    return $new_version;
    
}


/**
 * Increment version number
 * 
 * This function takes a 3 point version number, or an empty string and
 * increments it by one.
 * 
 * @param string $version current version number or empty string
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_inc_version_number( $version = null ){
    
    if( $version ){
        
        $parts = explode('.', $version);

        if ($parts[2] + 1 < 99) {
            $parts[2]++;
        } else {
            $parts[2] = 0;
            if ($parts[1] + 1 < 99) {
                $parts[1]++;
            } else {
                $parts[1] = 0;
                $parts[0]++;        
            }
        }
        
        return implode('.', $parts);
        
    } 
    
    return '1.0.0';
    
}


/**
 * Check timestamp
 * 
 * This function takes two timestamps, and returns the most up to date
 * 
 * @param int $timestamp New timestamp
 * @param int $old_stamp Old timestamp
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_check_modif_date($timestamp, $old_stamp){
    if( $timestamp > $old_stamp ){
        return $timestamp;
    }
    return $old_stamp;
}


/**
 * Get timestamp
 * 
 * Gets the timestamp for the file
 * 
 * @param string $file Directory of file
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function get_file_last_mod_stamp( $file ){
    
    if ( file_exists( $file ) ) {
            
        //Last Modified
        $timestamp = filemtime( $file );
        
        return $timestamp;
        
    }
    
    return false;  
 
}


/**
 * Set master CSS timestamp
 * 
 * This function sets and holds the most up to date modifed time of a file.
 * It is used as master timestamp for the main version control for the final minifed file to check
 * back against.
 * 
 * i.e. If the last file changed is the font.css, the timestamp is saved here. If the style.min.css last modifed
 * timestamp is smaller than this timestamp, it means the minified file needs making.
 * 
 * @param int $timestamp File timestamp
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 * 
 * @todo merge css/js files
 */
function indie_studio_set_master_css_timestamp( $timestamp ) {
    if ( $timestamp ){
        $version_option_name = 'master_file_timestamp_css';
        update_option( $version_option_name, $timestamp );
    }
    return false;
}


/**
 * Set master JS timestamp
 * 
 * This function sets and holds the most up to date modifed time of a file.
 * It is used as master timestamp for the main version control for the final minifed file to check
 * back against.
 * 
 * i.e. If the last file changed is the font.css, the timestamp is saved here. If the theme-main.min.js last modifed
 * timestamp is smaller than this timestamp, it means the minified file needs making.
 * 
 * @param int $timestamp File timestamp
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_set_master_js_timestamp( $timestamp ) {
    if ( $timestamp ){
        $version_option_name = 'master_file_timestamp_js';
        update_option( $version_option_name, $timestamp );
    }
    return false;
}


/**
 * Get overall master timestamp
 * 
 * @param string $type css or js
 * 
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_get_master_timestamp( $type ) {
    
    $version_option_name = 'master_file_timestamp_' . $type;

    if( $type == 'css' ){
        return get_option( $version_option_name );
    }

    if( $type == 'js' ){
        return get_option( $version_option_name );
    }   
    return false;
}


/**
 * Check if timestamp is new
 * 
 * This function checks to see if the new stamp is actually newer than the old stamp.
 * If stamp is unset, set to 0
 * 
 * Make sure we give a variance of 1 minute to make up for any potential file creation issues
 * and server timing
 * 
 * @param int $new_stamp New timestamp
 * @param int $old_stamp Old timestamp
 * 
 * @return bool
 *
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_is_stamp_newer( $new_stamp = 0, $old_stamp = 0 ){
    
    //if( ( $new_stamp - 60 ) >= $old_stamp ){
    
    if( $new_stamp >= $old_stamp ){
        return true;
    }
    return false;
    
}


/**
 * CSS compiler tracker
 * 
 * Holds an array of all files compiled, to track if a new file has been added.
 * They are held in an option.
 * 
 * @param string $name Name of file
 *
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 * 
 * @todo merge CSS/JS trackers
 */
function indie_studio_add_css_name_to_compiler_tracker( $name ){
    
    $name_array = indie_studio_get_css_names_from_compiler_tracker();
    
    //If array doesnt exist, set it up.
    if ( !isset( $name_array ) || !$name_array ){
        $name_array = array();
    }
      
    //If the name isnt in the array, add it
    if ( !in_array( $name, $name_array ) ){
        $name_array[] = $name;
        update_option( 'indie_studio_css_compiler_tracker', $name_array );
        
        //Let the minified function know we have added a new file
        indie_studio_new_css_file_added_to_compiler();
    }
    
}


/**
 * JS compiler tracker
 * 
 * Holds an array of all files compiled, to track if a new file has been added.
 * They are held in an option.
 * 
 * @param string $name Name of file
 *
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function indie_studio_add_js_name_to_compiler_tracker( $name ){
    
    $name_array = indie_studio_get_js_names_from_compiler_tracker();
    
    //If array doesnt exist, set it up.
    if ( !isset( $name_array ) || !$name_array ){
        $name_array = array();
    }
      
    //If the name isnt in the array, add it
    if ( !in_array( $name, $name_array ) ){
        $name_array[] = $name;
        update_option( 'indie_studio_js_compiler_tracker', $name_array );
        
        //Let the minified function know we have added a new file
        indie_studio_new_js_file_added_to_compiler();
    }
    
}

function indie_studio_get_css_names_from_compiler_tracker(){
    return get_option( 'indie_studio_css_compiler_tracker' );
}

function indie_studio_get_js_names_from_compiler_tracker(){
    return get_option( 'indie_studio_js_compiler_tracker' );
}





function indie_studio_new_css_file_added_to_compiler(){
    update_option( 'indie_studio_new_css_file_added_to_compiler', true );
}

function indie_studio_new_js_file_added_to_compiler(){
    update_option( 'indie_studio_new_js_file_added_to_compiler', true );
}

function indie_studio_has_new_css_file_been_added_to_compiler(){
    return get_option( 'indie_studio_new_css_file_added_to_compiler' );
}

function indie_studio_has_new_js_file_been_added_to_compiler(){
    return get_option( 'indie_studio_new_js_file_added_to_compiler' );
}

function indie_studio_reset_css_file_compiler_tracker(){
    update_option( 'indie_studio_new_css_file_added_to_compiler', false );
}

function indie_studio_reset_js_file_compiler_tracker(){
    update_option( 'indie_studio_new_js_file_added_to_compiler', false );
}


/**
 * CSS compiler tracker
 * 
 * Takes an array of CSS files, loops through
 * and adds new file names to the compiler checker.
 * 
 * @param array $file_array Array of CSS files
 *
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function check_css_files_for_compiler( $file_array ){
    if ( !empty( $file_array ) ){
        //Loop through all css files
        foreach ($file_array as $file) {
            if( isset( $file[0] ) ){
                //If we havnt before, add file name to compiler tracker
                indie_studio_add_css_name_to_compiler_tracker( $file[0] );
            }
        } 
    }
}


/**
 * JS compiler tracker
 * 
 * Takes an array of JS files, loops through
 * and adds new file names to the compiler checker.
 * 
 * @param array $file_array Array of JS files
 *
 * @package IndieStudio
 * @subpackage compiler
 * @since IndieStudio 1.0.0
 */
function check_js_files_for_compiler( $file_array ){
    if ( !empty( $file_array ) ){
        //Loop through all css files
        foreach ($file_array as $file) {
            if( isset( $file[0] ) ){
                //If we havnt before, add file name to compiler tracker
                indie_studio_add_js_name_to_compiler_tracker( $file[0] );
            }
        } 
    }
}