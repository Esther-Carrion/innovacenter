<?php

$ytpl_popup_id = "ytplayer-form";

add_action('admin_head', 'my_add_styles_admin');
function my_add_styles_admin()
{
    global $current_screen;
    $type = $current_screen->post_type;

    if (is_admin() && $type == 'post' || $type == 'page') {
        $site_url = get_site_url();
        ?>

        <script type="text/javascript">
            let ytp_site_url = '<?php echo $site_url ?>';
            let ytp_is_gutemberg = '<?php echo function_exists('register_block_type') ? "true" : "false" ?>';
        </script>
        <?php
    }
}

add_action('admin_enqueue_scripts', 'mbytpplus_load_media_script');
function mbytpplus_load_media_script()
{
    //error_log("mbytpplus_load_media_script  ". plugins_url('/ytp_media.js', __FILE__));
    global $mbYTPlayer_version;
    wp_enqueue_script('ytp_media', plugins_url('/ytp_media.js', __FILE__), array('jquery'), $mbYTPlayer_version, true, 1001);
}

// Only add ytplayer icon above posts and pages
add_action('admin_head', 'add_ytplayer_button');
function add_ytplayer_button()
{
    global $ytp_xxx;

    if (!$ytp_xxx)
        return;

    // todo: chaeck if that works

//    if (get_user_option('rich_editing') != 'true')
//        return;

    add_action('media_buttons', 'add_ytplayer_icon');
    add_action('admin_footer', 'add_ytplayer_popup');
}

/**
 * Add button above editor if not editing ytplayer
 */
function add_ytplayer_icon()
{
//  ' . get_site_url() . '

    echo '<style>
	#add-ytplayer .dashicons {
		color: #888;
		margin: 0 4px 0 0;
		vertical-align: text-top;
		height: 18px;
    width: 18px;

		background-image: url(' . get_site_url() . '/wp-content/plugins/wp-ytplayer-plus/images/ytplayerbutton.svg);
		background-repeat: no-repeat;
}

	#add-ytplayer {
		padding-left: 0.4em;
	}

	</style>
	<a id="add-ytplayer" class="button" title="' . __("Add YTPlayer", 'wpmbytplayer') . '" href="#" onclick="show_ytplayer_editor();">
		<div class="dashicons"></div>' . __("Add YTPlayer", "wpmbytplayer") . '</a>';
}

class mbytpplus_shortcode_replace
{
    function __construct()
    {

        if (get_user_option('rich_editing') != 'true')
            return;

        wp_enqueue_script('mb.YTPlayer_shortcode', plugins_url('ytp_short_code.js?_=' . MBYTPLAYER_PLUS_VERSION, __FILE__), array('jquery'), MBYTPLAYER_PLUS_VERSION, true, 1000);
        add_filter('mce_external_plugins', array(&$this, 'add_mbytpplus_tinymce_plugin'));
        add_filter('tiny_mce_before_init', array(&$this, 'add_mbytpplus_TinyMCE_css'));
    }

    //include the tinymce javascript plugin
    function add_mbytpplus_tinymce_plugin($plugin_array)
    {
        global $mbYTPlayer_version;
        $plugin_array['wpytplayer'] = plugins_url('ytp_short_code_events.js?_=' . MBYTPLAYER_PLUS_VERSION, __FILE__);
        return $plugin_array;
    }

    //include the css file to style the graphic that replaces the shortcode
    function add_mbytpplus_TinyMCE_css($in)
    {
        if (isset($in['content_css']))
            $in['content_css'] .= "," . plugins_url('ytp_short_code.css', __FILE__);;
        return $in;
    }
}

add_action("admin_init", function () {
    new mbytpplus_shortcode_replace();
});

$custom_player_id = "YTPlayer_" . rand();

