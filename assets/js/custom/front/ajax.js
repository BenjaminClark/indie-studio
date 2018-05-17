//Contains the elements that are currently loading
var ajaxLoadingAnimationActive = [];


/**
 * General GET AJAX
 * 
 * Pass -   data        : action and data
 *      -   firstFunct  : function run before send
 *      -   passer      : where the response is passed
 **/

function postPhpAjax(data, dateType, firstFunc, passer) {

    data.security = theme_script_ajax.security;

    jQuery.ajax({
       url: theme_script_ajax.ajax_url,
       data: data,
       dataType: dateType,
       beforeSend: function(){
            if(firstFunc){
                firstFunc();
            } 
       },
       success: function(response) {
            if(passer){
                //Pass response to specified function 
                passer(response);
            }
       },
       type: 'POST'
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
                fade({el:div,type:'in',duration: 100});
            } 

            if(type == 'append'){
                insertAfter(div, location);
                fade({el:div,type:'in',duration: 100});
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