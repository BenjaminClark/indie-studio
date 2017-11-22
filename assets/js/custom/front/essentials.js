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