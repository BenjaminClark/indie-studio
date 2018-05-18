/**
 * Check if the device has touch or not
 * 
 * If so, 
 * remove "no-touch" from body classes
 * fire "isTouchDevice" event
 **/ 

window.addEventListener('touchstart', function onFirstTouch(){
    document.body.classList.remove("no-touch");
    document.dispatchEvent(new CustomEvent('isTouchDevice'));
    window.removeEventListener('touchstart', onFirstTouch, false);
});