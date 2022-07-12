<?php
/**
 * Created by mb.ideas.
 * User: pupunzi
 * Date: 19/11/16
 * Time: 15:07
 */
global $mbYTPlayer_license_key;

$ytp_core = new ytp_mb_core("YTPL", $mbYTPlayer_license_key, $ytp_base);
$lic_domain = null;

$ytp_xxx = !empty($mbYTPlayer_license_key);
$is_in_development = false;

/**
 *
 */
add_action("init", function () {

  if (defined('DOING_AJAX') && DOING_AJAX)
    return;

  if (defined('WP_CLI') && WP_CLI)
    return;

  global $ytp_xxx, $is_in_development, $ytp_core, $lic_domain;

  $lic_domain = $ytp_core->get_lic_domain();
  $ytp_xxx = $ytp_core->validate_local_lic();

  $is_in_development = get_option('mbYTPlayer_is_development_site') && is_user_logged_in();
  if ($is_in_development)
    $ytp_xxx = true;

  if ($ytp_xxx && is_player_edit_page())
    require_once("popup.php");
});

/**
 * Save Lic to file
 */
add_action('wp_ajax_mbytpplus_storeLic', 'ytp_storeLic');
function ytp_storeLic()
{
  global $ytp_core;
  $ytp_core->storeLic();
}

/**
 * @param $hook
 */
add_action('admin_enqueue_scripts', 'mbytpplus_load_admin_script');
function mbytpplus_load_admin_script($hook)
{
  global $mbYTPlayer_version, $lic_domain;
  if ($hook != 'mb-ideas_page_wp-ytplayer-plus/wp-ytplayer-plus' && $hook != 'toplevel_page_mb-ideas-menu')
    return;

  wp_register_script('ytp_admin', plugins_url('/ytp_admin.js', __FILE__), array('jquery'), $mbYTPlayer_version, true, 1000);
  wp_register_script('ytp_media', plugins_url('/ytp_media.js', __FILE__), array('jquery'), $mbYTPlayer_version, true, 1001);

  $siteurl = get_site_url();
  $data = array(
    "str_valid_key_needed" => __('A license key is needed', 'wpmbytplayer'),
    "str_license_not_valid" => __('Your license can\'t be verified', 'wpmbytplayer'),
    "str_server_error" => __('There\'s been a problem with the server:', 'wpmbytplayer'),
    "str_license_valid" => __('Your license is valid', 'wpmbytplayer'),
    "str_license_validating" => __('Validating your license', 'wpmbytplayer'),
    "str_email_sent" => __('An email has been sent. Follow the link', 'wpmbytplayer'),
    "site_url" => "$siteurl",

    "lic_domain" => $lic_domain,
    "lic_theme" => get_template()
  );

  wp_enqueue_media();
  wp_localize_script('ytp_admin', 'ytpl_lic', $data);
  wp_enqueue_script('ytp_admin');
  wp_enqueue_script('ytp_media');
  wp_enqueue_style('ytp_admin_css', plugins_url('/mb_admin.css', __FILE__), null, MBYTPLAYER_PLUS_VERSION);
}

/**
 * define the shortcode function
 */
add_shortcode('mbYTPlayer', 'mbytpplus_shortcode');
add_filter('widget_text', 'do_shortcode');

