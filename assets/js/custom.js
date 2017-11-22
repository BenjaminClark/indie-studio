/**
 * This function replaces the JQuery ajax function
 * 
 * It can be treated the same as a JQuery wrapper, without the
 * need for loading jquery
 **/ 

//Contains the elements that are currently loading
var ajaxLoadingAnimationActive = [];

function ajax( dataObject ) {
    
    dataObjectClean = { 
        type: '', 
        url: '', 
        data: '', 
        dataType: 'json', 
        beforeSend: '', 
        error: '', 
        success: '' 
    };
    
    for (var key in dataObjectClean) {
        if(!dataObject[key]){
            dataObject[key] = dataObjectClean[key].value;
        }
    }
    
    //Add nonce to data
    dataObject.data.security = theme_custom_ajax.security;
    
    var proceed = true,
        params = '';
    
    //First run basic error checking
    if(!dataObject.type){
        console.log('A request type must be set');
        proceed = false
    }
    
    if(dataObject.type === 'GET' || dataObject.type === 'POST'){
        //We have a correct type
    } else {
        console.log('Incorrect request type set');
        proceed = false;
    }
    
    if(!dataObject.url){
        console.log('A request url must be set');
        proceed = false;
    }
    
    if(!dataObject.success){
        console.log('A callback function must be set');
        proceed = false;
    }
    
    //If we have errors, return
    if(!proceed) return;
    
    
    //We have made it past the first section, now we can fire the beforeSend function
    if(dataObject.beforeSend != '' && typeof dataObject.beforeSend === "function") dataObject.beforeSend();    
    
    
    //If we have extra data to append, turn into query string
    if(dataObject.data){
        var params = typeof dataObject.data == 'string' ? dataObject.data : Object.keys(dataObject.data).map(
            function(k){ return encodeURIComponent(k) + '=' + encodeURIComponent(dataObject.data[k]) }
        ).join('&');
    }
    
    
    

    
    var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    
    if(dataObject.type == 'GET'){
        //If we have extra parameters, add query string
        if(params){
            dataObject.url = dataObject.url + '/?' + params;
        }
        request.open("GET", dataObject.url);
    }
    
    if(dataObject.type == 'POST'){
        //If we have extra parameters, add query string
        if(params){
            dataObject.url = dataObject.url + '/?' + params;
        }
        request.open("POST", dataObject.url);
    }
    
    
    
    
    /**
        XML Request Ready State
    0	UNSENT	Client has been created. open() not called yet.
    1	OPENED	open() has been called.
    2	HEADERS_RECEIVED	send() has been called, and headers and status are available.
    3	LOADING	Downloading; responseText holds partial data.
    4	DONE	The operation is complete.
    **/
    
    
    //Set the listener for the statechange
    request.onreadystatechange = function() {
        
        //Check data was returned
        if (request.readyState == 4) {

            //The request was ok, and we have a response
            if(request.status == 200){

                try {
                    var output = request.responseText;
                } catch(err) {
                    //If an error function has been provided and exists
                    if(typeof error === "function"){
                        //Pass the error to the error function
                        error(err.message + " in " + request.responseText);
                    }
                    return;
                }
                
                //Here we format the response depending on 
                //what data type has been requested

                if(dataObject.dataType == 'json'){
                    output = JSON.parse(request.responseText);
                }
                
                dataObject.success(output);
            }
        }
    };
 
    request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    
    if(dataObject.type == 'POST'){
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        request.send(params);
    }
    
    if(dataObject.type == 'GET') request.send();
    
    return request;
    
}


/**
 * General GET AJAX
 * 
 * Pass -   data        : action and data
 *      -   firstFunct  : function run before send
 *      -   passer      : where the response is passed
 **/

function getPhpAjax(data, dateType, firstFunc, passer) {

    ajax({
        type       : "GET",
        url        : theme_custom_ajax.ajax_url,
        dataType   : dateType,
        data       : data,
        beforeSend : function () {
            if(firstFunc){
                firstFunc();
            }
        },
        success: function (response) {
            if(passer){
                //Pass response to specified function 
                passer(response);
            }
        },
        error     : function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
        }
    });
}  

/**
 * General GET AJAX
 * 
 * Pass -   data        : action and data
 *      -   firstFunct  : function run before send
 *      -   passer      : where the response is passed
 **/

