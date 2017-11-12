var ajaxPostWrap       = document.getElementById("ajax-post-wrap"),
    loadMorePosts      = document.getElementById("load-more-posts");
    
if ( ajaxPostWrap && loadMorePosts ){
    
    var basicNavAbove   = document.getElementById("nav-above"), 
        basicNavBelow   = document.getElementById("nav-below"), 
        buttonWrap      = document.getElementById("load-more-wrap"),
        query           = loadMorePosts.getAttribute('data-query'),
        paged           = loadMorePosts.getAttribute('data-paged'),
        morePosts       = loadMorePosts.getAttribute('data-load-more');
    
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
                query       : query.value,
                paged       : paged,
            };
                                    
            postPhpAjax(data, 'json', '', postsLoadFunction);

        });
    }
}

function postsLoadFunction(response){
    
    if( response ){
        
        //Update page counter
        paged++;

        //Check there is result
        if( response.html.length > 0 ){
                                    
            //Create a fake div to hold posts - add new html to div
            var el = document.createElement( 'div' );
            el.innerHTML = response.html;
            var articles = el.getElementsByTagName('article');
            
            //Loop through children in fake div
            //Display as none, add to postreturned div, fade in
            
            for( i=0; i< articles.length; i++ ){
                var post = articles[i];
                post.style.display = 'none';
                ajaxPostWrap.appendChild(post);
                fade({el:post,type:'in',duration: 500});
            }

            //Remove fake div
            el.remove();            
            
        } else {
            load_more_error('in');
        }
        
        fade({el:loadMorePosts,type:'in',duration: 500}); 

        if( response.load_more ){
            
            //Show the load more button if we have posts to see
            fade({el:loadMorePosts,type:'in',duration: 500});   
            
        }
        
    } else {
        load_more_error('in');
    }
    
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