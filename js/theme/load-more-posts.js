var ajaxPostWrap       = document.getElementById("ajax-post-wrap"),
    loadMorePosts      = document.getElementById("load-more-posts");
    
if ( ajaxPostWrap && loadMorePosts ){
    
    var basicNavAbove   = document.getElementById("nav-above"), 
        basicNavBelow   = document.getElementById("nav-below"), 
        query           = document.getElementById("query"),
        buttonWrap      = document.getElementById("load-more-wrap"),
        paged           = loadMorePosts.getAttribute('data-paged'),
        postPerPage     = loadMorePosts.getAttribute('data-max-pages'),
        maxPostsNum     = loadMorePosts.getAttribute('data-total-pages'),
        totalNumPages   = Math.ceil( maxPostsNum / postPerPage );

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
    if(loadMorePosts){
        
        loadMorePosts.addEventListener("click",function(){
            
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
    
    console.log(response);
    
    /**
    
    if(response){

        //Update page counter
        paged = paged + 1;

        //Check there is result
        if( response.html.length > 0 ){
                                    
            for (var i=0; i<=response.html.length; i++) {
                                               
                if(response.html[i] != undefined){
                    
                    //Create a fake div to hold posts - add new html to div
                    var el = document.createElement( 'div' );
                    el.innerHTML = response.html[i];
                    
                    //Loop through children in fake div
                    //Display as none, add to postreturned div, fade in
                    while(el.firstChild) {
                        var post = el.firstChild;
                        post.style.display = 'none';
                        ajaxPostWrap.appendChild(post);
                        fade({el:post,type:'in',duration: 500});
                    }
                    
                    //Remove fake div
                    el.remove(); 

                }     
            }

            //Add load more button
            fade({el:loadMorePosts,type:'in',duration: 500});   
            
        }

        //If ajax says we are complete, or all items have been returned, remove all loading spinners/load more buttons
        if( paged >= totalNumPages ){
            
            //Remove load more button, all stockists have loaded
            fade({el:loadMorePosts,type:'out',duration: 500});   
            
        }
        
    }
    
    //No Content
    ajaxLoadingAnimation(document.getElementById("load-more-wrap"), 'remove');
**/
    
}