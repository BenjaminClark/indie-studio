var ajaxPostWrap       = document.getElementById("ajax-post-wrap"),
    loadMorePosts      = document.getElementById("load-more-posts");
    
if ( ajaxPostWrap && loadMorePosts ){
    
    var basicNavAbove   = document.getElementById("nav-above"), 
        basicNavBelow   = document.getElementById("nav-below"), 
        buttonWrap      = document.getElementById("load-more-wrap"),
        query           = loadMorePosts.getAttribute('data-query'),
        paged           = loadMorePosts.getAttribute('data-paged'),
        template        = loadMorePosts.getAttribute('data-custom-template');
            
    //Hide standard buttons
    if( basicNavAbove ){
        fade({el:basicNavAbove,type:'out',duration: 500});
    }
    if( basicNavBelow ){
        fade({el:basicNavBelow,type:'out',duration: 500});
    }
    
    //Show Load More button
    fade({el:loadMorePosts,type:'in',duration: 500});
    
    /**
     * Post Ajax
     **/
    
    //Run on load more click
    if( loadMorePosts ){
        
        loadMorePosts.addEventListener("click",function(){
            
            //Remove any errors
            load_more_error('out');
            
            //Fade out load more button  -  Then add loading spinner
            fade({el:loadMorePosts,type:'out',duration: 500,},function(){
                ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'prepend' );
            });
            
            var data = {
                action      : 'indie_studio_load_more_posts',
                query       : query,
                template    : template,
                paged       : paged,
            };
            
            postPhpAjax(data, 'json', '', postsLoadFunction);

        });
    }
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

                    if( bricklayerLive ){

                        //Append posts using Bricklayer
                        bricklayer.append(el);

                    } else {

                        //Add posts not in Bricklayer
                        el.style.display = 'none';
                        ajaxPostWrap.appendChild(el);
                        fade({el:el,type:'in',duration: 500});

                    } 


                    if (--i) {          
                        delayModuleLoad(i);       
                    }
                }, 100);
            })( response.html.length );
            
        } else {
            load_more_error('in');
        }
        
        if( response.load_more ){
                        
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
    
    //No Content
    ajaxLoadingAnimation(document.getElementById("load-more-wrap"), 'remove');
    
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