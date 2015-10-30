jQuery(document).ready(function($){
	
	// Tabs shortcode
	var $tabs = $('.tabs');
	
	if ( $tabs.length ) {
	
		$tabs.tabs({});
	
	}
	
	// jQuery UI Accordion
	var $accordion = $('.accordion');
	
	var $accordion_collapsible = $('.accordion_collapsible');
	
	if ( $accordion.length ) {
	
		$accordion.accordion({
			autoHeight: false,
			collapsible: false
		});
		
	}
		
	if ( $accordion_collapsible.length ) {
	
		$accordion_collapsible.accordion({
			autoHeight: false,
			collapsible: true,
			active: false
		});
		
	}

});