function postPhpAjax(data, dateType, firstFunc, passer) {

    ajax({
        type       : "POST",
        url        : theme_custom_ajax.ajax_url,
        dataType   : dateType,
        data       : data,
        beforeSend : function () {
            if(firstFunc){
                firstFunc();
            }
        },
        success: function (response) {
            if(passer){
                //Pass response to specified function 
                passer(response);
            }
        },
        error     : function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
        }
    });
}  



/**
 * General Loading animation
 * 
 * Pass -   Location ID : where the animation is to be appended
 *          Type        : is the animation being appended or removed
 **/

function ajaxLoadingAnimation(location, type){
        
    if(type == 'prepend' || type == 'append'){
        
        //If location is currently not loading
        if(!ajaxLoadingAnimationActive.contains(location)){
        
            /**
             * Push location to loading object
             * This allows multiple locations to load elements
             * at any one time on a page
             **/
            
            ajaxLoadingAnimationActive.push(location);

            var div = document.createElement("div");
            div.style.display = 'none';
            div.classList.add('loader');

            if (!location.classList.contains('loading')) {
                location.classList.add('loading');
            }

            if(type == 'prepend'){
                location.insertBefore(div, location.firstChild);
                fade({el:div,type:'in',duration: 500});
            } 

            if(type == 'append'){
                insertAfter(div, location);
                fade({el:div,type:'in',duration: 500});
            } 
        }
        
    }
    if(type == 'remove'){  
        
        //If location is currently not loading
        if(ajaxLoadingAnimationActive.contains(location)){
        
            var locationToRemove = ajaxLoadingAnimationActive.indexOf(location);
            if(locationToRemove != -1) {
                ajaxLoadingAnimationActive.splice(locationToRemove, 1);
            }
        
            if (location.classList.contains('loading')) {
                location.classList.remove('loading');
            }

            var loadingDiv = location.getElementsByClassName('loader');
            if(loadingDiv.length > 0){
                while(loadingDiv[0]){
                    loadingDiv[0].parentNode.removeChild(loadingDiv[0]);
                }
            }
        }
    } 

}
//Add target blank to classes
var externalElem = document.querySelectorAll("a.external, .external a");
for (var i=0; i < externalElem.length; i++) {
    externalElem[i].setAttribute("target", "_blank");
    externalElem[i].setAttribute("rel", "noopener noreferrer");
}

/** This section allows multiple events to be added in vanilla JS **/
Element.prototype.on = Element.prototype.addEventListener;
//(element, event type - split by comma, function)
function addEvents(el, s, fn) {
    var e = s.split(', ');
    for (var i = 0, l = e.length; i < l; i++) {
        el.on(e[i], fn, false);
    }
}


/**
 * This function allows query strings to be 
 * called by JS and returned
 * 
 * //http://stackoverflow.com/questions/901115/how-can-i-get-query-string-values-in-javascript
 */

function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}



function isEmpty(obj) {
    for(var prop in obj) {
        if(obj.hasOwnProperty(prop))
            return false;
    }
    return true;
}


//Check if target has class, down to IE6
function hasClass( target, className ) {
    return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
}

/**
 * This function checks a specific cookie and returns false if
 * cookie is not set
 */

function checkCookieSet(cookie){
    var acceptedCookie = store.get(cookie);
    if(typeof acceptedCookie == "undefined"){
        //set a default
        acceptedCookie = false;
    }
    return acceptedCookie;
}


/**
 * Fit all images using the Object Fit Polyfill
 * Only target those with the obj-fit class
 **/
if (typeof objectFitImages == 'function') { 
    fitImages = document.querySelectorAll('.obj-fit');
    if(fitImages){objectFitImages(fitImages);}
}



/** Keep values synced **/
function syncTextInputElements ( firstInput, secondInput ){
    
    var firstElem = document.getElementById(firstInput);
    var secondElem = document.getElementById(secondInput);
    
    if( firstElem != null && secondElem != null ){
        
        //Add custom event listener
        addEvents(firstElem, 'keyup, change, focusout, touchend', function(){
            secondElem.value = firstElem.value;
        });
        
        //Add custom event listener
        addEvents(secondElem, 'keyup, change, focusout, touchend', function(){
            firstElem.value = secondElem.value;
        });
        
    }
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}  


function insertAfter(newNode, referenceNode) {
    referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
}


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.
function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		};
		var callNow = immediate && !timeout;
		clearTimeout(timeout);
		timeout = setTimeout(later, wait);
		if (callNow) func.apply(context, args);
	};
};


