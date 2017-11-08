<?php

/**
 * This file creates an easy to use admin notification "framework"
 */

class set_new_admin_notification {
    
    private $_message;

    function __construct( $type, $message ) {
        $this->_type = $type;
        $this->_message = $message;

        add_action( 'admin_notices', array( $this, 'render' ) );
    }

    function render() {
        printf( '<div class="' . $this->_type . '">%s</div>', $this->_message );
    }
    
}