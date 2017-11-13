( function( $ ) {
    
    var customize = wp.customize;
    
    /**
     * Set up functions to accept any "preview-edit" class as a link to a setting
     */
    
    $( document.body ).on( 'click', '.customizer-edit', function(e){
        e.preventDefault();
        customize.preview.send( 'preview-edit', $( this ).data( 'control' ) );
    });
    
    
    //Show Header Search
	customize( 'indie_studio_header_search', function( value ) {
		value.bind( function( newval ) {                
            if ( newval ){
                $( 'header #searchform' ).fadeIn();
            } else {
                $( 'header #searchform' ).fadeOut();
            }
		} );
	} );
    
    
    //Update theme background colour
	customize( 'indie_studio_background_colour', function( value ) {
		value.bind( function( newval ) {            
			$( 'body' ).css( 'background-color', newval );
		} );
	} );
    
    
    //Update Google Fonts
	customize( 'indie_studio_heading_font_selector', function( value ) {
        value.bind( function( newval ) {    
            $.ajax({
                type       : "POST",
                url        : ajax_customizer.ajax_url,
                dataType   : "json",
                data       : ({ 
                    action: 'google_fonts_customizer_preview', 
                    font: newval, 
                    location: 'heading',
                }),
                success: (function(response) {                       
                    addGoogleFont(response.url, response.location);
                    updateCssFontFamilies(response.family, response.location);
                }),
                fail: (function( jqXHR ) {
                    console.log(jqXHR);
                }),
            });
        } );
	} );
    
	customize( 'indie_studio_paragraph_font_selector', function( value ) {  
        value.bind( function( newval ) {            
            $.ajax({
                type       : "POST",
                url        : ajax_customizer.ajax_url,
                dataType   : "json",
                data       : ({ 
                    action: 'google_fonts_customizer_preview', 
                    font: newval, 
                    location: 'paragraph',
                }),
                success: (function(response) {                      
                    addGoogleFont(response.url, response.location);
                    updateCssFontFamilies(response.family, response.location);
                }),
                fail: (function( jqXHR ) {
                    console.log(jqXHR);
                })
            });            
        } );
	} );
    
    
    function addGoogleFont(url, location) {
        $('#dynamic-google-font-' + location).remove();

        $("head").append("<link id='dynamic-google-font-" + location + "' href='" + url + "' rel='stylesheet' type='text/css'>");
    }
    
    function updateCssFontFamilies(family, location) {
        $('#dynamic-google-font-style-' + location).remove();
        
        if( location == 'heading' ){
            $("head").append("<style id='dynamic-google-font-style-" + location + "'>h1,h2,h3,h4,h5 { font-family: '" + family + "', Verdana, Geneva, sans-serif; } </style>");
        }
        
        if( location == 'paragraph' ){
            $("head").append("<style id='dynamic-google-font-style-" + location + "'>p, li, a { font-family: '" + family + "', Verdana, Geneva, sans-serif; } </style>");
        }
    }
            
    
	//Update the headings in real time...
	customize( 'indie_studio_heading_text_colour', function( value ) {
		value.bind( function( newval ) {            
			$( 'h1, h2, h3, h4, h5' ).css( 'color', newval );
		} );
	} );
    
    
    //Update the paragraph in real time
	customize( 'indie_studio_paragraph_text_colour', function( value ) {
		value.bind( function( newval ) {            
			$( 'p, a, li, label' ).css( 'color', newval );
		} );
	} );
    
    
} )( jQuery );