/** Is element on a screen **/
function checkVisible(elm) {
    var rect = elm.getBoundingClientRect();
    var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
    return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
}

/**
 * Fade in/out an element
 * Note: I am not using requestAnimationFrame as it does not play well in mobile browsers
 *
 * @param {Object}   [options={}]                An object with options.
 * @param {Element}  [options.el]                The Element object.
 * @param {String}   [options.type='in']         The fade type: 'in' or 'out'.
 * @param {Integer}  [options.duration=400]      The duration of the animation in miliseconds.
 * @param {String}   [options.display='block']   The display property of the element when fade in starts.
 * @param {Boolean}  [options.empty=false]       Set to true if you need to empty the element after fade out.
 */
function fade(options,callback){
        
	options = Object.assign({
		type:'in',
		duration:400,
		display:'block'
	}, options)
    
	var isIn = options.type === 'in',
		opacity = isIn ? 0 : 1,
		interval = 50,
		gap = interval / options.duration

	if(isIn) {
		options.el.style.display = options.display
		options.el.style.opacity = opacity
	}
    
	var fading = window.setInterval(function() {
		opacity = isIn ? opacity + gap : opacity - gap
		options.el.style.opacity = opacity

		if(opacity <= 0) options.el.style.display = 'none'
		if(opacity <= 0 || opacity >= 1) {
			if(fading) window.clearInterval(fading)
			if(options.empty) options.el.textContent = ''
            if(callback) callback();
		}
	}, interval);
}


/**
 * Slide an element down like jQuery's slideDown function using CSS3 transitions.
 * @see https://gist.github.com/ludder/4226288
 * @param  {element}  el
 * @param  {string}   timing
 * @return {void}
 */
function slideDown(el, timing) {
  timing = timing || '300ms ease';

  // Get element height
  el.style.webkitTransition = 'initial';
  el.style.transition = 'initial';
  el.style.visibility = 'hidden';
  el.style.maxHeight = 'initial';
  var height = el.offsetHeight + 'px';
  el.style.removeProperty('visibility');
  el.style.maxHeight = '0';
  el.style.overflow = 'hidden';

  // Begin transition
  el.style.webkitTransition = 'max-height ' + timing + ', opacity ' + timing + '';
  el.style.transition = 'max-height ' + timing + ', opacity ' + timing + '';
  var endSlideDown = function() {
    el.style.removeProperty('-webkit-transition');
    el.style.removeProperty('transition');
    el.removeEventListener(transitionEvent('end'), endSlideDown);
  };
  requestAnimationFrame(function() {
    el.addEventListener(transitionEvent('end'), endSlideDown);
    el.style.maxHeight = height;
    el.style.opacity = '1';
  });
}

/**
 * Slide an element up like jQuery's slideUp function using CSS3 transitions.
 * @see https://gist.github.com/ludder/4226288
 * @param  {element}  el
 * @param  {string}   timing
 * @return {void}
 */
function slideUp(el, timing) {
  timing = timing || '300ms ease';

  // Get element height
  el.style.webkitTransition = 'initial';
  el.style.transition = 'initial';
  var height = el.offsetHeight + 'px';
  el.style.maxHeight = height;
  el.style.overflow = 'hidden';

  // Begin transition
  el.style.webkitTransition = 'max-height ' + timing + ', opacity ' + timing + '';
  el.style.transition = 'max-height ' + timing + ', opacity ' + timing + '';
  var endSlideDown = function() {
    el.style.removeProperty('-webkit-transition');
    el.style.removeProperty('transition');
    el.removeEventListener(transitionEvent('end'), endSlideDown);
  };
  requestAnimationFrame(function() {
    el.style.maxHeight = '0';
    el.style.opacity = '0';
  });
}


/**
 * Array.prototype.[method name] allows you to define/overwrite an objects method
 * needle is the item you are searching for
 * this is a special variable that refers to "this" instance of an Array.
 * returns true if needle is in the array, and false otherwise
 */
Array.prototype.contains = function ( needle ) {
   for (i in this) {
       if (this[i] == needle) return true;
   }
   return false;
}


/** This function takes you to an anchor on the page **/
function jump(h){
    var top = document.getElementById(h).offsetTop;
    window.scrollTo(0, top);
}