function mbytpplus_shortcode($atts)
{
  global $ytp_xxx, $ytp_core;

  if (!$ytp_xxx)
    $ytp_xxx = $ytp_core->validate_local_lic();

  STATIC $i = 1;
  $elId = "body";
  $style = "";
  extract(shortcode_atts(array(
    'url' => '',
    'fallback_image' => null,
    'cover_image' => null,
    'custom_id' => null,
    'showcontrols' => '',
    'printurl' => '',
    'mute' => '',
    'ratio' => '',
    'loop' => '',
    'opacity' => '',
    'quality' => '',
    'addraster' => '',
    'isinline' => '',
    'goFullScreenOnPlay' => false,
    'playerwidth' => '',
    'playerheight' => '',
    'autoplay' => '',
    'gaTrack' => '',
    'stopmovieonblur' => '',
    'remember_last_time' => 'false',
    'realfullscreen' => 'true',
    'elementselector' => null,
    'startat' => '',
    'stopat' => '',
    'volume' => '',
    'optimize_display' => 'true',
    'anchor' => 'center,center',
    'abundance' => '2'
  ), $atts));

  if (empty($url) || ((is_home() || is_front_page()) && !empty($mbYTPlayer_home_video_url) && empty($isInline)))
    return false;

  if (empty($custom_id))
    $custom_id = null;

  if (empty($fallback_image))
    $fallback_image = null;

  if (empty($startat))
    $startat = 0;

  if (empty($stopat))
    $stopat = 0;

  if (empty($isinline))
    $isinline = "false";

  if (empty($goFullScreenOnPlay))
    $goFullScreenOnPlay = "false";

  if (empty($elementselector))
    $elementselector = null;

  if (empty($ratio))
    $ratio = "auto";

  if (empty($showcontrols))
    $showcontrols = "true";

  if (empty($printurl))
    $printurl = "true";

  if (empty($opacity))
    $opacity = "1";

  if (empty($mute))
    $mute = "false";

  if (empty($loop))
    $loop = "false";

//	if (empty($quality))
  $quality = "default";

  if (empty($addraster))
    $addraster = "false";

  if (empty($stopmovieonblur))
    $stopmovieonblur = "false";

  if (empty($gaTrack)) {
    $gaTrack = "false";
  };
  if (empty($realfullscreen))
    $realfullscreen = "true";

  if (empty($autoplay))
    $autoplay = "false";

  if (empty($volume))
    $volume = "50";

  if ($isinline == "true") {
    if (empty($playerwidth))
      $playerwidth = "300";

    if (empty($playerheight))
      $playerheight = "220";

    $unitWidth = strrpos($playerwidth, "%") ? "" : "px";
    $unitHeight = strrpos($playerheight, "%") ? "" : "px";

    $startat = $startat > 0 ? $startat : 1;

    $elId = "self";
    $style = " style=\"width:" . $playerwidth . $unitWidth . "; height:" . $playerheight . $unitHeight . "; position:relative\"";
  };

  if ($elementselector != null)
    $elId = $elementselector;

  if (empty($remember_last_time))
    $remember_last_time = "false";

  if ($opacity > 1)
    $opacity = $opacity / 10;

  if (empty($optimize_display))
    $optimize_display = "true";

  if (empty($cover_image))
    $cover_image = false;

  if (empty($anchor))
    $anchor = "center,center";

  if (empty($abundance))
    $abundance = "2";

  /**
   * If multiple URL are inserted than choose one randomly
   * */
  $vids = explode(',', $url);
  $n = rand(0, count($vids) - 1);
  $mbYTPlayer_home_video_url_revised = $vids[$n];

  $player_id = $custom_id ? $custom_id : 'playerVideo' . $i;

  $mbYTPlayer_player_shortcode = $ytp_xxx ?
    '<div id="' . $player_id . '" ' . $style . ' class="mbYTPVideo' . ($isinline ? " inline_YTPlayer" : "") . '"' .
    ' data-property="{' .
    'videoURL:\'' . $mbYTPlayer_home_video_url_revised . '\'' .
    ', mobileFallbackImage:\'' . $fallback_image . '\'' .
    ', opacity:' . $opacity .
    ', autoPlay:' . $autoplay .
    ', containment:\'' . $elId . '\'' .
    ', goFullScreenOnPlay:\'' . $goFullScreenOnPlay . '\'' .
    ', startAt:' . $startat .
    ', stopAt:' . $stopat .
    ', mute:' . $mute .
    ', vol:' . $volume .
    ', optimizeDisplay:' . $optimize_display .
    ', showControls:' . $showcontrols .
    ', printUrl:' . $printurl .
    ', loop:' . $loop .
    ', addRaster:' . $addraster .
    ', quality:\'' . $quality . '\'' .
    ', realfullscreen:' . $realfullscreen .
    ', ratio:\'' . $ratio . '\'' .
    ', abundance:\'' . ($abundance / 10) . '\'' .
    ', coverImage:' . ($cover_image ? "'$cover_image'" : "false") .
    ', anchor:\'' . $anchor . '\'' .
    ', gaTrack:' . $gaTrack .
    ', stopMovieOnBlur:' . $stopmovieonblur .
    ', remember_last_time:' . $remember_last_time .
    '}"></div>'
    : '<div class="ytp_alert">' . __('<h3>[YTPlayer short code]</h3><p>You need a <b>license key</b> to display a <b>YTPlayer video</b> using the shortcode.<br> Go to the <b>YTPlayer settings page</b> to get your license</p>', 'wpmbytplayer') . '</div>';

  $i++; //increment static variable for unique player IDs

  return $mbYTPlayer_player_shortcode;
}

$ytp_more = $ytp_core->get_more();

if (file_exists($ytp_more)) {
  require_once('ytp_more.php');
}
