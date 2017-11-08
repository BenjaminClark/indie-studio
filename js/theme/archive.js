var archiveCount        = 0,
    archiveShown        = 0,
    archiveOffset       = 1,
        
    categoryFilter      = document.getElementById('archive-category'),
    monthFilter         = document.getElementById('archive-month'),
    archiveSearch       = document.getElementById('archive-search'),
    
    //Get archive details
    archiveDetails      = {
        type        : document.getElementById('post_type'),
        totalNum    : document.getElementById('post_total'), 
        loaded      : document.getElementById('post_ids_loaded'),
        archive     : document.getElementById('post_archive_link'),
        cat         : document.getElementById('post_category'),
        tax         : document.getElementById('post_tax'),
        year        : document.getElementById('post_date_year'),
        month       : document.getElementById('post_date_month'),
        search      : document.getElementById('post_search'),
        orderby     : document.getElementById('post_orderby'), 
    },
        
    loadMorePosts       = document.getElementById("load_more_posts"),
    postReturned        = document.getElementById("posts_returned");
    
if ( postReturned ){
        
    for (var key in archiveDetails) {
        if(archiveDetails[key]){
            archiveDetails[key] = archiveDetails[key].value;
        } else {
            archiveDetails[key] = '';
        }
    }
        
    //These functions redirects the page on filter change

    if(monthFilter){
        monthFilter.addEventListener('change',function(){
            window.location.href = monthFilter.options[monthFilter.selectedIndex].value;
        });
    }

    if(categoryFilter){
        categoryFilter.addEventListener('change',function(e){
            window.location.href = this.value;
        });
    }

    if(archiveSearch && archiveDetails.archive){
        if(archiveDetails.archive){
            archiveSearch.addEventListener('submit',function(e){
                e.preventDefault();
                var searchVal = archiveSearch.elements[0];
                if(searchVal.value.length > 0){
                    window.location.href = archiveDetails.archive + '?lookup=' + searchVal.value;
                }
            });
        }
    }

    /**
     * Post Ajax
     **/

    /**
     * We have already loaded the first 12, only need to load more
     * 
     * We must get the IDs of the posts currently loaded.
     **/

    if(archiveDetails.loaded){
        loadedArchivePostsShown = archiveDetails.loaded.split(',').map(Number); //Get ids from html as array
        loadedArchivePostsCount = loadedArchivePostsShown.length; //count post ids

        archiveShown = loadedArchivePostsShown;
        archiveCount = loadedArchivePostsCount;  
    }    

    //Run on load more click
    if(loadMorePosts){
        
        loadMorePosts.addEventListener("click",function(){
            
            //Fade out load more button  -  Then add loading spinner
            fade({el:loadMorePosts,type:'out',duration: 500,},function(){
                ajaxLoadingAnimation( document.getElementById("load_holder"), 'prepend' );
            });
            
            var data = {
                action      : 'get_any_posts_ajax',
                pOf         : archiveOffset,
            };
            
            if( isset( archiveDetails.type ) ){
               data['pTy'] = archiveDetails.type;
            }
            
            if( isset( archiveShown ) ){
               data['pSh'] = archiveShown;
            }
            
            if( isset( archiveDetails.search ) ){
               data['pSe'] = archiveDetails.search;
            }
            
            if( isset( archiveDetails.tax ) ){
               data['pTa'] = archiveDetails.tax;
            }
            
            if( isset( archiveDetails.cat ) ){
               data['pCa'] = archiveDetails.cat;
            }
            
            if( isset( archiveDetails.year ) ){
               data['pYe'] = archiveDetails.year;
            }
            
            if( isset( archiveDetails.month ) ){
               data['pMo'] = archiveDetails.month;
            }
            
            if( isset( archiveDetails.orderby ) ){
               data['pOr'] = archiveDetails.orderby;
            }
                        
            postPhpAjax(data, 'json', '', archiveLoadFunction);

        });
    }
}

function archiveLoadFunction(response){
    
    console.log(response);
    
    if(response){

        //Get the IDs from the PHP function, to pass back and ignore on the next call
        var postCount = response.count;

        //Update the archive post counter
        archiveCount = archiveCount + postCount;
        archiveOffset = archiveOffset + 1;
        
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
                        postReturned.appendChild(post);
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
        if( response.complete || archiveCount == archiveDetails.totalNum ){
            
            //Remove load more button, all stockists have loaded
            fade({el:loadMorePosts,type:'out',duration: 500});   
            
        }
        
    }
    
    //No Content
    ajaxLoadingAnimation(document.getElementById("load_holder"), 'remove');

    
}