// Displays the lightbox popup to insert a YTPlayer shortcode to a post/page
function add_ytplayer_popup()
{
    global $custom_player_id;
    ?>
    <div id="ytplayer-form" style="display: none;">
        <script>
            ytp_plugin_dir_url = '<?php echo plugin_dir_url(dirname(__FILE__)) ?>';
        </script>
        <style>

            /*SWITCHER*/
            .onoffswitch {
                position: relative;
                width: 60px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                display: inline-block;
            }

            .onoffswitch-checkbox {
                display: none !important;
            }

            .onoffswitch-label {
                display: block;
                overflow: hidden;
                cursor: pointer;
                height: 25px;
                padding: 0;
                line-height: 25px;
                border: 1px solid #999999;
                border-radius: 25px;
                background-color: #aeaeae;
                transition: background-color 0.3s ease-in;
            }

            .onoffswitch-label:before {
                content: "";
                display: block;
                width: 25px;
                margin: 0;
                background: #FFFFFF;
                position: absolute;
                top: 0;
                bottom: 0;
                right: 33px;
                border: 2px solid #999999;
                border-radius: 25px;
                transition: all 0.2s ease-in 0s;
                box-shadow: 3px 0 5px rgba(0, 0, 0, 0.4);
            }

            .onoffswitch-checkbox:checked + .onoffswitch-label {
                background-color: #34C23C;
            }

            .onoffswitch-checkbox:checked + .onoffswitch-label, .onoffswitch-checkbox:checked + .onoffswitch-label:before {
                border-color: #34C23C;
            }

            .onoffswitch-checkbox:checked + .onoffswitch-label:before {
                right: 0px;
            }

            #ytplayer-form {
                position: fixed;
                width: 100%;
                min-width: 500px;
                height: 100%;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
                background: rgba(0, 0, 0, 0.7);
                z-index: 10000;
                box-sizing: border-box;
                overflow: hidden;
            }

            #ytplayer-form header {
                position: absolute;
                background: #0073aa;
                color: #FFFFFF;
                height: 50px;
                box-sizing: border-box;
                margin: 0;
                top: 0;
                width: 100%;
                padding: 10px;
                box-shadow: 1px 4px 8px 0px rgba(0, 0, 0, 0.3);
                z-index: 1000;
            }

            #ytplayer-form header h2 {
                color: #ffffff;
                margin: 0;
                line-height: 40px;
            }

            #ytplayer-form #editor {
                position: absolute;
                width: 50%;
                min-width: 700px;
                height: 90%;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                margin: auto;
                background: #FFFFFF;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
                box-sizing: border-box;
            }

            #ytplayer-form #editor form {
                position: absolute;
                width: 100%;
                top: 50px;
                left: 0;
                height: calc(100% - 55px);
                overflow: auto;
                padding: 10px;
                box-sizing: border-box;
            }

            #ytplayer-form fieldset {
                font-size: 16px;
                border: none;
                font-family: Helvetica Neue, Arial, Helvetica, sans-serif;
                padding-bottom: 50px;
            }

            #ytplayer-form fieldset span.label {
                display: inline-block;
                width: 30%;
                font-size: 100%;
                font-weight: 700;
                vertical-align: top;
                background: rgba(2, 114, 170, 0.09);
                padding: 5px 10px;
            }

            #ytplayer-form fieldset div:not(.onoffswitch) {
                margin: 0;
                padding: 9px !important;
                display: block;
                font-size: 16px;
                border-bottom: 1px dotted #cccccc;
            }

            #ytplayer-form input, textarea, select {
                font-size: 100%;
            }

            #ytplayer-form input[type=text], textarea {
                width: 54%;
            }

            #ytplayer-form .sub-set {
                background: #f3f3f3;
            }

            #ytplayer-form .media-modal-close .media-modal-icon:before {
                color: #FFFFFF;
            }

            #ytplayer-form .actions {
                text-align: right;
                padding: 10px;
                background: rgba(158, 158, 158, 0.6);
                position: absolute;
                width: 100%;
                left: 0;
                bottom: 0;
                box-sizing: border-box;
            }

            .help-inline {
                font-size: 16px;
                font-weight: 300;
                display: block;
                color: #999;
                padding-left: 0;
                margin: 5px 0;
            }

            .help-inline.important {
                color: #c20020;
            }

            .help-inline.inline {
                display: inline-block;
                font-weight: 400;
                padding-left: 10px;
            }

            #inlinePlayer, #controlBox {
                display: none;
                background: #fff;
                padding: 5px;
            }

            .actions .button-large {
                font-size: 150% !important;
            }
        </style>

        <div id="editor">

            <header>
                <h2><?php _e('mb.YTPlayer short-code editor', 'wpmbytplayer'); ?></h2>
                <button onclick="hide_ytplayer_editor()" type="button" class="button-link media-modal-close"><span
                            class="media-modal-icon"><span class="screen-reader-text">Close panel</span></span></button>
            </header>

            <form id="shorcode-form" action="#">
                <fieldset>

                    <!--
                    url
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Video url', 'wpmbytplayer'); ?> <span style="color:red">*</span>: </span>
                        <textarea type="text" id="url" name="url" onchange="printVideos()"
                                  style="height: 100px; font-size: 120%; font-weight: 700"></textarea>
                        <span class="help-inline"><?php _e('YouTube video URLs (comma separated)', 'wpmbytplayer'); ?></span>
                    </div>
                    <div id="videos" style="text-align: right"></div>

                    <!--
                    custom_id
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Custom ID', 'wpmbytplayer'); ?>:</span>
                        <input type="text" name="custom_id" value="<?php echo $custom_player_id ?>">
                        <span class="help-inline"><?php _e('Set a custom ID (must be unique) you can refer to with the <a href="https://github.com/pupunzi/jquery.mb.YTPlayer/wiki#external-methods" target="_blank">API</a>', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    elementselector
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div id="elementSelector">
                        <span class="label"><?php _e('Element selector', 'wpmbytplayer'); ?>:</span>
                        <input type="text" name="elementselector" value="" onchange="isElement()"/>
                        <span class="help-inline"><?php _e('If you want the player into a specific element set the ID or the CSS class of it here (by default is the BODY of the page)', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    Background image
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Background image url', 'wpmbytplayer'); ?>:</span>
                        <input type="text" id="cover_image" name="cover_image" value=""> <input type="button"
                                                                                                class="get-url-from-media button"
                                                                                                value="Media"
                                                                                                data-for="cover_image">
                        <span class="help-inline"><?php _e('Set a background image to the video container', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                  autoplay
                  --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Autoplay', 'wpmbytplayer'); ?>: </span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="autoplay" name="autoplay"
                                   value="true" onchange="check_for_mute()"/>
                            <label class="onoffswitch-label" for="autoplay"></label>
                        </div>
                        <span class="help-inline"><?php _e('The player starts on page load.', 'wpmbytplayer'); ?></span>
                        <span class="help-inline important"><?php _e('The "autoPlay" will not work on Webkit browsers if the audio is active due to the latest Youtube policy.', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   mute
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Mute video', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mute" name="mute" value="true"/>
                            <label class="onoffswitch-label" for="mute"></label>
                        </div>
                        <span class="help-inline"><?php _e('Mute the audio of the video.', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    volume
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Audio volume', 'wpmbytplayer'); ?>:</span>
                        <input type="text" name="volume" value="50" style="width: 60px"/>
                        <span class="help-inline"><?php _e('Set the audio volume (from 0 to 100)', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    opacity
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Opacity', 'wpmbytplayer'); ?>:</span>

                        <input type="text" name="opacity" value="10" style="width: 60px">
                        <span class="help-inline"><?php _e('YouTube video opacity', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    quality
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <!--          <div>
            <span class="label"><?php /*_e('Quality', 'wpmbytplayer'); */ ?>:</span>
            <select name="quality">
              <option value="default" selected><?php /*_e('auto detect', 'wpmbytplayer'); */ ?></option>
              <option value="small"><?php /*_e('small', 'wpmbytplayer'); */ ?></option>
              <option value="medium"><?php /*_e('medium', 'wpmbytplayer'); */ ?></option>
              <option value="large"><?php /*_e('large', 'wpmbytplayer'); */ ?></option>
              <option value="hd720"><?php /*_e('hd720', 'wpmbytplayer'); */ ?></option>
              <option value="hd1080"><?php /*_e('hd1080', 'wpmbytplayer'); */ ?></option>
              <option value="highres"><?php /*_e('highres', 'wpmbytplayer'); */ ?></option>
            </select>
            <span class="help-inline"><?php /*_e('YouTube video quality', 'wpmbytplayer'); */ ?></span>
          </div>
-->
                    <!--
                    ratio
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Aspect ratio', 'wpmbytplayer'); ?>:</span>
                        <select name="ratio">
                            <option value="auto"
                                    selected="selected"><?php _e('auto detect', 'wpmbytplayer'); ?></option>
                            <option value="4/3"><?php _e('4/3', 'wpmbytplayer'); ?></option>
                            <option value="16/9"><?php _e('16/9', 'wpmbytplayer'); ?></option>
                        </select>
                        <span class="help-inline"><?php _e('YouTube video aspect ratio'); ?>.</span>
                        <span class="help-inline important"> <?php _e('If "auto" the plug in will try to get it from Youtube', 'wpmbytplayer'); ?>.</span>
                    </div>

                    <!--
                   isinline
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div id="inlinePlayer-checkbox">
                        <span class="label"><?php _e('Is inline', 'wpmbytplayer'); ?>: </span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="isinline" name="isinline"
                                   value="true" onchange="isInline()"/>
                            <label class="onoffswitch-label" for="isinline"></label>
                        </div>
                        <span class="help-inline"><?php _e('Show the player inline', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   inLine_ratio, playerwidth, playerheight
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div class="sub-set" id="inlinePlayer" style="display: none">
                        <span class="label"><?php _e('Player width', 'wpmbytplayer'); ?> *: </span>
                        <input type="text" name="playerwidth" style="width: 60px" onblur="suggestedHeight()"/> px
                        <span class="help-inline"><?php _e('Set the width of the inline player', 'wpmbytplayer'); ?></span>
                        <span class="label"><?php _e('Aspect ratio', 'wpmbytplayer'); ?>:</span>
                        <select name="inLine_ratio" style="width: 60px" onchange="suggestedHeight()">
                            <option value="4/3"><?php _e('4/3', 'wpmbytplayer'); ?></option>
                            <option value="16/9"><?php _e('16/9', 'wpmbytplayer'); ?></option>
                        </select>
                        <span class="help-inline"><?php _e('To get the suggested height for the player', 'wpmbytplayer'); ?></span>
                        <span class="label"><?php _e('Player height', 'wpmbytplayer'); ?> *: </span>
                        <input type="text" name="playerheight" style="width: 60px"/> px
                        <span class="help-inline"><?php _e('Set the height of the inline player', 'wpmbytplayer'); ?></span>
                        <span class="help-inline">* Add % to the unit if the width is set as percentage.</span>
                        <br>
                        <br>
                        <span class="label"><?php _e('Go fullscreen on play', 'wpmbytplayer'); ?>: </span>
                        <div class="onoffswitch">
                            <input type="checkbox" class="onoffswitch-checkbox" id="gofullscreenonplay"
                                   name="gofullscreenonplay" value="true"/>
                            <label class="onoffswitch-label" for="gofullscreenonplay"></label>
                        </div>
                        <span class="help-inline"><?php _e('if checked the player will go full screen once start playing', 'wpmbytplayer'); ?></span>

                    </div>

                    <!--
                    showcontrols
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Show controls', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="showcontrols" name="showcontrols"
                                   value="true" onchange="showControlBox()"/>
                            <label class="onoffswitch-label" for="showcontrols"></label>
                        </div>
                        <span class="help-inline"><?php _e('show controls for this player', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    realfullscreen, printurl
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div class="sub-set" id="controlBox" style="display: none">
                        <span class="label"><?php _e('Full screen', 'wpmbytplayer'); ?>:</span>
                        <input type="radio" id="realfullscreen" name="realfullscreen" value="true" checked/>
                        <span class="help-inline inline"><?php _e('Full screen containment is the screen', 'wpmbytplayer'); ?></span>

                        <span class="label"></span>
                        <input type="radio" name="realfullscreen" value="false"/>
                        <span class="help-inline inline"><?php _e('Full screen containment is the browser window', 'wpmbytplayer'); ?></span>
                        <br>
                        <br>
                        <span class="label"><?php _e('Show YouTube® link', 'wpmbytplayer'); ?></span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="printurl" name="printurl"
                                   value="true" checked/>
                            <label class="onoffswitch-label" for="printurl"></label>
                        </div>
                        <span class="help-inline"><?php _e('Show the link to the original YouTube® video', 'wpmbytplayer'); ?>.</span>
                    </div>

                    <!--
                   startat
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Start at', 'wpmbytplayer'); ?>: </span>
                        <input type="text" name="startat" style="width: 60px"/> sec.
                        <span class="help-inline"><?php _e('Set the seconds you want the player starts at', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   stopat
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Stop at', 'wpmbytplayer'); ?>: </span>
                        <input type="text" name="stopat" style="width: 60px"/> sec.
                        <span class="help-inline"><?php _e('Set the seconds you want the player stops at', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   loop
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Loop video', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="loop" name="loop" value="true"/>
                            <label class="onoffswitch-label" for="loop"></label>
                        </div>
                        <span class="help-inline"><?php _e('Loop the video once ended', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    abundance
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Abundance', 'wpmbytplayer'); ?>:</span>
                        <input type="number" min="0" max="10" name="abundance" value="2" style="width: 60px"/> %
                        <span class="help-inline"><?php _e('Set the abundance for the video in percentage of its size', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    optimize_display
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Optimize display', 'wpmbytplayer'); ?>: </span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="optimize_display"
                                   name="optimize_display" value="true" checked onchange="showAnchor()"/>
                            <label class="onoffswitch-label" for="optimize_display"></label>
                        </div>
                        <span class="help-inline"><?php _e('Optimize the video display to fit the containment size', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   anchor
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div class="sub-set" id="anchorBox" style="position: relative; height: 150px; display: none">
                        <span class="label"><?php _e('Anchor point', 'wpmbytplayer'); ?>:</span>
                        <select name="anchor">
                            <option value="center,center"><?php _e('center,center', 'wpmbytplayer'); ?></option>
                            <option value="center,left"><?php _e('center,left', 'wpmbytplayer'); ?></option>
                            <option value="center,right"><?php _e('center,right', 'wpmbytplayer'); ?></option>

                            <option value="top,left"><?php _e('top,left', 'wpmbytplayer'); ?></option>
                            <option value="top,center"><?php _e('top,center', 'wpmbytplayer'); ?></option>
                            <option value="top,right"><?php _e('top,right', 'wpmbytplayer'); ?></option>

                            <option value="bottom,left"><?php _e('bottom,left', 'wpmbytplayer'); ?></option>
                            <option value="bottom,center"><?php _e('bottom,center', 'wpmbytplayer'); ?></option>
                            <option value="bottom,right"><?php _e('bottom,right', 'wpmbytplayer'); ?></option>
                        </select>
                        <span class="help-inline"><?php _e('Set the anchor point vor the video', 'wpmbytplayer'); ?></span>
                        <div id="anchor_img"
                             style="position: absolute; top:0; right: 0; width: 310px; height: 150px; background: url('<?php echo plugin_dir_url(dirname(__FILE__)) ?>/images/anchor/center,center.jpg') top right no-repeat; background-size: contain"></div>
                        <script>
                            jQuery("[name=anchor]").on("change", function () {
                                setAnchorImage(jQuery(this).val());
                            })
                        </script>
                    </div>

                    <!--
                   addraster
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Add raster', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="addraster" name="addraster"
                                   value="true"/>
                            <label class="onoffswitch-label" for="addraster"></label>
                        </div>
                        <span class="help-inline"><?php _e('Add a raster effect', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   stopmovieonblur
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Pause on window blur', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="stopmovieonblur"
                                   name="stopmovieonblur" value="true"/>
                            <label class="onoffswitch-label" for="stopmovieonblur"></label>
                        </div>
                        <span class="help-inline"><?php _e('Pause the player on window blur', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                   remember_last_time
                   --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Remember last video time position', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="remember_last_time"
                                   name="remember_last_time" value="true"/>
                            <label class="onoffswitch-label" for="remember_last_time"></label>
                        </div>
                        <span class="help-inline"><?php _e('Check to start the video from the where you left last time', 'wpmbytplayer'); ?></span>
                    </div>

                    <!--
                    gaTrack
                    --------------------–--------------------–--------------------–--------------------–--------------------–------- -->

                    <div>
                        <span class="label"><?php _e('Add Google Analytics', 'wpmbytplayer'); ?>:</span>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="gaTrack" name="gaTrack"
                                   value="true"/>
                            <label class="onoffswitch-label" for="gaTrack"></label>
                        </div>
                        <span class="help-inline"><?php _e('Add the event "play" on Google Analytics track', 'wpmbytplayer'); ?></span>
                    </div>

                </fieldset>

            </form>

            <div class="actions">
                <input type="submit" value="<?php _e('Insert the short-code', 'wpmbytplayer'); ?>"
                       class="button button-primary button-large" onclick="jQuery('#shorcode-form').submit()"/>
            </div>
        </div>
    </div>

<?php }
