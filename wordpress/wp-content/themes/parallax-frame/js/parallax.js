jQuery(function( $ ){

	// Enable parallax and fade effects on homepage sections
	$(window).on( 'scroll',function(){

		scrolltop = $(window).scrollTop()
		scrollwindow = scrolltop + $(window).height();

		$(".parallax-effect").css("backgroundPosition", "50% " + -(scrolltop/6) + "px");

		if ( $("#featured-content").length ) {
		
			sectionthreeoffset = $("#featured-content").offset().top;		  

			if( scrollwindow > sectionthreeoffset ) {

				// Enable parallax effect
				backgroundscroll = scrollwindow - sectionthreeoffset;
				$("#featured-content").css("backgroundPosition", "50% " + -(backgroundscroll/6) + "px");

			}
		
		}

		if ( $("#supplementary").length ) {
		
			sectionfiveoffset = $("#supplementary").offset().top;		  

			if( scrollwindow > sectionfiveoffset ) {

				// Enable parallax effect
				backgroundscroll = scrollwindow - sectionfiveoffset;
				$("#supplementary").css("backgroundPosition", "50% " + -(backgroundscroll/6) + "px");

			}
		
		}

	});

});
