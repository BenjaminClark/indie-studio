jQuery(document).ready(function($) {
 
    var ajaxUrl             = indie_studio_ajax.ajax_url,
        cookieReset         = false;
    
    /**
     * General GET AJAX
     * 
     * Pass -   data        : action and data
     *      -   firstFunct  : function run before send
     *      -   passer      : where the response is passed
     **/
    
    function getPhpAjax(data, dateType, firstFunc, passer) {
        
        $.ajax({
            type       : "GET",
            url        : ajaxUrl,
            dataType   : dataType,
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
    
    /** This resets the cookie notification by increasing the notification version **/
    
    function cookie_reset_pre(response){
        $("#indie_studio-reset-notification-error").removeClass('show');
        $("#indie_studio_reset_notification_cookie").text('Updating Cookie...');
        $("#indie_studio_reset_notification_cookie").addClass('updating');
    }
    
    function cookie_reset_post(response){
        
        console.log(response);
        
        $("#indie_studio-reset-notification-cookie").addClass('disabled'); 
        
        if(response){
            //Update Worked
            $("#indie_studio-reset-notification-cookie").text('Cookie Updated');
            $("#indie_studio-reset-notification-cookie").removeClass('updating');
            $("#indie_studio-reset-notification-cookie").removeClass('disabled');
            
            //Stop from being reset on this session again
            cookieReset = true;
            
        } else {
            //Update did not work
            $("#indie_studio-reset-notification-error").addClass('show');
            
            setTimeout(function(){ 
                $("#indie_studio-reset-notification-cookie").text('Reset Cookies');
                $("#indie_studio-reset-notification-cookie").removeClass('disabled'); 
            }, 2000);
            
        }
    }
    
    if ( $("#indie_studio-reset-notification-cookie").length > 0 ) {
                
        $( "#indie_studio-reset-notification-cookie" ).click(function() {
                
            if ( !cookieReset ){
                var data = {
                    action      : 'indie_studio_update_notification_version_ajax',
                };
                getPhpAjax(data, 'json', cookie_reset_pre, cookie_reset_post);
            }
            
        });
    
    }
        
});