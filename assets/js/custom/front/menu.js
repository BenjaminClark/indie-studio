/** JS Code for the Header / Menu **/

var screenWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
    headerHeight;

jQuery(document).ready(function($) {
    
    /**
     * Header & Search Bar variables
     **/
    
    var body                    = $( 'body' ),
                
        //Header search bar
        headerSearchForm        = $( "#searchform" ),
        headerSearchInput       = $( "#header-search-input" ),
        headerSearchButton      = $( "#searchform .search-submit" ), 
        headerSearchClose       = $( "#searchform .search-close" ), 
        
        mainSearchForm          = $( "#main-searchform" ),
        mainSearchInput         = $( "#main-search-input" ), 
        
        mainNavigation          = $( "#site-navigation" ), 
        burger                  = $( "#burger .trig" ),
        
        overlay                 = $( "#overlay" );
    
    
    
    /** 
     * Menu search bar
     **/ 
    
    if(headerSearchInput.length > 0){   
    
        //Link search boxes if on search page
        if(mainSearchInput.length > 0){ 
            syncTextInputElements ( 'main-search-input', 'header-search-input' );
        }
        
        headerSearchForm.submit(function( e ) {
            var form = this;
            e.preventDefault();
            if( headerSearchForm.hasClass('active') ){
                //Check if search bar has text
                if ( headerSearchInput.val().length > 0 ){
                   form.submit();
                } else {
                    closeHeaderSearch();
                }
            } else {
                openHeaderSearch();
            }
            
        });
        
        mainSearchForm.submit(function( e ) {
            var form = this;
            e.preventDefault();
            if ( headerSearchInput.val().length > 0 ){
               form.submit();
            }
        });
        
        headerSearchClose.on("click tap" , function(e){
            e.preventDefault();
            closeHeaderSearch();
        });
                
        //Reset menu & search on click outside of menu
        $(document).on("click tap" , function(e){
            // if the target of the click isn't the container nor a descendant of the container
            if ( headerSearchForm.has(e.target).length === 0 ){
                closeHeaderSearch();
            }
        });
        
        function openHeaderSearch(){
            addOverlay();
            headerSearchForm.addClass('active');
            headerSearchInput.focus();
            mainNavigation.addClass('search');
        }
        
        function closeHeaderSearch(){
            removeOverlay();
            headerSearchForm.removeClass('active');
            mainNavigation.removeClass('search');
        }
        
    }
    
    
    /** 
     * Menu 
     **/ 
    burger.on("click tap" , function(e){
        toggle_menu();
    });
    
    //Reset menu on click outside of menu
    $(document).mouseup(function(e) {
        // if the target of the click isn't the container. burger icon nor a descendant of the container
        if (!mainNavigation.is(e.target) && mainNavigation.has(e.target).length === 0 && !burger.is(e.target) ){
            deactivate_menu();
        }
    });
    
    function toggle_menu(){
        body.toggleClass('navigation-open');
        $(window).scrollTop(0); //Fixes any page gaps
    }
    
    function deactivate_menu(){
        body.removeClass('navigation-open');
    }
    
    function addOverlay(){
        if( !body.hasClass('search-active') ){
            body.addClass('search-active');
            overlay.fadeIn();
        }
    }
    
    function removeOverlay(){
        body.removeClass('search-active');
        overlay.fadeOut();
    }
                    
});
