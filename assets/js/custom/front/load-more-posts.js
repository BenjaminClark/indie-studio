var ajaxPostWrap       = document.getElementById("ajax-post-wrap"),
    loadMorePosts      = document.getElementById("load-more-posts"),
    footerDiv          = document.querySelector('footer');
    
if ( ajaxPostWrap && loadMorePosts ){
    
    var basicNavAbove   = document.getElementById("nav-above"), 
        basicNavBelow   = document.getElementById("nav-below"), 
        buttonWrap      = document.getElementById("load-more-wrap"),
        query           = loadMorePosts.getAttribute('data-query'),
        paged           = loadMorePosts.getAttribute('data-paged'),
        template        = loadMorePosts.getAttribute('data-custom-template'),
        loadType        = loadMorePosts.getAttribute('data-loadtype'),
        loading         = false;
    
    //Hide standard buttons
    if( basicNavAbove ){
        fade({el:basicNavAbove,type:'out',duration: 500});
    }
    if( basicNavBelow ){
        fade({el:basicNavBelow,type:'out',duration: 500});
    }
    
    //Show Load More button
    if( loadType === 'button' ){
        fade({el:loadMorePosts,type:'in',duration: 500});
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
            if ( almostAtBottom() && !loading ) {
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
        fade({el:loadMorePosts,type:'out',duration: 10,},function(){
            ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'prepend' );
        });
    } else {
        ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'prepend' );
    }

    postPhpAjax(data, 'json', '', postsLoadFunction);   
    
}


function postsLoadFunction(response){
    
    if( response ){
                
        //Check there is result
        if( response.html.length > 0 ){
            
            //Loop through posts
            (function delayModuleLoad(i) {
                setTimeout(function () {

                    //Create a fake div to hold html
                    var el = document.createElement( 'div' );
                    el.innerHTML = response.html[i];

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
                        fade({el:el,type:'in',duration: 1000});
                        buildLoryCarousel( el );

                    } 


                    if (--i) {          
                        delayModuleLoad(i);       
                    }
                }, 100);
            })( response.html.length );
            
        } else {
            load_more_error('in');
        }
        
        if( response.load_more && loadType === 'button' ){
                        
            //Show the load more button if we have posts to see
            fade({el:loadMorePosts,type:'in',duration: 500});   
            
        }
        
        //Update paged
        if( response.paged ){
            paged = response.paged;
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