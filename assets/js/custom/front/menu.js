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
        
        mainSearchInput         = $( "#main-search-input" ), 
        
        mainNavigation          = $( "#site-navigation" ), 
        burger                  = $( "#burger .trig" );
    
    
    
    /** 
     * Menu search bar
     **/ 
    
    if(headerSearchInput.length > 0){   
    
        //Link search boxes if on search page
        if(mainSearchInput.length > 0){ 
            syncTextInputElements ( 'main-search-input', 'header-search-input' );
        }
        
        headerSearchButton.on("click tap" , function(e){
            e.preventDefault();
            if( headerSearchForm.hasClass('active') ){
                //Check if search bar has text
                var headerSearchText = $(headerSearchInput).val();
                if ( headerSearchText.length > 0 ){
                    $( headerSearchForm ).submit();
                } else {
                    closeHeaderSearch();
                }
            } else {
                openHeaderSearch();
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
            headerSearchForm.addClass('active');
            headerSearchInput.focus();
            mainNavigation.addClass('search');
        }
        
        function closeHeaderSearch(){
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
    }
    
    function deactivate_menu(){
        body.removeClass('navigation-open');
    }
                    
});
