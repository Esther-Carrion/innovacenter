/*******************************************************************************
 *
 * ytp_media
 * Author: pupunzi
 * Creation date: 30/05/18
 *
 ******************************************************************************/

/**
 * Image media manager
 */
jQuery( function($) {
  var actual_input_id = null;
  var image_frame;
  if (image_frame) {
    image_frame.open();
  }
  // Define image_frame as wp.media object
  image_frame = wp.media({
    title   : 'Select Media',
    multiple: false,
    library : {
      type: 'image'
    }
  });
  
  image_frame.on('close', function () {
    var selection = image_frame.state().get('selection');
    var gallery_url = [];
    var my_index = 0;
    selection.each(function (attachment) {
      gallery_url[my_index] = attachment.attributes.url;
      my_index++;
    });
    var urls = gallery_url.join(",");
    var input = jQuery('input#' + actual_input_id);
    input.val(urls);
    var image_id = actual_input_id + "_IMG";
    $("#"+ image_id).remove();
    var image = $("<img/>").attr({"src": urls, "id": image_id}).css({width:140, display:"block"});
    input.next("input").after(image);
  });
  
  jQuery('input.get-url-from-media').each(function(){
    $(this).on("click",function(e) {
      e.preventDefault();
      image_frame.open();
      actual_input_id = $(this).data("for");
    });
    
    var input = jQuery('input#' + $(this).data("for"));
    
    input.on("change", function (e) {
      var target = e.target;
      var image_id = target.id + "_IMG";
      $("#"+ image_id).remove();
      if(input.val().trim().length >0){
        var image = $("<img/>").attr({"src": input.val(), "id": image_id}).css({width:140, display:"block"});
        input.next("input").after(image);
      }
    });
    
    if(input.val().trim().length>0)
      input.trigger("change");
  });
});