function isEven(value){
    if (value%2 == 0)
        return true;
    else
        return false;
}


function isset (){
    
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: FremyCompany
    // +   improved by: Onno Marsman
    // +   improved by: Rafał Kukawski
    // *     example 1: isset( undefined, true);
    // *     returns 1: false
    // *     example 2: isset( 'Kevin van Zonneveld' );
    // *     returns 2: true

  var a = arguments,
    l = a.length,
    i = 0,
    undef;

  if (l === 0)
  {
    throw new Error('Empty isset');
  }

  while (i !== l)
  {
    if (a[i] === undef || a[i] === null)
    {
      return false;
    }
    i++;
  }
  return true;
}
var ajaxPostWrap       = document.getElementById("ajax-post-wrap"),
    loadMorePosts      = document.getElementById("load-more-posts"),
    footerDiv          = document.querySelector('footer');
    
if ( ajaxPostWrap && loadMorePosts ){
    
    var basicNavAbove   = document.getElementById("nav-above"), 
        basicNavBelow   = document.getElementById("nav-below"), 
        buttonWrap      = document.getElementById("load-more-wrap"),
        query           = loadMorePosts.getAttribute('data-query'),
        paged           = loadMorePosts.getAttribute('data-paged'),
        template        = loadMorePosts.getAttribute('data-custom-template'),
        loadType        = loadMorePosts.getAttribute('data-loadtype'),
        loading         = false;
    
    //Hide standard buttons
    if( basicNavAbove ){
        fade({el:basicNavAbove,type:'out',duration: 500});
    }
    if( basicNavBelow ){
        fade({el:basicNavBelow,type:'out',duration: 500});
    }
    
    //Show Load More button
    if( loadType === 'button' ){
        fade({el:loadMorePosts,type:'in',duration: 500});
    }
    
    
    /**
     * Post Ajax
     **/
    
    var data = {
        action      : 'indie_studio_load_more_posts',
        query       : query,
        template    : template,
        paged       : paged,
    };
    
    
    //Run on scroll to bottom of page
    if( loadType == 'infinite' ){
        window.onscroll = function(ev) {
            if ( almostAtBottom() && !loading ) {
                getNewPostsAjax(data);
            }
        };
    }
    
    //Run on load more click
    if( loadMorePosts && loadType == 'button' ){
        loadMorePosts.addEventListener("click",function(){
            getNewPostsAjax(data);
        });
    }
    
}


function getNewPostsAjax(data){
    
    loading = true;
    
    //Remove any errors
    load_more_error('out');

    //Fade out load more button  -  Then add loading spinner
    fade({el:loadMorePosts,type:'out',duration: 500,},function(){
        ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'prepend' );
    });

    postPhpAjax(data, 'json', '', postsLoadFunction);   
    
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

                    if( masonryLive ){

                        //Append posts using Masonry
                        ajaxPostWrap.appendChild( el );
                        masonry.appended( el );
                        buildLoryCarousel( el );
                        
                    } else {

                        //Add posts not in Bricklayer
                        el.style.display = 'none';
                        ajaxPostWrap.appendChild(el);
                        fade({el:el,type:'in',duration: 1000});
                        buildLoryCarousel( el );

                    } 


                    if (--i) {          
                        delayModuleLoad(i);       
                    }
                }, 100);
            })( response.html.length );
            
        } else {
            load_more_error('in');
        }
        
        if( response.load_more && loadType === 'button' ){
                        
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
    
    loading = false;
    
    //No Content
    ajaxLoadingAnimation( document.getElementById("load-more-wrap"), 'remove' );
    
}


/**
 * Check if footer is almost on the screen. 
 * 
 * Pre-empt this, and load more before the user reaches the bottom
 **/

