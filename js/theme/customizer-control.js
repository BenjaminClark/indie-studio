(function( $ ) {
    
    //Helpful link
    //https://wpchat.com/t/i-came-across-this-not-so-flexible-customizer-js-api-code-in-almost-all-new-automattic-themes-that-allows-panel-based-content-is-there-a-known-bug/2250
    
    //Script to monitor events
    //http://riceball.com/observing-the-wordpress-customizer-wp-customize-events/
    
    wp.customize.bind( 'ready', function() {
        var customize = this;
        
        /**
         * Set up functions to accept any "preview-edit" class as a link to a setting
         */
        
        customize.previewer.bind( 'preview-edit', function( data ) {
            panelFocus( data );
        } );
        
        $( document.body ).on( 'click', '.customizer-edit', function(e){
            e.preventDefault();       
            panelFocus( $( this ).data( 'control' ) );
        });
        
        
        /**
         * Go to panel
         */
        
        function panelFocus( data ){
            
            var control = customize.control( data );
                        
            control.focus( {
                completeCallback : function() {
                    control.container.addClass( 'shake animated' );
                    setTimeout( function() {
                        control.container.removeClass( 'shake animated' );
                    }, 500 );
                }
            } );  
        
        }
        
        
        /**
         * On first load, check if API warning is required
         * Fires when the page firsts loads
         */
        
        toggle_google_api_visibility();
        
        
        /**
         * On pane load, check if API warning in required
         * Fired when everything has loaded
         */
        customize.previewer.bind( 'ready', function() {
            toggle_google_api_visibility();
        } );
        
                
        /**
         * On Font panel expansion, check if the font API warning is required
         * Fired when panel expands, to check for any changes
         */ 
        
        customize.section( 'indie_studio_fonts_colours_section' ).expanded.bind( function( isExpanding ) {
            if ( isExpanding ){
                toggle_google_api_visibility();
            }
        } );
        
        
        /**
         * Checks to see if there is a value in the Google API field.
         * If there is, hide API warning, if not show API warning
         */
        
        function toggle_google_api_visibility(){
            var google_font_warning = customize.control('indie_studio_font_api_missing');   
            if ( customize( 'indie_studio_google_api' ).get().length < 0 ){
                google_font_warning.activate();
            } else {
                google_font_warning.deactivate();
            }
        }
        
        
    } );
    
})( jQuery );