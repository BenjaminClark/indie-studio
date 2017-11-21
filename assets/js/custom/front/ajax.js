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