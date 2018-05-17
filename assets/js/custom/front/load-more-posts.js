var ajaxPostWrap       = document.getElementById("ajax-post-wrap"),
    loadMorePosts      = document.getElementById("load-more-posts"),
    footerDiv          = document.querySelector('footer');
    
if ( ajaxPostWrap && loadMorePosts ){
    
    var buttonWrap      = document.getElementById("load-more-wrap"),
        query           = loadMorePosts.getAttribute('data-query'),
        paged           = loadMorePosts.getAttribute('data-paged'),
        template        = loadMorePosts.getAttribute('data-custom-template'),
        loadType        = loadMorePosts.getAttribute('data-loadtype'),
        loading         = false,
        loadMore        = true;
    
    
    //Show Load More button
    if( loadType === 'button' ){
        (function($){ $( loadMorePosts ).fadeIn( 10 ); })(jQuery);
    }
    
    
    /**
     * Post Ajax
     **/
    
    var data = {
        action      : 'indie_studio_load_more_posts',
        query       : query,
        template    : template,
        paged       : paged,
    };
    
    
    //Run on scroll to bottom of page
    if( loadType == 'infinite' ){
        window.onscroll = function(ev) {
            if ( almostAtBottom() && !loading && loadMore ) {
                getNewPostsAjax(data);
            }
        };
    }
    
    //Run on load more click
    if( loadMorePosts && loadType == 'button' ){
        loadMorePosts.addEventListener("click",function(){
            getNewPostsAjax(data);
        });
    }
    
}


function getNewPostsAjax(data){
    
    loading = true;
    
    //Remove any errors
    load_more_error('out');

    if ( loadType === 'button' ){
        //Fade out load more button  -  Then add loading spinner
        (function($){ $( loadMorePosts ).fadeOut( 100, function(){
            ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'prepend' );
        } ); })(jQuery);
    } else {
        ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'prepend' );
    }

    postPhpAjax(data, 'json', '', postsLoadFunction);   
    
}


function postsLoadFunction(response){
        
    if( response ){
        
        //Update paged
        if( response.paged ){
            paged = response.paged;
        }        
        
        if ( !response.load_more ){
            loadMore = false;
        }
        
        //Check there is result
        if( response.html.length > 0 ){
            
            //Loop through posts
            (function delayModuleLoad(i) {
                setTimeout(function () {

                    if( response.html[i] ){

                        //Create a fake div to hold html
                        var fakeEl = document.createElement( 'div' );
                        fakeEl.innerHTML = response.html[i];

                        el = fakeEl.firstChild;

                        if( masonryLive ){

                            //Append posts using Masonry
                            ajaxPostWrap.appendChild( el );

                            imagesLoaded( ajaxPostWrap, function(){
                                masonry.appended( el );
                                buildLoryCarousel( el );
                            });

                        } else {

                            //Add posts not in Bricklayer
                            el.style.display = 'none';
                            ajaxPostWrap.appendChild(el);
                            (function($){ $( el ).fadeIn( 1000 ); })(jQuery);
                            buildLoryCarousel( el );

                        } 

                        fakeEl.remove();

                    }
                    
                    if (--i) {    
                        
                        // Load function again to show next post
                        delayModuleLoad(i);    
                        
                    } else {
                        
                        // We have shown all, show the button
                        if( response.load_more && loadType === 'button' ){

                            masonry.on( 'layoutComplete', function(){

                                (function($){ $( loadMorePosts ).delay( 1000 ).fadeIn( 1000 ); })(jQuery);

                           } );

                        }  

                    }
                }, 100);
                
            })( response.html.length );
            
        } else {
            load_more_error('in');
        }
                
    } else {
        load_more_error('in');
    }
    
    loading = false;
    
    //No Content
    ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'remove' );
    
}


/**
 * Check if footer is almost on the screen. 
 * 
 * Pre-empt this, and load more before the user reaches the bottom
 **/

function almostAtBottom() {
    var rect = footerDiv.getBoundingClientRect();
    var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
    
    return !(rect.bottom < 0 || rect.top - viewHeight - 500 >= 0);
}


/**
 * Show or hide the error message for loading more posts
 * @param string type "in" / "out"
 */

function load_more_error( type ){
    if( type == 'in' || type == 'out' ){
        var error = document.getElementById("load-more-posts-error");
        if( type == 'in' && !error.classList.contains("show") || type == 'out' && error.classList.contains("show") ){
            error.classList.toggle("show");
        } 
    }
}