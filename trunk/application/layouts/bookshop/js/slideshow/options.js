$(document).ready( function(){	
		var buttons = { previous:$('#jslidernews2 .button-previous') ,
						next:$('#jslidernews2 .button-next') };		
			$('#jslidernews2').lofJSidernews( { interval:	3500,
											 	easing:'easeInOutQuad',
												duration:900,
												auto:false,
												mainWidth:257,
												mainHeight:305,
												navigatorHeight		: 62,
												navigatorWidth		: 62,
												maxItemDisplay:4,
												buttons:buttons } );
			
		
	});
