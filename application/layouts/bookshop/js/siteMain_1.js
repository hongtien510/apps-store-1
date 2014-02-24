
$(document).ready(function(){  
	
    
 
    //$('#sort-select').customSelect();
	
   //menu
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
    
    $('.light-box-big').click(function(){
    	var src = $(this).attr('href');
    	var title = $('#title-product-name-details').text();
    	$('.images-lightbox .box-image img').attr('src',src);
    	$('.images-lightbox .images-container .title').html(title);
    	$('.images-lightbox').fadeIn(300);
    	return false;
    });
    $('.images-lightbox .box-image').click(function(e){
		e.stopPropagation();
	});
	$("body, a.close").click(function(){
		$('.images-lightbox').fadeOut(300);
	});
	
	//set top addcart
	$('.product .p-item .bg-name').each(function(){
		var parent = $(this).parent();
		$(parent).find('a.addcart').css('bottom',$(this).height()+"px");	
	});
	
});