function almostAtBottom() {
    var rect = footerDiv.getBoundingClientRect();
    var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
    
    return !(rect.bottom < 0 || rect.top - viewHeight - 500 >= 0);
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
/**
 * This file holds the Google Analytics and the
 * custom error message functions.
 * 
 * If any other logging is required, it should be included in
 * this file.
 **/ 

var allowDebug          = theme_custom_ajax.ajax_url;

/** Google Analytics Checker **/
function creatGaEvent(title, action, name){
    if (typeof ga == 'function') {
        ga( "send", "event", title, action, name, 0 );
    } 
}


/** Error Logging **/ 
function p_c(message, type){
    
    if(!type){type = 'notif';}
    
    if( allowDebug ){
    
        if(type == 'success'){
            console.log( '%cSuccess%c ' + message, 'color: white; background-color: green; padding: 0 0.5em 0 0.5em;', ' ' )
        }

        if(type == 'notif'){
            console.log( '%cNotification%c ' + message, 'color: white; background-color: purple; padding: 0 0.5em 0 0.5em;', ' ' )
        }

        if(type == 'warn'){
            console.log( '%cWarning%c ' + message, 'color: white; background-color: orange; padding: 0 0.5em 0 0.5em;', ' ' )
        }

        if(type == 'error'){
            console.log( '%cError%c ' + message, 'color: white; background-color: red; padding: 0 0.5em 0 0.5em;', ' ' )
        }
    }   
}

p_c('------ Debugging Enabled ------');
p_c('-- Custom scripts start here --');
function buildLoryCarousel(el){
    
    var simple_dots       = el.querySelector('.lory-carousel');
    
    if ( simple_dots  ) {
    
        var dot_count         = simple_dots.querySelectorAll('.js_slide').length;
        var dot_container     = simple_dots.querySelector('.js_dots');
        var dot_list_item     = document.createElement('li');
        dot_list_item.className = 'smooth';
        
        function handleDotEvent(e) {
            if (e.type === 'before.lory.init') {
              for (var i = 0, len = dot_count; i < len; i++) {
                var clone = dot_list_item.cloneNode();
                dot_container.appendChild(clone);
              }
              dot_container.childNodes[0].classList.add('active');
            }
            if (e.type === 'after.lory.init') {
              for (var i = 0, len = dot_count; i < len; i++) {
                dot_container.childNodes[i].addEventListener('click', function(e) {
                  dot_navigation_slider.slideTo(Array.prototype.indexOf.call(dot_container.childNodes, e.target));
                });
              }
            }
            if (e.type === 'after.lory.slide') {
              for (var i = 0, len = dot_container.childNodes.length; i < len; i++) {
                dot_container.childNodes[i].classList.remove('active');
              }
              dot_container.childNodes[e.detail.currentSlide - 1].classList.add('active');
            }
            if (e.type === 'on.lory.resize') {
                for (var i = 0, len = dot_container.childNodes.length; i < len; i++) {
                    dot_container.childNodes[i].classList.remove('active');
                }
                dot_container.childNodes[0].classList.add('active');
            }
        }
        simple_dots.addEventListener('before.lory.init', handleDotEvent);
        simple_dots.addEventListener('after.lory.init', handleDotEvent);
        simple_dots.addEventListener('after.lory.slide', handleDotEvent);
        simple_dots.addEventListener('on.lory.resize', handleDotEvent);

        var dot_navigation_slider = lory(simple_dots, {
            infinite: 1,
            enableMouseEvents: true
        });
    }
}


buildLoryCarousel( document.querySelector('.module') );
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
    });
    
    masonryDom.classList.remove('basic'); 
    masonryLive = true;     
    
}
/** JS Code for the Header / Menu **/

var screenWidth = Math.max(document.documentElement.clientWidth, window.innerWidth || 0),
    headerHeight;

jQuery(document).ready(function($) {
    
    /**
     * Header & Search Bar variables
     **/
    
    var body                    = $( 'body' ),
                
        //Header search bar
        headerSearchWrap        = $( "#header-search" ),
        headerSearchForm        = $( "#header-search form" ),
        headerSearchInput       = $( "#header-search-input" ),
        headerSearchButton      = $( "#search-button" ), 
        
        mainSearchInput         = $( "#main-search-input" ), 
        
        mainNavigation          = $( "#site-navigation" ), 
        burger                  = $( "#burger .trig" );
    
    
    
    /** 
     * Menu search bar
     **/ 
    
    if(headerSearchInput.length > 0){   
    
        //Link search boxes if on search page
        if(mainSearchInput.length > 0){ 
            syncTextInputElements ( 'main-search-input', 'header-search-input' );
        }
        
        headerSearchButton.on("click tap" , function(e){
            if( headerSearchWrap.hasClass('active') ){
                //Check if search bar has text
                var headerSearchText = $(headerSearchInput).val();
                if ( headerSearchText.length > 0 ){
                    $( headerSearchForm ).submit();
                } else {
                    closeHeaderSearch();
                }
            } else {
                openHeaderSearch();
            }
        });
                
        //Reset menu & search on click outside of menu
        $(document).on("click tap" , function(e){
            // if the target of the click isn't the container nor a descendant of the container
            if ( !headerSearchWrap.is(e.target) && headerSearchWrap.has(e.target).length === 0 ){
                closeHeaderSearch();
            }
        });
        
        function openHeaderSearch(){
            headerSearchWrap.addClass('active');
            headerSearchInput.focus();
            mainNavigation.addClass('search');
        }
        
        function closeHeaderSearch(){
            headerSearchWrap.removeClass('active');
            mainNavigation.removeClass('search');
        }
        
    }
    
    
    /** 
     * Menu 
     **/ 
    burger.on("click tap" , function(e){
        toggle_menu();
    });
    
    //Reset menu on click outside of menu
    $(document).mouseup(function(e) {
        // if the target of the click isn't the container. burger icon nor a descendant of the container
        if (!mainNavigation.is(e.target) && mainNavigation.has(e.target).length === 0 && !burger.is(e.target) ){
            deactivate_menu();
        }
    });
    
    function toggle_menu(){
        body.toggleClass('navigation-open');
    }
    
    function deactivate_menu(){
        body.removeClass('navigation-open');
    }
                    
});

