/* On top */

window.onscroll = function() {
    scrollFunction()
};

function scrollFunction() {

    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        document.getElementById("sol-presup").style.display = "block"
    } else {
        document.getElementById("sol-presup").style.display = "none"
    }
}


/* MEnu fixed  */

jQuery(document).ready(function () {
  
    'use strict';  
    var c, currentScrollTop = 0,
    navbar = jQuery('nav');
  
jQuery(window).scroll(function () {    

    if (document.body.scrollTop > 600 || document.documentElement.scrollTop > 600) {
            
            jQuery('body').addClass("padd");
            jQuery('body').removeClass("no-padd");
          
    } else {
            navbar.removeClass("scrollDown");
            jQuery('body').removeClass("padd");
            jQuery('body').addClass("no-padd");
    }
    
    var a = jQuery(window).scrollTop();
    var b = navbar.height();
    currentScrollTop = a;   
        
        if (c+5 < currentScrollTop && a > b + b) {   
            if(jQuery('body').hasClass( "padd" )){
                navbar.removeClass("scrollDown");
                //console.log( c +" < "+ a +" y "+ a +" > "+ b+b);
            }            
        } else if (c > currentScrollTop && !(a <= b)) { 
            if(jQuery('body').hasClass( "padd" )){
                if (document.body.scrollTop > 700 || document.documentElement.scrollTop > 700) {
                    navbar.addClass("scrollDown");
                } else {
                    navbar.removeClass("scrollDown");
                }
            }
        }
        c = currentScrollTop; 
    });
});