/** Post Ajax Masonry **/

var masonryLive = false;

var postsMasonryDom = document.querySelector('.masonry');

if( postsMasonryDom ){   
        
    var masonry = new Masonry( postsMasonryDom, {
        columnWidth: '.masonry-column-sizer',
        gutter: '.masonry-gutter-sizer',
        itemSelector: '.module',
        percentPosition: true,
    });
     
    imagesLoaded( postsMasonryDom ).on( 'progress', function() {
        masonry.layout();
    });
    
    postsMasonryDom.classList.remove('basic'); 
    masonryLive = true;     
    
}


/** Gallery Masonry **/

var galleryMasonryDom = document.querySelector('.gallery');
if( galleryMasonryDom ){    
    
    var galleryMasonry = new Masonry( galleryMasonryDom, {
        itemSelector: '.gallery-item',
        percentPosition: true,
    });
     
    imagesLoaded( galleryMasonryDom ).on( 'progress', function() {
        galleryMasonry.layout();
    }); 
    
}