/**
 * This file allows us to add parralax to elements within the DOM easily
 **/

//Include script
//https://github.com/dixonandmoe/rellax

(function(h,f){"function"===typeof define&&define.amd?define([],f):"object"===typeof module&&module.exports?module.exports=f():h.Rellax=f()})(this,function(){var h=function(f,l){var b=Object.create(h.prototype),g=0,k=0,c=[],p=!1,u=window.requestAnimationFrame||window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.msRequestAnimationFrame||window.oRequestAnimationFrame||function(a){setTimeout(a,1E3/60)},m=function(a,b,d){return a<=b?b:a>=d?d:a};b.options={speed:-2,center:!1};l&&
Object.keys(l).forEach(function(a){b.options[a]=l[a]});b.options.speed=m(b.options.speed,-10,10);f||(f=".rellax");var q=document.querySelectorAll(f);if(0<q.length)b.elems=q;else throw Error("The elements you're trying to select don't exist.");var v=function(a){var e=a.getAttribute("data-rellax-percentage"),d=a.getAttribute("data-rellax-speed"),c=e||b.options.center?window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop:0,f=c+a.getBoundingClientRect().top,h=a.clientHeight||
a.offsetHeight||a.scrollHeight,g=e?e:(c-f+k)/(h+k);b.options.center&&(g=.5);c=d?m(d,-10,10):b.options.speed;if(e||b.options.center)c=m(d||b.options.speed,-5,5);e=Math.round(100*c*(1-g));a=a.style.cssText;d="";0<=a.indexOf("transform")&&(d=a.indexOf("transform"),d=a.slice(d),d=(g=d.indexOf(";"))?" "+d.slice(11,g).replace(/\s/g,""):" "+d.slice(11).replace(/\s/g,""));return{base:e,top:f,height:h,speed:c,style:a,transform:d}},r=function(){var a=g;g=void 0!==window.pageYOffset?window.pageYOffset:(document.documentElement||
document.body.parentNode||document.body).scrollTop;return a!=g?!0:!1},t=function(){r()&&!1===p&&n();u(t)},n=function(){for(var a=0;a<b.elems.length;a++){var e=" translate3d(0,"+(Math.round(100*c[a].speed*(1-(g-c[a].top+k)/(c[a].height+k)))-c[a].base)+"px,0)"+c[a].transform;b.elems[a].style.cssText=c[a].style+"-webkit-transform:"+e+";-moz-transform:"+e+";transform:"+e+";"}};b.destroy=function(){for(var a=0;a<b.elems.length;a++)b.elems[a].style.cssText=c[a].style;p=!0};(function(){k=window.innerHeight;
r();for(var a=0;a<b.elems.length;a++){var e=v(b.elems[a]);c.push(e)}window.addEventListener("resize",function(){n()});t();n()})();return b};return h});

//Start custom code

if(document.querySelector('.rellax')){
    var rellax = new Rellax('.rellax');
}
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
jQuery(document).ready(function($) {
    $(".toggle-list .toggle").on("click tap touchstart" , function(e){
        e.preventDefault();
        $(this).closest("li").toggleClass("open").find("ul").first().slideToggle();
    });
});