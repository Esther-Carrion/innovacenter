/* global tinymce */
tinymce.PluginManager.add('wpytplayer', function( editor ) {

	setTimeout(function(){
		if(!tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden() ){
			jQuery("#add-ytplayer").css("opacity",.5);
		} else {
			jQuery("#add-ytplayer").css("opacity",1);
		}
	},400);

	function replaceytplayershortcodes( content ) {
		return content.replace( /\[mbYTPlayer([^\]]*)\]/g, function( match ) {
			return html( 'wp-ytplayer', match );
		});
	}

	function html( cls, data ) {

		var dataObj =JSON.stringify(wp.shortcode.attrs( data).named);
		data = window.encodeURIComponent( data );
   // var ytp_site_url = ytp_site_url || "";
		return '<img src="' + ytp_site_url + '/wp-content/plugins/wp-ytplayer-plus/images/ytplayershortcode.png" class="mceItem ' + cls + '" ' +
				'data-wp-ytplayer="' + data + '" data-mce-resize="false" data-mce-placeholder="1" alt="" data-ytp-obj=\''+dataObj+'\' />';
	}

	function restoreytplayershortcode( content ) {
		function getAttr( str, name ) {
			name = new RegExp( name + '=\"([^\"]+)\"' ).exec( str );
			return name ? window.decodeURIComponent( name[1] ) : '';
		}

		return content.replace( /(?:<p(?: [^>]+)?>)*(<img [^>]+>)(?:<\/p>)*/g, function( match, image ) {
			var data = getAttr( image, 'data-wp-ytplayer' );

			if ( data ) {
				return data ;
//				return  "<p>" + data + "</p>";
			}

			return match;
		});
	}

	editor.on( 'click', function( event ) {
		node = event.target;

		if(jQuery(node).is("[data-ytp-obj]")) {
			jQuery(node).select();
			setTimeout(show_ytplayer_editor,400);
		}

	});

	editor.on( 'mouseover', function( event ) {
		node = event.target;
		if(jQuery(node).is("[data-ytp-obj]")) {
			jQuery(node).css({cursor:"pointer"})
		}
	});

	editor.on( 'BeforeSetContent', function( event ) {
		event.content = replaceytplayershortcodes( event.content );
		if ( ! editor.plugins.wpview || typeof wp === 'undefined' || ! wp.mce ) {
			event.content = replaceytplayershortcodes( event.content );
		}
	});

	editor.on( 'PostProcess', function( event ) {
		if ( event.get ) {
			event.content = restoreytplayershortcode( event.content );
		}
	});
});


