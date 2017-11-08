/**
 * Theme Script
 * 
 * This script holds all general code for the theme
 **/

var fitImages,
    menuToggle          = false, 
    sfInfLoadTog        = false,
    downloadId,          
    
    animSpeed           = 500,
    
    mobWidth            = 850,
    mobMenu             = 1183,
    
    imagePutRight       = false, //used to track where flaoted images are
    
    textFadeComplete    = false;


jQuery(document).ready(function($) {

    //Back to top script
	var toTop = function () {
        
		$(window).scroll(function () {
			if ($(this).scrollTop() > 800) {
				$('.toTop').addClass('show');
			} else {
				$('.toTop').removeClass('show');
			}
		});

		$('.toTop').on('click', function () {
			$("html, body").animate({ scrollTop: 0 }, 1000);
			return false;
		});
        
	};
    toTop();
 
        
    /**
     * Initalize Scroll Reveal
     **/

    if (typeof ScrollReveal == 'function') {
        
        window.sr = ScrollReveal({
            distance: '5px',
            duration: '1000',
            viewFactor: 0.4,
        });

        sr.reveal('.page-full-width .panel.sr', { 
            origin: 'top',
        });

        sr.reveal('.sr.top', { origin: 'top' });
        sr.reveal('.sr.left', { origin: 'left', distance: '20px' });
        sr.reveal('.sr.right', { origin: 'right', distance: '20px' });
    }
    
    //Smoothscrolling
    $(function() {
        $('a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                //As long as it is an internal anchor that isnt used by: Fancybox / HashTab
                if ( !$( this ).hasClass( "fancybox" ) && !$( this ).hasClass( "hashTab" ) ) { 
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                    if (target.length) {
                        $('html, body').animate({
                            scrollTop: target.offset().top - 50
                        }, 1000);
                        return false;
                    }
                }
            }
        });
    });
    
    
            
    $(".fancybox").fancybox({
        fullScreen : false,
        iframe : {
            scrolling : 'yes'
        },
        modal : false,
    });
    
    //Manage all login links
    $('[data-fancybox]').fancybox({
        beforeLoad: function(instance, current){
            var linkClicked = current.opts.$orig;     
            //Add redir URL to login if required
            if( $(linkClicked).hasClass('user-login-redir') && $('#user-login-module').length > 0 ){                
                $('#login-redir').val( $(linkClicked).data("redir") );
            }
        },
    });
    
    /**
     * Owl Carousel 
     **/
    $.fn.andSelf = function() {
        return this.addBack.apply(this, arguments);
    }
    
    // Get the multiple owl carousels and set IDs
    var breakdownOwlCount = 0;
    var breakdownOwlDiv = $(".breakdown-owl");
    breakdownOwlDiv.each(function () {
        if ($(this).children().length > 1) {
            $(this).attr("id", "breakdown-owl-" + breakdownOwlCount);
            $('#breakdown-owl-' + breakdownOwlCount).owlCarousel({
                nav: false, // Show next and prev buttons
                margin: 0,
                dots: true,
                items: 1,
                autoplay: true,
                autoplayTimeout: 5000,
                loop: true,
                animateOut: 'fadeOut',
            });
            breakdownOwlCount++;
        }
    });  
     
});