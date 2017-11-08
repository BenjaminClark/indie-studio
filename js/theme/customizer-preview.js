( function( $ ) {
    
    var customize = wp.customize;
    
    
    /**
     * Set up functions to accept any "preview-edit" class as a link to a setting
     */
    
    $( document.body ).on( 'click', '.customizer-edit', function(e){
        e.preventDefault();
        customize.preview.send( 'preview-edit', $( this ).data( 'control' ) );
    });
        
} )( jQuery );