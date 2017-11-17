var bricklayerLive = false;

/**
 * Init Bricklayer JS
 * https://github.com/ademilter/bricklayer
 **/

var bricklayerDom = document.querySelector('.bricklayer');
if( bricklayerDom ){    
    var bricklayer = new Bricklayer( bricklayerDom );
    //Check that the bricklayer JS has initalized
    if( bricklayer.columnCount ){   
        bricklayerLive = true;
        bricklayerDom.classList.remove('basic');        
    }
}

bricklayer.appendLazyElement(function (done) {
  setTimeout(function () {
    done(element)
  }, 1000)
})