var masonryLive = false;

var masonryDom = document.querySelector('.masonry');
if( masonryDom ){    
    
    var masonry = new Masonry( masonryDom, {
        columnWidth: '.masonry-column-sizer',
        gutter: '.masonry-gutter-sizer',
        itemSelector: '.module',
        percentPosition: true,
    });
     
    imagesLoaded( masonryDom, function( instance ) {
        masonry.layout();
        //animate in
        masonryAnimateIn( masonry.items );
    });
    
    masonryDom.classList.remove('basic'); 
    masonryLive = true;     
    
}


function masonryAnimateIn( masonry ){
    var el = masonry.splice(Math.floor( Math.random() * masonry.length ), 1);
    if(el.length){
        fade({el: el[0].element, type:'in', duration: 100});
        setTimeout(function () {
            masonryAnimateIn( masonry )
        }, 100 + Math.floor(Math.random() * 50))
    }
}