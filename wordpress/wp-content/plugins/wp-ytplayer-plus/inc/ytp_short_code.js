var selection = null;
jQuery(function () {
  jQuery(".wp-editor-tabs button").on("click.ytpl", function () {
    setTimeout(function () {
      if (!tinyMCE.activeEditor || tinyMCE.activeEditor.isHidden()) {
        jQuery("#add-ytplayer").css("opacity", .5);
      } else {
        jQuery("#add-ytplayer").css("opacity", 1);
      }
    }, 400)
  })
});

var isFromGutemberg = false;

function show_ytplayer_editor(isGutemberg) {

  jQuery('#ytplayer-form form')[0].reset();
  jQuery("body").css({overflow: "hidden"});
  jQuery("#ytplayer-form").slideDown(300);
  jQuery("#shorcode-form").scrollTop(0);
  isFromGutemberg = isGutemberg;

  if(!isGutemberg){

    /* todo: test if that works
			if (tinyMCE.activeEditor == null || tinyMCE.activeEditor.isHidden() != false) {
				alert("You should switch to the visual editor");
				return;
			}
		*/

    selection = tinyMCE.activeEditor.selection.getContent();

    if (selection.trim().length)
      selection = wp.shortcode.attrs(selection).named;

  } else {
    let dataShortcode = ytp_data.attributes.ytp_shortcode || "[]";
    console.debug("dataShortcode", dataShortcode );
    let dataObj =JSON.stringify(wp.shortcode.attrs(dataShortcode).named);
    selection = JSON.parse(dataObj);
  }
  set_youtube_parameters(selection);
}

function set_youtube_parameters(obj) {

  console.debug(obj);

  for (var key in obj) {
    console.debug("key", key);
    var field = jQuery("#ytplayer-form [name=" + key + "]");

    console.debug("field: ","#ytplayer-form [name=" + key + "]", field.length);

    if (field.is("input[type=checkbox]") && obj[key] != "false") {
       console.debug(key, obj[key]);
      field.attr("checked", "checked");
    } else if (field.is("input[type=checkbox]") && obj[key] == "false") {
      field.removeAttr("checked");
    }

    if (field.is("input[type=text]") || field.is("input[type=number]"))
      field.val(obj[key]);

    if (field.is("textarea"))
      field.val(obj[key]);

    if (field.is("select"))
      jQuery("option[value='" + obj[key] + "']").attr("selected", "selected");
  }
  showControlBox();
  showAnchor();
  setAnchorImage(jQuery("[name=anchor]").val());
  printVideos();
}

function hide_ytplayer_editor() {
  jQuery("#ytplayer-form").slideUp(300);
  jQuery("body").css({overflow: "auto"});
  jQuery("#videos").html("");
}

jQuery("body").on("click", "#ytplayer-form", function (e) {
  var target = e.originalEvent.target;
  if (jQuery(target).parents().is("#ytplayer-form"))
    return;
  hide_ytplayer_editor();
});

function isInline() {
  var inlineBox = jQuery('#ytplayer-form #inlinePlayer');
  if (!jQuery("#ytplayer-form [name=isinline]").is(":checked")) {
    inlineBox.slideUp();
  } else {
    inlineBox.slideDown();
    jQuery("#ytplayer-form [name=showcontrols]").attr("checked", "checked");
    jQuery("#ytplayer-form [name=autoplay]").removeAttr("checked");
  }
  showControlBox();
}

function isElement() {
  var inlineBox_check = jQuery('#ytplayer-form #inlinePlayer-checkbox');
  var inlineBox = jQuery('#ytplayer-form #inlinePlayer');
  if (jQuery("#ytplayer-form [name=elementselector]").val().length > 0) {
    inlineBox_check.slideUp();
    jQuery("#ytplayer-form [name=isinline]").removeAttr("checked");
    inlineBox.slideUp();
  } else {
    inlineBox_check.slideDown();
  }
}

function showControlBox() {
  var controlBox = jQuery('#ytplayer-form #controlBox');
  if (!jQuery("#ytplayer-form [name=showcontrols]").is(":checked")) {
    controlBox.slideUp();
  } else {
    controlBox.slideDown();
  }
}

function showAnchor() {
  var anchorBox = jQuery('#ytplayer-form #anchorBox');
  if (!jQuery("#ytplayer-form [name=optimize_display]").is(":checked")) {
    anchorBox.slideUp();
  } else {
    anchorBox.slideDown();
  }
}

function setAnchorImage(val) {
  var image_url = ytp_plugin_dir_url + "images/anchor/" + val + ".jpg";
  jQuery("#anchor_img").css({backgroundImage: "url(" + image_url + ")"})
}

function suggestedHeight() {
  var width = parseFloat(jQuery("#ytplayer-form [name=playerwidth]").val());
  var margin = (width * 10) / 100;
  width = width + margin;
  var ratio = jQuery("#ytplayer-form [name=inLine_ratio]").val();
  var suggestedHeight = "";
  if (width)
    if (ratio == "16/9") {
      suggestedHeight = (width * 9) / 16;
    } else {
      suggestedHeight = (width * 3) / 4;
    }
  jQuery("#ytplayer-form [name=playerheight]").val(Math.floor(suggestedHeight));
}

