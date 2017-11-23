/**
 * This file holds the Google Analytics and the
 * custom error message functions.
 * 
 * If any other logging is required, it should be included in
 * this file.
 **/ 

var allowDebug          = theme_script_ajax.ajax_url;

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