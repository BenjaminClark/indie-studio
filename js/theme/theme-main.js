/**
 * Theme Script
 * 
 * This script holds all general code for the theme
 **/

var animSpeed = 500;

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
    
    //Smoothscrolling to anchor
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
    
});