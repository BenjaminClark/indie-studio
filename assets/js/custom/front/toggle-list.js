jQuery(document).ready(function($) {
    $(".toggle-list .toggle").on("click tap touchstart" , function(e){
        e.preventDefault();
        $(this).closest("li").toggleClass("open").find("ul").first().slideToggle();
    });
});