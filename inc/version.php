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