/** JS Code for the Header / Menu **/

var screenWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
    headerHeight;

jQuery(document).ready(function($) {
    
    /**
     * Header & Search Bar variables
     **/
    
    var body                    = $( 'body' ),
                
        //Header search bar
        headerSearchWrap        = $( "#header-search" ),
        headerSearchForm        = $( "#header-search form" ),
        headerSearchInput       = $( "#header-search-input" ),
        headerSearchButton      = $( "#search-button" ), 
        
        mainSearchInput         = $( "#main-search-input" ), 
        
        mainNavigation          = $( "#main-navigation" ), 
        burger                  = $( "#burger" ),
        burgerSpan              = $( "#burger span" ),
        
        subMenuCont             = $( ".sub-menu-container" ),
        
        menuOpen                = false; 
    
    
    
    /** 
     * Menu search bar
     **/ 
    
    if(headerSearchInput.length > 0){   
    
        //Link search boxes if on search page
        if(mainSearchInput.length > 0){ 
            syncTextInputElements ( 'main-search-input', 'header-search-input' );
        }
        
        headerSearchButton.on("click tap" , function(e){
            if( headerSearchWrap.hasClass('active') ){
                //Check if search bar has text
                var headerSearchText = $(headerSearchInput).val();
                console.log(headerSearchText);
                if ( headerSearchText.length > 0 ){
                    $( headerSearchForm ).submit();
                } else {
                    closeHeaderSearch();
                }
            } else {
                openHeaderSearch();
            }
        });
                
        //Reset menu & search on click outside of menu
        $(document).on("click tap" , function(e){
            // if the target of the click isn't the container nor a descendant of the container
            if ( !headerSearchWrap.is(e.target) && headerSearchWrap.has(e.target).length === 0 ){
                closeHeaderSearch();
            }
        });
        
        function openHeaderSearch(){
            headerSearchWrap.addClass('active');
            headerSearchInput.focus();
            mainNavigation.addClass('search');
        }
        
        function closeHeaderSearch(){
            headerSearchWrap.removeClass('active');
            mainNavigation.removeClass('search');
        }
        
    }
    
    
    /** 
     * Menu 
     **/ 
    burgerSpan.on("click tap" , function(e){
        toggle_menu();
    });
    
    burger.on("click tap" , function(e){
        toggle_menu();
    });
    
    //Reset menu on click outside of menu
    $(document).mouseup(function(e) {
        // if the target of the click isn't the container. burger icon nor a descendant of the container
        if (!mainNavigation.is(e.target) && mainNavigation.has(e.target).length === 0 && !burgerSpan.is(e.target) && !burger.is(e.target) && !subMenuCont.is(e.target) ){
            deactivate_menu();
        }
    });
    
    function toggle_menu(){
        burger.toggleClass('open');
        mainNavigation.toggleClass('open');
        body.toggleClass('navigation-open');
        $( "header nav li" ).removeClass('open');
    }
    
    function deactivate_menu(){
        burger.removeClass('open');
        mainNavigation.removeClass('open');
        body.removeClass('navigation-open');
        $( "header nav li" ).removeClass('open');
    }
    
    /** Sub menu **/
    if( screenWidth < 1200 ){
        $( "header nav" ).find( ".current-menu-parent, .current-menu-item" ).closest("li").addClass("open").find(".sub-menu").first().slideToggle();
    } 
    
    /** Main Menu Full Screen Click **/
    $( "header nav li a" ).on("click tap touchstart" , function(e){
        if( screenWidth > 1200 ){
            
            var li = $(this).closest("li");
            
            if( li.hasClass("open") ){
                $('header nav li').removeClass('open');
            } else {
                $('header nav li').removeClass('open');
                li.addClass("open");
            }
            
            body.toggleClass('navigation-open');
            if( li.hasClass('main-menu-item') && li.hasClass('menu-item-has-children') ){
                e.preventDefault(); 
            }
            
        }
    });
    
    $("nav .toggle").on("click tap touchstart" , function(e){
        e.preventDefault();
        $(this).closest("li").toggleClass("open").find(".sub-menu").first().slideToggle();
    });
                    
});
    
