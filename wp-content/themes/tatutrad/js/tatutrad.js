 var $ = jQuery.noConflict(true);
  
	
  $(document).ready(function() {
		$('html').addClass("animate-in");
    $('html').addClass("in");
    
    $('.overlay .menu a').click(function(event) {
      event.preventDefault();
      newLocation = $(this).attr("href");
      $('body').fadeOut(1000, newpage);
      });

       $('.derecha a').click(function(event) {
      event.preventDefault();
      newLocation = $(this).attr("href");
      $('body').fadeOut(1000, newpage);
      });



    
  
    function newpage() {
      window.location = newLocation;
      }
    });

	$(document).on('ready', function() {
    /* Página Inicio*/
    $(".slider-home").slick({
      dots: false,
      infinite: true,       
      slidesToShow: 1,
      speed: 9000,
      adaptiveHeight: false,
      autoplay: true,
      fade: true,
      arrows: false,
      zIndex:0
      });


		$('.background').css('min-height', $('.cont-main').height()+79);

    
      $( window ).resize(function() {
          $('.background').css('min-height', $('.cont-main').height());
        });

      $('.enlaces .izquierda a').click(function(){
        $('html, body').animate({
          scrollTop: $( $(this).attr('href') ).offset().top
        }, 2000);
        return false;
        });


      $('.subir-top a').click(function(){
        $('html, body').animate({
          scrollTop: 0
        }, 2000);
        return false;
        });




    /* fin página inicio*/

    /* SERVICIOS */
    
    $(".regular").slick({
      dots: true,
      infinite: true,
      autoplay: false,
      appendDots:$('.pag'),
      arrows: false,
      slidesToShow: 1,
      customPaging : function(slider, i) {
      var text = $(slider.$slides[i]).data('text');
      return '<a>'+text+'</a>';
        },
        adaptiveHeight: true
      });


 
    /* inicializacion */

    pestanaActiva=false;
    $('.page-template-servicios .pestana').css('position', 'absolute');
    $('.page-template-servicios .pestana').css('visibility', 'hidden');
    $('.page-template-servicios .pestana').css('top', $('#main').outerHeight());
    $('.page-template-servicios .slick-dots li').removeClass("slick-active");

    $(window).on('load', function() {
    autoHeight = $(".pres").outerHeight();
    enlacesHeight = $(".enlaces-servicios").outerHeight();

pestanaTop=$(".principal").height()-$(".pres").height()-$(".enlaces-servicios").height()+2;
});

   

    $('.enlaces-servicios .izquierda a').click(function() {
    pestanaActiva=true;

    $(".page-template-servicios #slick-slide00").addClass("slick-active");
            
      $(".pres").animate({ height: 0, opacity: 0,  }, 'slow', function(){
        $('.pres').css('overflow', 'hidden');
        });
     $("body.page-template-servicios .enlaces-servicios").animate({ height: 0, opacity: 0,  }, 'slow', function(){
        $('body.page-template-servicios .enlaces-servicios').css('overflow', 'hidden');

        });
        
      $('.pestana').css('visibility', 'visible');    

      $(".pestana").animate({ 
        top: pestanaTop,
          }, 1000 );


   
        
 
      alturaCurrentPestana=$('.page-template-servicios .slick-track .slick-current').outerHeight();

      heightMain=alturaCurrentPestana+pestanaTop+80;

      $("#main").animate({ 
        height: heightMain,
          }, 1000 );

      
      if ( alturaCurrentPestana+$('.principal').height()-enlacesHeight > $(window).height()){             
      }else{
        $('.pestana').css('min-height', $(window).height()-$('.principal').height()+$('.pres').height()+enlacesHeight);
      }
});

$( window ).resize(function() {
   alturaCurrentPestana=$('.page-template-servicios .slick-track .slick-current').outerHeight();

      heightMain=alturaCurrentPestana+pestanaTop+80;
  if ( alturaCurrentPestana+$('.principal').height()-enlacesHeight > $(window).height()){             
      }else{
        $('.pestana').css('min-height', $(window).height()-$('.principal').height()+$('.pres').height()+enlacesHeight);
      }
});


    $('.regular').on('beforeChange', function(event, slick, currentSlide, nextSlide){
      pestanaActiva=true;
            
      $(".pres").animate({ height: 0, opacity: 0,  }, 'slow', function(){
        $('.pres').css('overflow', 'hidden');
        });
     $("body.page-template-servicios .enlaces-servicios").animate({ height: 0, opacity: 0,  }, 'slow', function(){
        $('body.page-template-servicios .enlaces-servicios').css('overflow', 'hidden');

        });
        
      $('.pestana').css('visibility', 'visible');    

      $(".pestana").animate({ 
        top: pestanaTop,
          }, 1000 );


   
        
 
      alturaCurrentPestana=$('.page-template-servicios .slick-track .slick-slide:nth-child('+ (nextSlide +2 )+')').height();

      heightMain=alturaCurrentPestana+pestanaTop+80;
      $("#main").animate({ 
        height: heightMain,
          }, 1000 );

      
      if ( alturaCurrentPestana+$('.principal').height()-enlacesHeight > $(window).height()){             
      }else{
        $('.pestana').css('min-height', $(window).height()-$('.principal').height()+$('.pres').height()+enlacesHeight);
      }

     
    });

    


  
    $(window).click(function() {

      if (pestanaActiva) { 
        $(".pestana").animate({ 
         top: $("#main").outerHeight(),
         }, 500, function(){
        $('.pestana').css('visibility', 'hidden');
        });
      }


      $(".pres").animate({  opacity: 1, height: autoHeight, }, 1000, function(){  
        $('.pres').css('height', 'auto');  
      });
 

$("body.page-template-servicios .enlaces-servicios").animate({  opacity: 1, height: enlacesHeight, }, 1000, function(){  
        $('body.page-template-servicios .enlaces-servicios').css('height', 'auto');  
      });


$( ".page-template-servicios .slick-active" ).removeClass(".page-template-servicios slick-active");

      pestanaActiva=false;

    });

    $('.pag').click(function(event){
      event.stopPropagation();
    });
    $('.pestana').click(function(event){
      event.stopPropagation();
    }); 
    $('.enlaces-servicios').click(function(event){
      event.stopPropagation();
    });  

$('#trigger-overlay').click(function(event){
      event.stopPropagation();
    });
   
     
  });

  /* Como trabajamos*/

  $(".pasos").slick({
    dots: true,
    infinite: false,
    autoplay: true,
      speed: 1000,
       autoplaySpeed: 6000,
       autoplay: true,
    arrows: false,
     appendDots:$('.como'),
    adaptiveHeight: true
  });