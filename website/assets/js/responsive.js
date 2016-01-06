(function($) {

		var view 		= '';
		
		function resizer() {
	        if (($(window).width() <= 991)) { // Mobile
				$('.content').css('padding', '1% 0');
				$('.header .slogan').css('height', 'auto');
		    }
		    else { // Normal
				$('.content').css('padding', ($('.header').height() + 15) + 'px 0 1% 0');
				$('.header .slogan').css('height', ($('.header').height()) + 'px');
		    }
	        
			//$("#debuginfo").html("<span>Ancho "+$(window).width()+"</span><br /><span>Alto "+$(window).height()+"</span><br /><span>"+view+"</span><br />");
	    };
		
	    // Call on resize.
	    $(window).on('resize', resizer);

		// Call on load
	    $(window).on('load', resizer);
})(jQuery);