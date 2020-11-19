jQuery(window).scroll(function() {
    var nav = jQuery('.navbar');
    var top = 200;
    if (jQuery(window).scrollTop() >= top) {
        if(pageId ==325 || pageId==357 || pageId==359 || pageId==323){
            nav.removeClass('darkMode');
        }
        nav.addClass('purpleBg');

    } else {
        nav.removeClass('purpleBg');
        if(pageId ==325 || pageId==357 || pageId==359 || pageId==323){
            nav.addClass('darkMode');
        }
    }
});

console.log("page ID"+pageId);
if(pageId !== undefined && pageId) {
 console.log(pageId);
}
