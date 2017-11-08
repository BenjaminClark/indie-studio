<?php

if (!function_exists('write_log')) {
    
    /**
     * Write errors to debug.txt
     * 
     * @param string|array|object $log The item to debug 
     * @param string $key Use a key to highlight item in debug.txt
     */
    function write_log ( $log, $key = null )  {
        if ( true === WP_DEBUG ) {
            
            //Setup the key
            if( !$key ){
                $key = '';
            } else {
                $key = '#' . $key . ': ';
            }
            
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( $key . print_r( $log, true ) );
            } else {
                error_log( $key . $log );
            }
        }
    }
    
    
}


/**
 * Turn object to array
 * 
 * @param object $obj Object to be changed
 * @return array Converted array
 */

function object_to_array($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = object_to_array($val);
        }
    }
    else $new = $obj;
    return $new;       
}


/**
 * Print Error
 * @param string $error A clean way of outputting an array on a page
 */
function print_error($error){
    echo '<pre>'; print_r($error); echo '</pre>';
}