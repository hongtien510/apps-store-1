var LogoAnimate = (function() {
	// PARAMATER
	// INIT
	function init(){	
		onHoverLogo();
		onOutLogo();
	}
	function onHoverLogo(){
		$('.header .h-right a').mouseover(function(){
			var link = $('img.h-right-1').attr('link_image');
			var i = 1;
			setInterval(function() {
				i++;
				
		       	if(i<=7){
					
		       		$('img.h-right-1').attr('src',link +'images/bg-right-'+i+'.jpg');
		       		if(i==7){
		       			$('img.h-right-1').addClass('h-right-7');
		       		}
		       	}
		       	else{
		       		if(i==7){
						$('img.h-right-1').attr('src',link +'images/bg-right-7.jpg');
		       		}
		       	}
    		},100);
		});
		
	}
	function onOutLogo(){
		$('.header .h-right a').mouseout(function(){
			var parent = $(this).parent();
				var link = $('img.h-right-1').attr('link_image');
			var i = 7;
			var j = 0;
			setInterval(function() {
				i--;
		       	if(i>=1){
		       		$('img.h-right-1').removeClass('h-right-7').addClass();
		       		$('img.h-right-1').attr('src',link +'images/bg-right-'+i+'.jpg');
		       		
		       	}
		       	else{
		       		if(i==1){
		       			$('img.h-right-1').attr('src',link +'images/bg-right-1.jpg');
		       		}
		       	}
    		},70);
			
		});
		
	}
	//RETURN
	return {
		init:init,
		onHoverLogo:onHoverLogo,
		onOutLogo:onOutLogo
	}

})();
