( function( $ ) {
    
    var customize = wp.customize;
    
    /**
     * Set up functions to accept any "preview-edit" class as a link to a setting
     */
    
    $( document.body ).on( 'click', '.customizer-edit', function(e){
        e.preventDefault();
        customize.preview.send( 'preview-edit', $( this ).data( 'control' ) );
    });
    
    
    //Update theme background colour
	customize( 'indie_studio_background_colour', function( value ) {
		value.bind( function( newval ) {            
			$( 'body' ).css( 'background-color', newval );
		} );
	} );
    
    
	//Update the headings in real time...
	customize( 'indie_studio_heading_text_colour', function( value ) {
		value.bind( function( newval ) {            
			$( 'h1, h2, h3, h4, h5' ).css( 'color', newval );
		} );
	} );
    
    
    //Update the paragraph in real time
	customize( 'indie_studio_paragraph_text_colour', function( value ) {
		value.bind( function( newval ) {            
			$( 'p, a, li' ).css( 'color', newval );
		} );
	} );
        
} )( jQuery );