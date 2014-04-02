 
 $(window).load(function(){
	 $('ul.sliders-wrap-inner li img.example-image').load(function(){
	 	var widthRealy = $('ul.sliders-wrap-inner li .zoomPup img').width();
	 	console.log(widthRealy);	
	 });
});
$(window).load(function(){
	
	$('.sidebar ul li ul li').each(function(){
		if($(this).hasClass('active')){
			$(this).parent().parent('li').addClass('active');
		}
	});
	
	$('.product .p-item img').each(function(){
	 	//alert($(this).width());
	 	//$(this).css('left', (202-$(this).width())/2 +'px');
	 });
	 $('ul.sliders-wrap-inner li img.example-image').each(function(){
	 	var left = ((257-$(this).width())/2);
	 	$('ul.sliders-wrap-inner li .zoomPad').css('left', left + "px");
	 });
	$('.main-content .sort select.select option').each(function(){
		if($(this).attr('select') == 'select'){
			$('.sort .styled-select').html($(this).text());
		}
	});
	$('.other-products .slider-details .p-item img').each(function(){
	 
	 	//$(this).css('left', (170-$(this).width())/2 +'px');
	 });
	
	 
});


$(document).ready(function(){  
	//console.log($('ul.sliders-wrap-inner li img.example-image').width());
	$('ul.sliders-wrap-inner li .zoomPup img').css('width', $('ul.sliders-wrap-inner li img.example-image').width() +'px')
	var imgWidthDetail = $('ul.sliders-wrap-inner li img.example-image').width(); 
	var imgHeightDetail = $('ul.sliders-wrap-inner li img.example-image').height();
	//alert(imgWidthDetail);
	if(imgWidthDetail > 255){
		
	}
	$('.jqzoom').jqzoom({
        zoomType: 'reverse',
        lens:true,
        preloadImages: false,
        alwaysOn:false
    });
	//set height sidebar
	$('.sidebar').css('height',$('.main-content').height()+60+'px');
	
       LogoAnimate.init();
 
 
 
 //sort style
 	
 
    //$('#sort-select').customSelect();
	
   //menu
   $('.sidebar ul li ul').hide();
   $('.sidebar ul li').mouseover(function(){
   		$('.sidebar ul li ul').hide();
   		$(this).find('ul').show();
   });
   $('.sidebar ul li ul').mouseout(function(){
   		$('.sidebar ul li ul').hide();
   });
   //search
   $('.cart-icon-right .search-icon').click(function(){
   		$('.search-content').toggle();
        $('.search-content input').focus();
   		return false;
   });
   
    var bottom_of_object = $('.header').position().top + $('.header').outerHeight();
    var bottom_of_window = $(window).scrollTop() + $(window).height();
     var top = $('.header').offset().top - parseFloat($('.header').css('marginTop').replace(/auto/, 0));
	  $(window).scroll(function (event) {
	    // what the y position of the scroll is
	    var y = $(this).scrollTop();
	
	    // whether that's below the form
	    if (y >= top) {
	      // if so, ad the fixed class
	      // $('.header').addClass('setfixed');
	       $('.sidebar').addClass('setfixed');
	    } else {
	      // otherwise remove it
	      //$('.header').removeClass('setfixed');
	       $('.sidebar').removeClass('setfixed');
	    }
	  });
   //scroll to top
   $(window).scroll(function(){
		if($(this).scrollTop() >= 250){
			$('.gotoTop').fadeIn();
		}
		else{
			$('.gotoTop').fadeOut();
		}
	});
	$('.gotoTop').click(function(){
	    $("html, body").animate({ scrollTop: 0 }, 600);
	    return false;
    });
    //lightbox
    
    $('.bd-around img.example-image').mousemove(function(e){
    	var src = $(this).parent().attr('href');		
    	$('.tooltip_image_big .box-image-big img').attr('src',src);
    	$('.tooltip_image_big').css({left:e.pageX+10, top:e.pageY+10}).show();
    	return false;
    });
    $('.bd-around img.example-image').mouseout(function(){
    	//var src = $(this).find('.light-box-big').attr('href');		
    	$('.tooltip_image_big .box-image-big img').removeAttr('src');
   		$('.tooltip_image_big').hide();
   });
   	//set top addcart
	$('.product .p-item .bg-name').each(function(){
		var parent = $(this).parent();
		$(parent).find('a.addcart').css('bottom',$(this).height()+"px");	
	});
	
});

