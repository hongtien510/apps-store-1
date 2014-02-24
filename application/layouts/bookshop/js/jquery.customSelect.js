$(document).ready(function(){
	if (!jQuery.browser.opera) {
	
		// select element styling
		jQuery('select.select').each(function(){
			var title = jQuery(this).attr('title');
			if( jQuery('option:selected', this).val() != ''  ) title = jQuery('option:selected',this).text();
			jQuery(this)
				.css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
				.after('<span class="styled-select">' + title + '</span>')
				.change(function(){
					val = jQuery('option:selected',this).text();
					jQuery(this).next().text(val);
	                
					})
		});
	
	};	
});