function check_for_mute() {
  var mute = jQuery("#mute");
  var autoplay = jQuery("#autoplay");
  if (autoplay.is(":checked")) {
    mute.attr("checked", "checked");
  }
}

function getYTPVideoID(url) {
  var videoID, playlistID;
  if (url.indexOf("youtu.be") > 0) {
    videoID = url.substr(url.lastIndexOf("/") + 1, url.length);
    playlistID = videoID.indexOf("?list=") > 0 ? videoID.substr(videoID.lastIndexOf("="), videoID.length) : null;
    videoID = playlistID ? videoID.substr(0, videoID.lastIndexOf("?")) : videoID;
  } else if (url.indexOf("http") > -1) {
    //videoID = url.match( /([\/&]v\/([^&#]*))|([\\?&]v=([^&#]*))/ )[ 1 ];
    videoID = url.match(/[\\?&]v=([^&#]*)/)[1];
    playlistID = url.indexOf("list=") > 0 ? url.match(/[\\?&]list=([^&#]*)/)[1] : null;
  } else {
    videoID = url.length > 15 ? null : url;
    playlistID = videoID ? null : url;
  }
  return {
    videoID   : videoID,
    playlistID: playlistID
  };
}
function printVideos() {

  var ytpl_video_url = jQuery("#ytplayer-form [name=url]").val();

  if (ytpl_video_url.length == 0)
    return;

  var vids = ytpl_video_url.split(',');
  var n = vids.length;
  n = n > 2 ? 2 : n;
  var editor_width = jQuery("#ytplayer-form #editor").width() - 50;
  var w = (editor_width / n) - (n > 1 ? (3 * n) : 0);
  var h = (w / 1.6);
  var text = "";

  for (var i = 0; i < vids.length; i++) {
    var vurl = vids[i];
    var videoId = getYTPVideoID(vurl).videoID;
    if (videoId.length) {
      text += '<iframe width="' + w + '" height="' + h + '" style="display: inline-block" src="https://www.youtube.com/embed/' + videoId + '?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allowfullscreen></iframe>'
    }
  }
	jQuery("#videos").html(text);
}

var ytp_form = jQuery('#ytplayer-form form').get(0),

    isEmpty = function (value) {
      return (/^\s*$/.test(value));
    },

    encodeStr = function (value) {
      return value.replace(/\s/g, "%20")
          .replace(/"/g, "%22")
          .replace(/'/g, "%27")
          .replace(/=/g, "%3D")
          .replace(/\[/g, "%5B")
          .replace(/\]/g, "%5D")
          .replace(/\//g, "%2F");
    };

function insertShortcode() {
  var sc = "[mbYTPlayer",
      inputs = ytp_form.elements,
      input,
      inputName,
      inputValue,
      l = inputs.length, i = 0;

  for (; i < l; i++) {
    input = inputs[i];
    inputName = input.name;
    inputValue = input.value;

    // Video URL validation
    if (inputName == "url" && (isEmpty(inputValue) || ((inputValue.toLowerCase().indexOf("youtube") == -1) && inputValue.toLowerCase().indexOf("youtu.be") == -1))) {
      alert("a valid Youtube video URL is required");
      return false;
    }

    // inputs of type "checkbox", "radio" and "text"
    if (
        ((input.type == "text" || input.type == "textarea") && !isEmpty(inputValue) && inputValue != input.defaultValue)
        || input.type == "select-one"
        || input.type == "checkbox"
        || input.type == "radio"
    ) {

      if (input.type == "checkbox") {
        if (!input.checked)
          inputValue = false;
      }

      if (inputName == "realfullscreen" && !input.checked)
        continue;

      if (inputName == "inLine_ratio")
        continue;

      sc += ' ' + inputName + '="' + inputValue + '"';
    }
  }
  sc += " ]";

  if (isFromGutemberg) {

    let vidsThumbnailURLs = jQuery("#ytplayer-form [name=url]").val();

    function getVidsThumbs(URLs){
      if (!URLs)
        return false;

      let vidsContainer = jQuery( "<div/>");

      vids = URLs.split(",");
      for (let i = 0; i < vids.length; i++) {
        let videoId = getYTPVideoID(vids[i]).videoID;
        let coverImageURL = "https://img.youtube.com/vi/"+videoId+"/2.jpg";
        vidsContainer.append( jQuery("<img/>").attr({src : coverImageURL}).css({width: (100/vids.length) + "%"}) )
      }
      return vidsContainer.html();
    }

    sc = sc.replace(/"/g,"'");
    ytp_data.attributes.ytp_shortcode = sc;
    ytp_data.attributes.ytp_urls = vidsThumbnailURLs;
    ytp_data.attributes.ytp_containment = jQuery("#ytplayer-form [name=elementselector]").val();

    jQuery("#YTPL-vidThumbsContainer").html(getVidsThumbs(ytp_data.attributes.ytp_urls));
    jQuery("#ytp_containment").html(ytp_data.attributes.ytp_containment);
    jQuery(".components-textarea-control__input").eq(0).val(ytp_data.attributes.ytp_shortcode);

    jQuery("[data-block=" + ytp_data.clientId + "]>div.YTPlayer-editor-container").html(ytpl_block);

  } else {

    var win = window.dialogArguments || opener || parent || top;
    win.send_to_editor(sc);

  }

  hide_ytplayer_editor();

  return false;
}
ytp_form.onsubmit = insertShortcode;
