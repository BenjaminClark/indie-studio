var masonryLive = false;

var masonryDom = document.querySelector('.masonry');
if( masonryDom ){    
    
    var masonry = new Masonry( masonryDom, {
        columnWidth: '.masonry-column-sizer',
        gutter: '.masonry-gutter-sizer',
        itemSelector: '.module',
        percentPosition: true,
    });
     
    imagesLoaded( masonryDom ).on( 'progress', function() {
        masonry.layout();
    });
    
    masonryDom.classList.remove('basic'); 
    masonryLive = true;     
    
}