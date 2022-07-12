/**
 * YTPLayer Gutemberg block
 *  Copyright (c) 2001-2018. Matteo Bicocchi (Pupunzi)
 */
var el = wp.element.createElement,
    ytp_data = null,
    registerBlockType = wp.blocks.registerBlockType,
    ServerSideRender = wp.components.ServerSideRender,
    TextControl = wp.components.TextControl,
    TextareaControl = wp.components.TextareaControl,
    InspectorControls = wp.editor.InspectorControls;

var ytpl_block =  '';

/** Set the icon for your block */
var ytpl_icon = el ("img", {
  src: "/wp-content/plugins/wp-ytplayer-plus/images/YTPL.svg",
  width: "50px",
  height: "50px"
});

function getThumbs(URLs){
  if (!URLs)
    return false;
  vids = URLs.split(",");
  let domEls = [];
  for (let i = 0; i < vids.length; i++) {
    let videoId = getYTPVideoID(vids[i]).videoID;
    let coverImageURL = "https://img.youtube.com/vi/"+videoId+"/2.jpg";
    domEls.push( el( "img", {
      src : coverImageURL,
      style: {width: (100/vids.length) + "%"}
    } ) );
  }
  
  let vidsContainer = el( "div", {
    id: "YTPL-vidThumbsContainer",
  }, domEls );
  
  return vidsContainer;
}

registerBlockType( 'ytplayer/ytpl-block', {
  title: 'YTPlayer Background Video',
  icon: ytpl_icon,
  category: 'mb.ideas',
  
  edit: (props) => {
    
    if(props.isSelected){
      
      ytp_data = props;
      ytpl_block =  '<img class="YTPlayer-editor" id="YTPlayer-editor_' + new Date().getTime() + '" src="/wp-content/plugins/wp-ytplayer-plus/images/ytplayershortcode.png" data-ytpl-obj="' + props.attributes.ytp_shortcode + '" >';
    
    }
    
    function showEditor(e){
      ytp_el = e.target;
      ytp_data = props;
      show_ytplayer_editor(true);
    }
    
    function drawButton(){
      return  el("div", {
            style: {textAlign: "center"}
          }, el("button", {
            className: "YTPlayer-editor components-button editor-media-placeholder__button is-button is-default is-large",
            id: 'YTPlayer-editor',
            onClick: (e) => { showEditor(e) }
          }, props.attributes.ytp_shortcode ? "Edit shortcode" : "Add shortcode")
      )
    };
    
    return [
      /**
       * Server side render
       */
      el("div", {
            className: "YTPlayer-editor-container",
            style: {textAlign: "center"}
          },
          el( ServerSideRender, {
            block: 'ytplayer/ytpl-block',
            attributes: props.attributes
          } )
      ),
      
      /**
       * Editor
       */
      drawButton(),
      /**
       * Inspector
       */
      el( InspectorControls,
          {}, [
            
            el( "hr", {
              style: {marginTop:20}
            }),
            
            getThumbs(props.attributes.ytp_urls),
      
            el( "p", {
              id: "ytp_containment",
              style: {marginTop:20}
            }, "Containment: ",
                el ("span", {
                  style: {fontWeight:600}
                }, (props.attributes.ytp_containment || "BODY") )
            ),
            
            el( "p", {
              style: {marginTop:20}
            }, "Here is the shortcode for the YTPLayer" ),
            
            el( TextareaControl, {
              style: {height:250},
              label: 'Shortcode',
              value: props.attributes.ytp_shortcode,
              readOnly: false,
              onChange: ( value ) => {
                props.setAttributes( { ytp_shortcode: value } );
              }
            }, props.attributes.ytp_shortcode ),
            
            drawButton()
            
          ]
      )
    ]
  },
  
  save: () => {
    return null
  }
} );
