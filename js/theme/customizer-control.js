(function( $ ) {
    
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
         * On Font panel expansion, check if the font API warning is required
         */ 
        
        wp.customize.section( 'indie_studio_fonts_colours_section' ).expanded.bind( function( isExpanding ) {
            if ( isExpanding ){
                if ( customize( 'indie_studio_google_api' ).get().length > 0 ){
                    toggle_google_api_visibility( false );
                } else {
                    toggle_google_api_visibility( true );
                }
            }
        } );
                
        function toggle_google_api_visibility( show ){
            var google_font_warning = customize.control('indie_studio_font_api_missing');       
            if ( show ){
                google_font_warning.activate();
            } else {
                google_font_warning.deactivate();
            }
        }
        
        if ( customize( 'indie_studio_google_api' ).get().length > 0 ){
            toggle_google_api_visibility( false );
        } else {
            toggle_google_api_visibility( true );
        }
        

        
    } );
    
})( jQuery );