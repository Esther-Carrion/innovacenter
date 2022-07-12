 /*
 * Custom scripts
 * Description: Custom scripts for parallaxframe
 */

jQuery(document).ready(function() {
	var jQueryheader_search = jQuery( '#search-toggle' );
	jQueryheader_search.on( 'click', function() {

		var jQueryform_search = jQuery("div").find( '#search-container' );

		if ( jQueryform_search.hasClass( 'displaynone' ) ) {
			jQueryform_search.removeClass( 'displaynone' ).addClass( 'displayblock' ).animate( { opacity : 1 }, 300 );
		} else {
			jQueryform_search.removeClass( 'displayblock' ).addClass( 'displaynone' ).animate( { opacity : 0 }, 300 );
		}
	});

	//Fit vids
	if ( jQuery.isFunction( jQuery.fn.fitVids ) ) {
		jQuery('.hentry, .widget').fitVids();
	}

	//sidr
	if ( jQuery.isFunction( jQuery.fn.sidr ) ) {
		jQuery('#mobile-header-left-menu').sidr({
		   name: 'mobile-header-left-nav',
		   side: 'left' // By default
		});
		jQuery('#mobile-header-right-menu').sidr({
		   name: 'mobile-header-right-nav',
		   side: 'right' // By default
		});
	}
});

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

		// Add header-background class in #masthead for fixed header.
		if (jQuery(this).scrollTop() > 100) {
			jQuery('#masthead').addClass('header-background');
		} else {
			jQuery('#masthead').removeClass('header-background');
		}

	});

});
