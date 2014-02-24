var Products = (function() {
	// PARAMATER
	var setting = {
		slider	: 	'.slider-details .content-slider',
		w		:	182,
		count	:	3,
		total	:	6
	}
	
	// INIT
	function init(){	
		
		initParamaters();
		initCSS();
		initEvents();
	}
	
	function initCSS(){
		$(setting.slider).width( $(setting.slider + ' .p-item').length * setting.w) ;
	}
	
	function initParamaters(){
		setting.total = $(setting.slider + ' .p-item').length;
		gotoSlider(0);
	}
	
	function initEvents(){
		$('.next').click(function(e) {
            nextSlider();
        });
		
		$('.prev').click(function(e) {
            prevSlider();
        });
		
	}

	// SLIDER
		
	function nextSlider(){
		setting.count++;
		animateSlider();
	}
	
	function prevSlider(){
		setting.count--;
		animateSlider();		
	}
	
	
	function gotoSlider(index){
		setting.count = index + 1;
		
		animateSlider();		
	}
	
	function checkCounter(){
		
		if(setting.count > setting.total)
			setting.count = setting.total;		
		
		if(setting.count < 1)
			setting.count = 1;
		if(setting.total - 3 <= setting.count)
			setting.count = setting.total - 3;
	}
	
	function animateSlider(){			
		checkCounter();
		setCssSlider();
		$(setting.slider).stop(true,false).animate({'left':-(setting.w)*(setting.count-1)}, 500);		
	}
	
	function setCssSlider(){
		// set paging
		//$('ul.paging li').removeClass('active');
		//$('ul.paging li:eq('+ (setting.count-1) +')').addClass('active');
		
		// buttons 
		if(setting.count == 1){
			$('.prev').addClass('undisplay');
			$('.next').removeClass('undisplay');
		}
		else if(setting.count == setting.total){
			$('.next').addClass('undisplay');
			$('.prev').removeClass('undisplay');
		}
		else if(setting.total - 3 < setting.count){
			//console.log(setting.count);
			$('.next').addClass('undisplay');
		}
		else{
			$('.prev, .next').removeClass('undisplay');
		}		
	}
	
	//RETURN
	return {
		init:init
	}

})();
