<?php
/**
 * @wordpress-plugin
 * Plugin Name:  mb YTPlayer PLUS for background videos
 * Plugin URI:   https://pupunzi.com/wpPlus/go-plus.php?plugin_prefix=YTPL
 * Description:  Play any Youtube video as page background or as background of any page element of your Wordpress site.
 * Version:      3.6.0
 * License:      GPLv2 or later
 * Author:       Pupunzi (Matteo Bicocchi)
 * Author URI:   https://pupunzi.open-lab.com
 * Text Domain:  wpmbytplayer
 * Domain Path:  /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

define("MBYTPLAYER_PLUS_VERSION", "3.6.0");
define("MBYTPLAYER_PREFIX", "YTPL");
define("MBYTPLAYER_MESSAGE", "mbYTPlayer has been updated to version " . MBYTPLAYER_PLUS_VERSION);

$ytppro = true;
$ytp_base = __FILE__;
$ytp_plugin_base = plugins_url("", $ytp_base);

$is_in_development = false;

/**
 * Add options on install
 */
register_activation_hook(__FILE__, 'mbytpplus_install');

function mbytpplus_install()
{
// add and update our default options upon activation
    add_option('mbYTPlayer_version', MBYTPLAYER_PLUS_VERSION);
    add_option('mbYTPlayer_is_active', 'true');
    add_option('mbYTPlayer_is_active_for_mobile', 'true');

    add_option('mbYTPlayer_video_url', '');
    add_option('mbYTPlayer_show_controls', 'false');
    add_option('mbYTPlayer_custom_id', null);
    add_option('mbYTPlayer_show_videourl', 'false');
    add_option('mbYTPlayer_video_page', 'static');
    add_option('mbYTPlayer_audio_volume', '50');
    add_option('mbYTPlayer_mute', 'true');
    add_option('mbYTPlayer_start_at', '0');
    add_option('mbYTPlayer_stop_at', '0');
    add_option('mbYTPlayer_ratio', '16/9');
    add_option('mbYTPlayer_loop', 'true');
    add_option('mbYTPlayer_opacity', '10');
    add_option('mbYTPlayer_quality', 'default');
    add_option('mbYTPlayer_add_raster', 'false');
    add_option('mbYTPlayer_stop_on_blur', 'false');
    add_option('mbYTPlayer_track_ga', 'false');
    add_option('mbYTPlayer_realfullscreen', 'true');
    add_option('mbYTPlayer_fallbackimage', null);
    add_option('mbYTPlayer_remember_last_time', 'false');
    add_option('mbYTPlayer_init_delay', 0);

    add_option('mbYTPlayer_no_cookie', 'true');

    // enable the PLUS if the KEY is set and the development site is checked
    add_option('mbYTPlayer_is_development_site', 'false');

    add_option('mbYTPlayer_optimize_display', 'true');
    add_option('mbYTPlayer_anchor', 'center,center');
    add_option('mbYTPlayer_autoplay', 'true');
    add_option('mbYTPlayer_background_image', null);
    add_option('mbYTPlayer_abundance', '2');

    //license key
    add_option('mbYTPlayer_license_key', '');
}

$mbYTPlayer_version = get_option('mbYTPlayer_version');
$mbYTPlayer_is_active = get_option('mbYTPlayer_is_active');
$mbYTPlayer_is_active_for_mobile = get_option('mbYTPlayer_is_active_for_mobile');

$mbYTPlayer_video_url = get_option('mbYTPlayer_video_url');
$mbYTPlayer_video_page = get_option('mbYTPlayer_video_page');
$mbYTPlayer_show_controls = get_option('mbYTPlayer_show_controls');
$mbYTPlayer_show_videourl = get_option('mbYTPlayer_show_videourl');
$mbYTPlayer_ratio = get_option('mbYTPlayer_ratio');
$mbYTPlayer_audio_volume = get_option('mbYTPlayer_audio_volume');
$mbYTPlayer_mute = get_option('mbYTPlayer_mute');
$mbYTPlayer_start_at = get_option('mbYTPlayer_start_at');
$mbYTPlayer_stop_at = get_option('mbYTPlayer_stop_at');
$mbYTPlayer_loop = get_option('mbYTPlayer_loop');
$mbYTPlayer_opacity = get_option('mbYTPlayer_opacity');

/*
 * the setPlaybackQuality has been deprecated by YT
 */
$mbYTPlayer_quality = 'hd1080';
//$mbYTPlayer_quality = get_option('mbYTPlayer_quality');

$mbYTPlayer_add_raster = get_option('mbYTPlayer_add_raster');
$mbYTPlayer_realfullscreen = get_option('mbYTPlayer_realfullscreen');
$mbYTPlayer_fallbackimage = get_option('mbYTPlayer_fallbackimage');
$mbYTPlayer_stop_on_blur = get_option('mbYTPlayer_stop_on_blur');
$mbYTPlayer_track_ga = get_option('mbYTPlayer_track_ga');
$mbYTPlayer_custom_id = get_option('mbYTPlayer_custom_id');
$mbYTPlayer_remember_last_time = get_option('mbYTPlayer_remember_last_time');
$mbYTPlayer_init_delay = get_option('mbYTPlayer_init_delay');
$mbYTPlayer_no_cookie = get_option('mbYTPlayer_no_cookie');

$mbYTPlayer_is_development_site = get_option('mbYTPlayer_is_development_site');

$mbYTPlayer_autoplay = get_option('mbYTPlayer_autoplay');
$mbYTPlayer_optimize_display = get_option('mbYTPlayer_optimize_display');
$mbYTPlayer_anchor = get_option('mbYTPlayer_anchor');
$mbYTPlayer_background_image = get_option('mbYTPlayer_background_image');
$mbYTPlayer_abundance = get_option('mbYTPlayer_abundance');

/**
 * license key
 */
$mbYTPlayer_license_key = get_option('mbYTPlayer_license_key');

/**
 * @Deprecated
 */
$old = get_option('mbYTPlayer_Home_is_active');
if (!empty($old)) {
    $mbYTPlayer_is_active = get_option('mbYTPlayer_Home_is_active');
    delete_option('mbYTPlayer_Home_is_active');
    $mbYTPlayer_video_url = get_option('mbYTPlayer_home_video_url');
    delete_option('mbYTPlayer_home_video_url');
    $mbYTPlayer_video_page = get_option('mbYTPlayer_home_video_page');
    delete_option('mbYTPlayer_home_video_page');
}

/**
 * Set up defaults if these fields are empty
 */
if (empty($mbYTPlayer_is_active)) {
    $mbYTPlayer_is_active = false;
}
if (empty($mbYTPlayer_is_active_for_mobile)) {
    $mbYTPlayer_is_active_for_mobile = false;
}
if (empty($mbYTPlayer_custom_id)) {
    $mbYTPlayer_custom_id = "YTPlayer_" . rand();
}
if (empty($mbYTPlayer_show_controls)) {
    $mbYTPlayer_show_controls = "false";
}
if (empty($mbYTPlayer_show_videourl)) {
    $mbYTPlayer_show_videourl = "false";
}
if (empty($mbYTPlayer_ratio)) {
    $mbYTPlayer_ratio = "16/9";
}
if (empty($mbYTPlayer_audio_volume)) {
    $mbYTPlayer_audio_volume = "50";
}
if (empty($mbYTPlayer_mute)) {
    $mbYTPlayer_mute = "false";
}
if (empty($mbYTPlayer_start_at)) {
    $mbYTPlayer_start_at = 0;
}
if (empty($mbYTPlayer_stop_at)) {
    $mbYTPlayer_stop_at = 0;
}
if (empty($mbYTPlayer_loop)) {
    $mbYTPlayer_loop = "false";
}
if (empty($mbYTPlayer_opacity)) {
    $mbYTPlayer_opacity = "10";
}

/*if (empty($mbYTPlayer_quality)) {
	$mbYTPlayer_quality = "default";
}*/

if (empty($mbYTPlayer_add_raster)) {
    $mbYTPlayer_add_raster = "false";
}
if (empty($mbYTPlayer_track_ga)) {
    $mbYTPlayer_track_ga = "false";
}
if (empty($mbYTPlayer_stop_on_blur)) {
    $mbYTPlayer_stop_on_blur = "false";
}
if (empty($mbYTPlayer_realfullscreen)) {
    $mbYTPlayer_realfullscreen = "false";
}
if (empty($mbYTPlayer_fallbackimage)) {
    $mbYTPlayer_fallbackimage = null;
}
if (empty($mbYTPlayer_video_page)) {
    $mbYTPlayer_video_page = "static";
}
if (empty($mbYTPlayer_remember_last_time)) {
    $mbYTPlayer_remember_last_time = "false";
}
if (empty($mbYTPlayer_init_delay)) {
    $mbYTPlayer_init_delay = 0;
}
if (empty($mbYTPlayer_no_cookie)) {
    $mbYTPlayer_no_cookie = 'true';
}
if (empty($mbYTPlayer_autoplay)) {
    $mbYTPlayer_autoplay = 'false';
}
if (empty($mbYTPlayer_optimize_display)) {
    $mbYTPlayer_optimize_display = 'false';
}
if (empty($mbYTPlayer_anchor)) {
    $mbYTPlayer_anchor = 'center,center';
}
if (empty($mbYTPlayer_background_image)) {
    $mbYTPlayer_background_image = null;
}
if (empty($mbYTPlayer_abundance)) {
    $mbYTPlayer_abundance = '2';
}

if (empty($mbYTPlayer_is_development_site)) {
    $mbYTPlayer_is_development_site = false;
}

$mbYTPlayer_quality = "default";

/**
 * Include core functions
 */
require_once("inc/mb_ytp_core.php");
require_once('inc/extra.php');

/**
 * Add Gutemberg support
 */
require_once('inc/gutemberg-support/ytp-block.php');


/**
 * Include scripts and CSS
 */
add_action('wp_enqueue_scripts', 'mbytpplus_init');
function mbytpplus_init()
{
    global $mbYTPlayer_version;

    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('YTPlayer', plugins_url('/js/jquery.mb.YTPlayer.js', __FILE__), array('jquery'), $mbYTPlayer_version, true, 1000);
        wp_enqueue_style('YTPlayer_css', plugins_url('/css/mb.YTPlayer.css', __FILE__), array(), $mbYTPlayer_version, 'screen');
    }
}

/**
 * Internationalization
 */
add_action('plugins_loaded', 'mbytpplus_localize');
function mbytpplus_localize()
{
    load_plugin_textdomain('wpmbytplayer', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

if (!$mbYTPlayer_version || $mbYTPlayer_version != MBYTPLAYER_PLUS_VERSION) {

    //If not available add some options
    add_option('mbYTPlayer_autoplay', 'true');
    add_option('mbYTPlayer_optimize_display', 'true');
    add_option('mbYTPlayer_anchor', 'center,center');
    add_option('mbYTPlayer_background_image', null);
    add_option('mbYTPlayer_abundance', '2');

    //Update price
    update_option('mbYTPlayer_price', $ytp_core->get_price("YTPL"));

    //Update version
    update_option('mbYTPlayer_version', MBYTPLAYER_PLUS_VERSION);

    //Validate license
    $ytp_core->get_lic_from_server();

    //Reset notices
    if (version_compare(phpversion(), '5.5.0', '>')) {
        require_once('inc/mb_notice/notice.php');
        $ytp_notice = new mb_notice('mbytpplus', plugin_basename(__FILE__));
        $ytp_notice->reset_notice();
    }
}

$mbYTPlayer_plus_price = get_option('mbYTPlayer_price');

if ($mbYTPlayer_plus_price['COM'] == 'NA') {
    update_option('mbYTPlayer_price', $ytp_core->get_price("YTPL"));
}

$mbYTPlayer_plus_price = get_option('mbYTPlayer_price');

if (!function_exists("is_player_edit_page")) {
    /**
     * Check if is in admin edit
     *
     * @param null $new_edit
     * @return bool
     */
    function is_player_edit_page($new_edit = null)
    {
        global $pagenow;

        //make sure we are on the backend
        if (!is_admin())
            return false;

        if ($new_edit == "edit")
            return in_array($pagenow, array('post.php',));
        elseif ($new_edit == "new") //check for new post page
            return in_array($pagenow, array('post-new.php'));
        else //check for either new or edit
            return in_array($pagenow, array('post.php', 'post-new.php'));
    }
}

$link = "https://pupunzi.com/wpPlus/go-plus.php?locale=" . get_locale() . "&plugin_prefix=YTPL&plugin_version=" . MBYTPLAYER_PLUS_VERSION . "&lic_domain=" . $lic_domain . "&lic_theme=" . get_template() . "&php=" . phpversion();

/**
 * Add admin notice
 */
if (version_compare(phpversion(), '5.5.0', '>')) {
    require_once('inc/mb_notice/notice.php');
    $ytp_notice = new mb_notice('mbytpplus', plugin_basename(__FILE__));
    $ytp_message = MBYTPLAYER_MESSAGE;
    $ytp_notice->add_notice($ytp_message, 'success');
}

/**
 * Settings page link
 *
 * @param $links
 * @param $file
 * @return mixed
 */
add_filter('plugin_action_links', 'mbytpplus_action_links', 10, 2);
function mbytpplus_action_links($links, $file)
{
    if ($file == plugin_basename(__FILE__)) {
        // The anchor tag and href to the URL we want. For a "Settings" link, this needs to be the url of your settings page
        $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=wp-ytplayer-plus/wp-ytplayer-plus.php">Settings</a>';
        // Add the link to the list
        array_unshift($links, $settings_link);
    }
    return $links;
}

/**
 * scripts to load in the footer
 */
add_action('wp_footer', 'mbytpplus_player_foot', 20);
function mbytpplus_player_foot()
{
    global $mbYTPlayer_is_active_for_mobile,
           $mbYTPlayer_video_url,
           $mbYTPlayer_fallbackimage,
           $mbYTPlayer_show_controls,
           $mbYTPlayer_ratio,
           $mbYTPlayer_show_videourl,
           $mbYTPlayer_start_at,
           $mbYTPlayer_stop_at,
           $mbYTPlayer_mute,
           $mbYTPlayer_loop,
           $mbYTPlayer_opacity,
           $mbYTPlayer_quality,
           $mbYTPlayer_add_raster,
           $mbYTPlayer_track_ga,
           $mbYTPlayer_realfullscreen,
           $mbYTPlayer_stop_on_blur,
           $mbYTPlayer_video_page,
           $mbYTPlayer_is_active,
           $mbYTPlayer_audio_volume,
           $mbYTPlayer_css_plus,
           $mbYTPlayer_custom_id,
           $mbYTPlayer_remember_last_time,
           $mbYTPlayer_init_delay,
           $mbYTPlayer_no_cookie,
           $mbYTPlayer_is_development_site,

           $mbYTPlayer_optimize_display,
           $mbYTPlayer_anchor,
           $mbYTPlayer_background_image,
           $mbYTPlayer_abundance,
           $mbYTPlayer_autoplay,
           $mbYTPlayer_license_key;

    $mbYTPlayer_css_plus = "";
    $mbYTPlayer_is_active_for_mobile = $mbYTPlayer_is_active_for_mobile ? "true" : "false";

    echo '

	<!-- START - mbYTPlayer shortcode video -->
	' . $mbYTPlayer_css_plus . '
	<script>
	jQuery(function(){
			setTimeout(function(){
					jQuery(".mbYTPVideo").YTPlayer({
					    useOnMobile: ' . $mbYTPlayer_is_active_for_mobile . ',
					    useNoCookie: ' . $mbYTPlayer_no_cookie . '
					})
			},' . $mbYTPlayer_init_delay . ');
		});
	</script>
	<!-- END -->';

    //Default homepage
    $mbYTPlayer_canPlayMovie = is_front_page() && is_home();

    //Static homepage
    if ($mbYTPlayer_video_page == "static")
        $mbYTPlayer_canPlayMovie = is_front_page();

    //Blog homepage
    else if ($mbYTPlayer_video_page == "blogindex")
        $mbYTPlayer_canPlayMovie = is_home();

    //Static and bolg homepage
    else if ($mbYTPlayer_video_page == "both")
        $mbYTPlayer_canPlayMovie = is_front_page() || is_home();

    // All pages
    else if ($mbYTPlayer_video_page == "all")
        $mbYTPlayer_canPlayMovie = true;

    echo '
    <!-- YTPlayer video settings
	    mbYTPlayer_version              = "' . MBYTPLAYER_PLUS_VERSION . '"
	    
	    mbYTPlayer_is_active            = "' . ($mbYTPlayer_is_active ? "true" : "false") . '"
	    mbYTPlayer_video_page           = "' . $mbYTPlayer_video_page . '"
	    mbYTPlayer_canPlayMovie         = "' . ($mbYTPlayer_canPlayMovie ? "true" : "false") . '"
	    mbYTPlayer_isMuted              = "' . ($mbYTPlayer_mute ? "true" : "false") . '"
	    mbYTPlayer_is_front_page        = "' . (is_front_page() ? "true" : "false") . '"
	    mbYTPlayer_ytpl_is_home         = "' . (is_home() ? "true" : "false") . '"
	    mbYTPlayer_is_active_for_mobile = "' . $mbYTPlayer_is_active_for_mobile . '"
	    mbYTPlayer_remember_last_time   = "' . $mbYTPlayer_remember_last_time . '"
	    mbYTPlayer_optimize_display     = "' . $mbYTPlayer_optimize_display . '"
	    mbYTPlayer_init_delay           = "' . $mbYTPlayer_init_delay . '"
	    mbYTPlayer_no_cookie            = "' . $mbYTPlayer_no_cookie . '"
	    mbYTPlayer_anchor               = "' . $mbYTPlayer_anchor . '"
	    mbYTPlayer_abundance            = "' . $mbYTPlayer_abundance . '"
	    mbYTPlayer_is_development_site  = "' . ($mbYTPlayer_is_development_site ? 'true' : 'false') . '"
	    
	    mbYTPlayer_lic_is_valid         = "' . (!empty($mbYTPlayer_license_key) ? 'true' : 'false') . '"
    -->';

    if ($mbYTPlayer_canPlayMovie && $mbYTPlayer_is_active) {

        if (empty($mbYTPlayer_video_url))
            return false;

        if ($mbYTPlayer_opacity > 1)
            $mbYTPlayer_opacity = $mbYTPlayer_opacity / 10;

        $vids = explode(',', $mbYTPlayer_video_url);
        $n = rand(0, count($vids) - 1);
        $mbYTPlayer_video_url_revised = $vids[$n];
        $mbYTPlayer_start_at = $mbYTPlayer_start_at > 0 ? $mbYTPlayer_start_at : 1;
        $player_id = $mbYTPlayer_custom_id ? $mbYTPlayer_custom_id : "bgndVideo_home";
        $abundanceValue = (string)($mbYTPlayer_abundance / 10);
        $abundanceValue = str_replace(",", ".", $abundanceValue);

        $mbYTPlayer_player_homevideo =
            '<div id=\"' . $player_id . '\" data-property=\"{' .
            'videoURL:\'' . $mbYTPlayer_video_url_revised . '\'' .
            ', mobileFallbackImage:\'' . $mbYTPlayer_fallbackimage . '\'' .
            ', coverImage:\'' . $mbYTPlayer_background_image . '\'' .
            ', opacity:' . $mbYTPlayer_opacity .
            ', autoPlay:' . $mbYTPlayer_autoplay .
            ', containment:\'body\'' .
            ', startAt:' . $mbYTPlayer_start_at .
            ', stopAt:' . $mbYTPlayer_stop_at .
            ', mute:' . $mbYTPlayer_mute .
            ', vol:' . $mbYTPlayer_audio_volume .
            ', showControls:' . $mbYTPlayer_show_controls .
            ', optimizeDisplay:' . $mbYTPlayer_optimize_display .
            ', printUrl:' . $mbYTPlayer_show_videourl .
            ', loop:' . $mbYTPlayer_loop .
            ', addRaster:' . $mbYTPlayer_add_raster .
            ', quality:\'' . $mbYTPlayer_quality . '\'' .
            ', ratio:\'' . $mbYTPlayer_ratio . '\'' .
            ', realfullscreen:' . $mbYTPlayer_realfullscreen .
            ', gaTrack:' . $mbYTPlayer_track_ga .
            ', stopMovieOnBlur:' . $mbYTPlayer_stop_on_blur .
            ', remember_last_time:' . $mbYTPlayer_remember_last_time .
            ', abundance:' . $abundanceValue . '' .
            ', anchor:\'' . $mbYTPlayer_anchor . '\'' .
            '}\"></div>';

        echo '
  <!-- START - mbYTPlayer settings video -->
    <script type="text/javascript">
    jQuery(function(){
        setTimeout(function(){
           var homevideo = "' . $mbYTPlayer_player_homevideo . '";
           jQuery("body").append(homevideo);
           jQuery("#' . $player_id . '").YTPlayer({
                useOnMobile: ' . $mbYTPlayer_is_active_for_mobile . ',
				useNoCookie: ' . $mbYTPlayer_no_cookie . '
			});
        },' . $mbYTPlayer_init_delay . ')
    })
    </script>
  <!-- END -->
  ';
    }
}

;

/**
 * Add root menu
 */
require_once("inc/mb-admin-menu.php");

/**
 * Add submenu
 */
add_action('admin_menu', 'mbytpplus_add_option_page');
function mbytpplus_add_option_page()
{
    add_submenu_page('mb-ideas-menu', 'YTPlayerPlus', 'YTPlayerPlus', 'manage_options', __FILE__, 'mbytpplus_options_page');
}

/**
 * Activation ajax action
 */
add_action('wp_ajax_mbytppro_activate', 'mbytppro_activate');
function mbytppro_activate()
{
    $activate = $_POST["activate"] ? 1 : 0;
    update_option('mbYTPlayer_is_active', $activate);
    echo json_encode(array("resp" => $activate));
}

/**
 * Activation on mobile ajax action
 */
add_action('wp_ajax_mbytppro_activate_on_mobile', 'mbytppro_activate_on_mobile');
function mbytppro_activate_on_mobile()
{
    $activate = $_POST["activate"] ? 1 : 0;
    update_option('mbYTPlayer_is_active_for_mobile', $activate);
    echo json_encode(array("resp" => $activate));
}

/**
 * Use no-cookie host
 */
add_action('wp_ajax_mbytppro_no_cookie', 'mbytppro_no_cookie');
function mbytppro_no_cookie()
{
    $activate = $_POST["activate"] ? "true" : "false";
    update_option('mbYTPlayer_no_cookie', $activate);
    echo json_encode(array("resp" => $activate));
}

/**
 * Set development environment
 */
add_action('wp_ajax_mbytppro_set_development', 'mbytppro_set_development');
function mbytppro_set_development()
{
    $set_development = $_POST["set_development"] ? 1 : 0;
    update_option('mbYTPlayer_is_development_site', $set_development);
    echo json_encode(array("resp" => $set_development));
}

/**
 * Register settings
 */
add_action('admin_init', 'mbytpplus_register_settings');
function mbytpplus_register_settings()
{

    if (defined('DOING_AJAX') && DOING_AJAX)
        return;

    //register YTPlayer settings
    register_setting('YTPlayer-settings-group', 'mbYTPlayer_version');
    register_setting('YTPlayer-settings-group', 'mbYTPlayer_is_active');
    register_setting('YTPlayer-settings-group', 'mbYTPlayer_is_active_for_mobile');
    register_setting('YTPlayer-settings-group', 'mbYTPlayer_video_url');
    register_setting('YTPlayer-settings-group', 'mbYTPlayer_video_page');

    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_show_controls');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_show_videourl');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_start_at');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_stop_at');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_audio_volume');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_mute');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_ratio');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_loop');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_opacity');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_quality');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_add_raster');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_realfullscreen');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_fallbackimage');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_stop_on_blur');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_custom_id');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_remember_last_time');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_init_delay');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_no_cookie');

    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_track_ga');

    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_autoplay');

    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_optimize_display');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_anchor');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_background_image');
    register_setting('YTPlayer-PLUS-group', 'mbYTPlayer_abundance');

    register_setting('YTPlayer-license-group', 'mbYTPlayer_license_key');
    register_setting('YTPlayer-license-group', 'mbYTPlayer_is_development_site');

}

/**
 * Output the options page
 */
function mbytpplus_options_page()
{
    global $mbYTPlayer_plus_price,
           $lic_domain,
           $link,
           $ytp_xxx,
           $ytp_core,
           $mbYTPlayer_custom_id,
           $is_in_development;

    $lic = $ytp_core->readLic();
    $exp_days = round((strtotime($lic["expire_on"]) - time()) / (60 * 60 * 24));
    ?>
    <style>
        input, select, textarea {
            font-size: 100%;
            border-radius: 5px;
            padding: 5px;
            font-weight: 700;
        }
    </style>
    <div class="wrap">
        <a href="https://pupunzi.com"><img style=" width: 350px"
                                           src="<?php echo plugins_url('images/logo.png', __FILE__); ?>"
                                           alt="Made by Pupunzi"/></a>

        <h2><?php _e('YTPlayer <strong>PLUS</strong>', 'wpmbytplayer'); ?></h2>
        <img style=" width: 150px; position: absolute; right: 0; top: 0; z-index: 100"
             src="<?php echo plugins_url('images/YTPL.svg', __FILE__); ?>" alt="YTPlayer icon"/>
        <?php
        $mbYTPlayer_key = esc_attr(get_option('mbYTPlayer_license_key'));
        ?>

        <?php if (empty($mbYTPlayer_key)) { ?>
            <hr>
            <!--
            mbYTPlayer_is_development_site
            --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
            <div valign="top" class="box <?php echo $is_in_development ? 'box-error' : '' ?>">
                <?php
                // reset mbYTPlayer_is_development_site option to 0
                if (!empty($mbYTPlayer_key) && get_option("mbYTPlayer_is_development_site") == 1) {
                    update_option('mbYTPlayer_is_development_site', 0);
                    $is_in_development = false;
                }
                ?>

                <h3><?php _e('Test mode', 'wpmbytplayer'); ?><?php echo $is_in_development ? _e('is active', 'wpmbytplayer') : "" ?></h3>
                <div>
                    <div class="onoffswitch">
                        <input class="onoffswitch-checkbox alert" type="checkbox" id="mbYTPlayer_is_development_site"
                               name="mbYTPlayer_is_development_site"
                               value="true" <?php if (get_option('mbYTPlayer_is_development_site')) {
                            echo ' checked="checked"';
                        } ?>/>
                        <label class="onoffswitch-label" for="mbYTPlayer_is_development_site"></label>
                    </div>
                    <p><?php _e('Activate the test mode to use the plugin without a license Key. <br>The plug-in will work with all the functionality for logged users with a watermark on the video.', 'wpmbytplayer'); ?></p>
                </div>
            </div>
            <hr>
        <?php } ?>

        <!-- ---------------------------—---------------------------—---------------------------—---------------------------
      License form box
      ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <div id="getLic" class="box box-success"
             style="display: <?php echo !$ytp_xxx || $is_in_development ? 'block' : 'none' ?>">
            <h3><?php _e('Get your <strong>Plus</strong> license to activate all the <strong>YTPlayer</strong> features!', 'wpmbytplayer'); ?></h3>
            <?php _e('You need a <b>license key</b> to remove the <b>watermark</b> from the video and to enable the <b>YTPlayer shortcode editor</b> for any page of your site.', 'wpmbytplayer'); ?>

            <form id="YTP-license-form" method="post" action="options.php" style="margin-top: 20px">
                <?php settings_fields('YTPlayer-license-group'); ?>
                <?php do_settings_sections('YTPlayer-license-group'); ?>

                <a target="_blank" href="<?php echo $link ?>" class="getKey">
                    <span><?php printf(__('Get your Key For <b>%s EUR</b> Only', 'wpmbytplayer'), $mbYTPlayer_plus_price["COM"]) ?></span>
                </a>
                <hr>
                <label for="mbYTPlayer_license_key"><?php echo _e('<strong>Have a key?</strong> Paste it here:', 'wpmbytplayer') ?></label><br>
                <input type="text" id="mbYTPlayer_license_key" name="mbYTPlayer_license_key"
                       value="<?php echo $mbYTPlayer_key ?>"
                       style="width:100%; max-width: 450px; padding: 10px; font-size: 200%"
                       placeholder="<?php _e('Your license key', 'wpmbytplayer'); ?>"/>
                <br>

                <div id="invalid_lic"
                     style="display: <?php echo !$ytp_core->validate_local_lic() && !empty($mbYTPlayer_key) ? "block" : "none" ?>; color: darkred">
                    <p class="invalid">
                        <?php
                        if ($ytp_core->isExpired($lic)) {
                            _e('This license seems Expired.<br>Try to validate it again or purchase a new one.', 'wpmbytplayer');
                        } else {
                            printf(__('This license seems not valid.<br>The license domain is <strong id="invalid_lic_domain">%s</strong> while your domain is <strong>%s</strong>.<br>Try to validate it again or change the associated domain.', 'wpthumbgallery'), ($lic["lic_domain"] ? $lic["lic_domain"] : "null"), $lic_domain);
                        }
                        ?>
                    </p>
                    <a href="javascript:void(0)" class="button"
                       onclick="jQuery(this).fadeOut(); change_domain('<?php echo $mbYTPlayer_key ?>', '<?php echo $lic_domain ?>')"><?php echo _e("Change associated domain", "wpthumbgallery") ?></a><br>
                    <span class="message" style="display: none"></span>
                </div>
                <br>
                <div id="license-save-bar">
                    <span class="message" style="display: none"></span>
                    <input type="submit"
                           value="<?php !$ytp_xxx ? _e('Validate', 'wpmbytplayer') : _e('Activate', 'wpmbytplayer') ?>"
                           class="validate button right"">
                </div>
                <br style="clear: both">
            </form>
        </div>

        <!-- ---------------------------—---------------------------—---------------------------—---------------------------
      Default settings box
      ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <form class="optForm" id="optionsForm" method="post" action="options.php">
            <h3><?php _e('General Background Video Settings', 'wpmbytplayer'); ?></h3>
            <?php settings_fields('YTPlayer-settings-group'); ?>
            <?php do_settings_sections('YTPlayer-settings-group'); ?>

            <table class="form-table">
                <!--
                mbYTPlayer_is_active
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Activate the background video', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_is_active"
                                   name="mbYTPlayer_is_active"
                                   value="true" <?php if (get_option('mbYTPlayer_is_active')) {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_is_active"></label>
                        </div>
                    </td>
                </tr>
                <!--
                mbYTPlayer_is_active_for_mobile
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Active also on mobile', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch" style="display: inline-block;">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_is_active_for_mobile"
                                   name="mbYTPlayer_is_active_for_mobile"
                                   value="true" <?php if (get_option('mbYTPlayer_is_active_for_mobile')) {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_is_active_for_mobile"></label>
                        </div>
                    </td>
                </tr>

                <!--
                mbYTPlayer_no_cookie
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Use no-cookie Host', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch" style="display: inline-block; vertical-align: top">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_no_cookie"
                                   name="mbYTPlayer_no_cookie"
                                   value="true" <?php if (get_option('mbYTPlayer_no_cookie')=="true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_no_cookie"></label>
                        </div>
                        <div style="display: inline;padding: 5px"><?php _e('Use no-cookie Host', 'wpmbytplayer'); ?></div>

                    </td>
                </tr>
            </table>

            <h3><?php _e('Homepage video background:', 'wpmbytplayer'); ?></h3>
            <!--
            mbYTPlayer_video_url
            --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"> <?php _e('The Youtube video url is:', 'wpmbytplayer'); ?></th>
                    <td>
                        <?php
                        $ytpl_video_url = get_option('mbYTPlayer_video_url');
                        $vids = explode(',', $ytpl_video_url);
                        $n = count($vids);
                        $n = $n > 2 ? 2 : $n;
                        $w = (480 / $n) - ($n > 1 ? (3 * $n) : 0);
                        $h = 315 / $n;
                        foreach ($vids as $vurl) {
                            $YouTubeCheck = preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $vurl, $matches);
                            if ($YouTubeCheck) {
                                $ytvideoId = $matches[0];
                                ?>
                            <iframe width="<?php echo $w ?>" height="<?php echo $h ?>" style="display: inline-block"
                                    src="https://www.youtube.com/embed/<?php echo $ytvideoId ?>?rel=0&amp;controls=0&amp;showinfo=0"
                                    frameborder="0" allowfullscreen></iframe><?php
                            }
                        } ?>
                        <textarea name="mbYTPlayer_video_url" style="width:100%"
                                  value="<?php echo esc_attr(get_option('mbYTPlayer_video_url')); ?>"><?php echo esc_attr(get_option('mbYTPlayer_video_url')); ?></textarea>

                        <p><?php _e('Copy and paste here the URL of the Youtube video you want as your homepage background. If you add more then one URL comma separated it will be chosen one randomly each time you reach the page', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_video_page
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('The page where to show the background video is:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="radio" name="mbYTPlayer_video_page"
                               value="static" <?php if (get_option('mbYTPlayer_video_page') == "static" || get_option('mbYTPlayer_video_page') == "") {
                            echo ' checked';
                        } ?> /> <?php _e('Static Homepage', 'wpmbytplayer'); ?><br>
                        <input type="radio" name="mbYTPlayer_video_page"
                               value="blogindex" <?php if (get_option('mbYTPlayer_video_page') == "blogindex") {
                            echo ' checked';
                        } ?>/> <?php _e('Blog index Homepage', 'wpmbytplayer'); ?> <br>
                        <input type="radio" name="mbYTPlayer_video_page"
                               value="both" <?php if (get_option('mbYTPlayer_video_page') == "both") {
                            echo ' checked';
                        } ?>/><?php _e('Both', 'wpmbytplayer'); ?> <br>
                        <input type="radio" name="mbYTPlayer_video_page"
                               value="all" <?php if (get_option('mbYTPlayer_video_page') == "all") {
                            echo ' checked';
                        } ?>/><?php _e('All pages', 'wpmbytplayer'); ?> <br>

                        <p><?php _e('Choose on which page you want the background video to be shown. If you check "All" you\'ll not be able to insert a page background video using the short-code', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save options') ?>"/>
            </p>

        </form>

        <!-- ---------------------------—---------------------------—---------------------------—---------------------------
      PLUS settings box
      ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <form class="optForm" id="PROForm" method="post" action="options.php"
              style="margin-top: 20px; opacity: <?php echo !$ytp_xxx ? '0.6' : '1' ?>">

            <h3><?php _e('Advanced settings', 'wpmbytplayer'); ?></h3>

            <?php settings_fields('YTPlayer-PLUS-group'); ?>
            <?php do_settings_sections('YTPlayer-PLUS-group'); ?>

            <p style="display:  <?php echo !$ytp_xxx ? 'block' : 'none' ?>">
                <?php _e('Activate the <strong>PLUS</strong> license to get all the features.', 'wpmbytplayer'); ?>
                <a href="<?php echo $link ?>" target="_blank"><?php echo _e("Get it now", "wpmbytplayer") ?></a>
            </p>

            <table id="Plus-settings" class="form-table">

                <!--
                mbYTPlayer_custom_id
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Custom ID:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="text" name="mbYTPlayer_custom_id" style="width: 50%"
                               value="<?php echo $mbYTPlayer_custom_id; ?>"/>

                        <p><?php _e('Set a custom ID (must be unique) you can refer to with the <a href="https://github.com/pupunzi/jquery.mb.YTPlayer/wiki#external-methods" target="_blank">API</a>', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_background_image
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Background image:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="text" id="mbYTPlayer_background_image" name="mbYTPlayer_background_image"
                               style="width: 50%" value="<?php echo get_option('mbYTPlayer_background_image'); ?>"/>
                        <input type="button" class="get-url-from-media button" value="Media"
                               data-for="mbYTPlayer_background_image">
                        <p><?php _e('Set the url for the background image', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_autoplay
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Auto play:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" onchange="check_if_is_muted()" type="checkbox"
                                   id="mbYTPlayer_autoplay" name="mbYTPlayer_autoplay"
                                   value="true" <?php if (get_option('mbYTPlayer_autoplay') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_autoplay"></label>
                        </div>
                        <p><?php _e('Set if the video should start playing once loaded', 'wpmbytplayer'); ?></p>
                        <p style="color:#c20020"><?php _e('The "autoPlay" will not work on Chrome browser if the audio is active due to the latest Youtube policy.', 'wpmbytplayer'); ?></p>
                        <script>
                            function check_if_is_muted() {
                                var mute = jQuery("#mbYTPlayer_mute");
                                var autoplay = jQuery("#mbYTPlayer_autoplay");
                                if (autoplay.is(":checked")) {
                                    mute.attr("checked", "checked");
                                }
                            }
                        </script>
                    </td>
                </tr>

                <!--
                mbYTPlayer_mute
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Mute the video:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_mute"
                                   name="mbYTPlayer_mute"
                                   value="true" <?php if (get_option('mbYTPlayer_mute') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_mute"></label>
                        </div>
                        <label for="mbYTPlayer_mute"><?php _e('Check to mute the audio of the video', 'wpmbytplayer'); ?></label>
                    </td>
                </tr>

                <!--
                mbYTPlayer_audio_volume
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Set the audio volume:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="text" name="mbYTPlayer_audio_volume"
                               value="<?php echo esc_attr(get_option('mbYTPlayer_audio_volume')) ?>" style="width:10%"/>

                        <p><?php _e('Set the volume for the video (from 0 to 100)', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_fallbackimage
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <!--
        <tr valign="top">
          <th scope="row"><?php _e('Fallback image url:', 'wpmbytplayer'); ?></th>
          <td>
            <input type="text" id="mbYTPlayer_fallbackimage" name="mbYTPlayer_fallbackimage" style="width: 50%" value="<?php echo esc_attr(get_option('mbYTPlayer_fallbackimage')); ?>"/> <input type="button" class="get-url-from-media button" value="Media"
                                                                                                                                                                                                 data-for="mbYTPlayer_fallbackimage">
            <p><?php _e('Set the background image url to be used on mobile devices', 'wpmbytplayer'); ?></p>
          </td>
        </tr>
        -->
                <!--
               mbYTPlayer_opacity
               --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Set the opacity:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="text" name="mbYTPlayer_opacity" style="width:10%"
                               value="<?php echo esc_attr(get_option('mbYTPlayer_opacity')); ?>"/>

                        <p><?php _e('Set the opacity of the background video (from 0 to 10)', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_quality (deprecated by Youtube and never used anymore)
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <!--
        <tr valign="top">
          <th scope="row"><?php /*_e('Set the quality:', 'wpmbytplayer'); */
                ?></th>
          <td>
            <select name="mbYTPlayer_quality">
              <option value="default" <?php /*if (get_option('mbYTPlayer_quality') == "default") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('default', 'wpmbytplayer'); */
                ?></option>
              <option value="small" <?php /*if (get_option('mbYTPlayer_quality') == "small") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('small', 'wpmbytplayer'); */
                ?></option>
              <option value="medium" <?php /*if (get_option('mbYTPlayer_quality') == "medium") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('medium', 'wpmbytplayer'); */
                ?></option>
              <option value="large" <?php /*if (get_option('mbYTPlayer_quality') == "large") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('large', 'wpmbytplayer'); */
                ?></option>
              <option value="hd720" <?php /*if (get_option('mbYTPlayer_quality') == "hd720") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('hd720', 'wpmbytplayer'); */
                ?></option>
              <option value="hd1080" <?php /*if (get_option('mbYTPlayer_quality') == "hd1080") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('hd1080', 'wpmbytplayer'); */
                ?></option>
              <option value="highres" <?php /*if (get_option('mbYTPlayer_quality') == "highres") {
				  echo ' selected';
			  } */
                ?> ><?php /*_e('highres', 'wpmbytplayer'); */
                ?></option>
            </select>

            <p><?php /*_e('Set the quality of the background video ("default" YouTube selects the appropriate playback quality)', 'wpmbytplayer'); */
                ?></p>
          </td>
        </tr>
-->
                <!--
                mbYTPlayer_ratio
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Set the aspect ratio:', 'wpmbytplayer'); ?></th>
                    <td>
                        <select name="mbYTPlayer_ratio">
                            <option value="auto" <?php if (get_option('mbYTPlayer_ratio') == "auto") {
                                echo ' selected';
                            } ?> ><?php _e('auto', 'wpmbytplayer'); ?></option>
                            <option value="4/3" <?php if (get_option('mbYTPlayer_ratio') == "4/3") {
                                echo ' selected';
                            } ?> ><?php _e('4/3', 'wpmbytplayer'); ?></option>
                            <option value="16/9" <?php if (get_option('mbYTPlayer_ratio') == "16/9") {
                                echo ' selected';
                            } ?>><?php _e('16/9', 'wpmbytplayer'); ?></option>
                        </select>

                        <p><?php _e('Set the aspect-ratio of the background video. If "auto" the plug in will try to retrieve the aspect ratio from Youtube. If you have problems on viewing the background video try setting this manually.', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_start_at
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('The video should start at:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="text" name="mbYTPlayer_start_at" style="width:10%"
                               value="<?php echo esc_attr(get_option('mbYTPlayer_start_at')); ?>"/>

                        <p><?php _e('Set the seconds the video should start at', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_stop_at
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('The video should stop at:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="text" name="mbYTPlayer_stop_at" style="width:10%"
                               value="<?php echo esc_attr(get_option('mbYTPlayer_stop_at')); ?>"/>

                        <p><?php _e('Set the seconds the video should stop at', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_show_controls
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Show the control bar:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" id="mbYTPlayer_show_controls"
                                   onclick="videoUrlControl()" type="checkbox" id="mbYTPlayer_show_controls"
                                   name="mbYTPlayer_show_controls"
                                   value="true" <?php if (get_option('mbYTPlayer_show_controls') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_show_controls"></label>
                        </div>
                        <label for="mbYTPlayer_show_controls"><?php _e('Check to show controls at the bottom of the page', 'wpmbytplayer'); ?></label>

                        <div id="videourl" style="display: none; margin-top: 10px">
                            <input id="mbYTPlayer_show_videourl" type="checkbox" name="mbYTPlayer_show_videourl"
                                   value="true" <?php if (get_option('mbYTPlayer_show_videourl') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label for="mbYTPlayer_show_videourl"><?php _e('Check to show the link to the original YouTube® video', 'wpmbytplayer'); ?></label>
                        </div>
                        <script>
                            function videoUrlControl() {
                                if (jQuery("#mbYTPlayer_show_controls").is(":checked")) {
                                    jQuery("#videourl").show();
                                } else {
                                    jQuery("#mbYTPlayer_show_videourl").attr("checked", false).val(false);
                                    jQuery("#videourl").hide();
                                }
                            }

                            videoUrlControl();
                        </script>
                    </td>
                </tr>

                <!--
                mbYTPlayer_optimize_display
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Optimize display:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" name="mbYTPlayer_optimize_display"
                                   id="mbYTPlayer_optimize_display"
                                   value="true" <?php if (get_option('mbYTPlayer_optimize_display') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_optimize_display"></label>
                        </div>
                        <p><?php _e('Optimize the display of the video to cover the containment area', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>

                <!--
                mbYTPlayer_anchor
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top" id="anchor-set" style="display: none">
                    <th scope="row"><?php _e('Anchor:', 'wpmbytplayer'); ?></th>
                    <td style="position: relative; height: 120px; vertical-align: top">
                        <select name="mbYTPlayer_anchor">

                            <option value="center,center" <?php if (get_option('mbYTPlayer_anchor') == "center,center") {
                                echo ' selected';
                            } ?> ><?php _e('center,center', 'wpmbytplayer'); ?></option>
                            <option value="center,left" <?php if (get_option('mbYTPlayer_anchor') == "center,left") {
                                echo ' selected';
                            } ?> ><?php _e('center,left', 'wpmbytplayer'); ?></option>
                            <option value="center,right" <?php if (get_option('mbYTPlayer_anchor') == "center,right") {
                                echo ' selected';
                            } ?> ><?php _e('center,right', 'wpmbytplayer'); ?></option>

                            <option value="top,left" <?php if (get_option('mbYTPlayer_anchor') == "top,left") {
                                echo ' selected';
                            } ?> ><?php _e('top,left', 'wpmbytplayer'); ?></option>
                            <option value="top,center" <?php if (get_option('mbYTPlayer_anchor') == "top,center") {
                                echo ' selected';
                            } ?> ><?php _e('top,center', 'wpmbytplayer'); ?></option>
                            <option value="top,right" <?php if (get_option('mbYTPlayer_anchor') == "top,right") {
                                echo ' selected';
                            } ?> ><?php _e('top,right', 'wpmbytplayer'); ?></option>

                            <option value="bottom,left" <?php if (get_option('mbYTPlayer_anchor') == "bottom,left") {
                                echo ' selected';
                            } ?> ><?php _e('bottom,left', 'wpmbytplayer'); ?></option>
                            <option value="bottom,center" <?php if (get_option('mbYTPlayer_anchor') == "bottom,center") {
                                echo ' selected';
                            } ?> ><?php _e('bottom,center', 'wpmbytplayer'); ?></option>
                            <option value="bottom,right" <?php if (get_option('mbYTPlayer_anchor') == "bottom,right") {
                                echo ' selected';
                            } ?> ><?php _e('bottom,right', 'wpmbytplayer'); ?></option>

                        </select>
                        <p><?php _e('Set the anchor point for the video', 'wpmbytplayer'); ?></p>
                        <div id="anchor_img"
                             style="position: absolute; top:0; right: 0; width: 280px; height: 150px; background: url('<?php echo plugin_dir_url(__FILE__) ?>/images/anchor/<?php echo get_option('mbYTPlayer_anchor') ?>.jpg') top right no-repeat; background-size: contain"></div>
                        <script>
                            jQuery("[name=mbYTPlayer_anchor]").on("change", function () {
                                jQuery("#anchor_img").css({backgroundImage: "url('<?php echo plugin_dir_url(__FILE__) ?>/images/anchor/" + jQuery(this).val() + ".jpg')"});
                            });

                            jQuery("[name=mbYTPlayer_optimize_display]").on("change", function () {
                                if (jQuery(this).is(":checked")) {
                                    jQuery("#anchor-set").show();
                                } else {
                                    jQuery("#anchor-set").hide();
                                }
                            });

                            if (jQuery("#mbYTPlayer_optimize_display").is(":checked")) {
                                jQuery("#anchor-set").show();
                            }

                        </script>
                    </td>
                </tr>
                <!--
                mbYTPlayer_abundance
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Abundance:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="number" min="0" max="10" name="mbYTPlayer_abundance" style="width:20%"
                               value="<?php echo esc_attr(get_option('mbYTPlayer_abundance')); ?>"/>
                        <p><?php _e('Set the abundance for the video in percentage of the size', 'wpmbytplayer'); ?></p>
                    </td>
                </tr>


                <!--
                mbYTPlayer_realfullscreen
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('The full screen behavior is:', 'wpmbytplayer'); ?></th>
                    <td>
                        <input type="radio" id="mbYTPlayer_realfullscreen" name="mbYTPlayer_realfullscreen"
                               value="true" <?php if (get_option('mbYTPlayer_realfullscreen') == "true") {
                            echo ' checked="checked"';
                        } ?>/>
                        <label for="mbYTPlayer_realfullscreen"><?php _e('Full screen containment is the screen', 'wpmbytplayer'); ?></label>

                        <div style=" margin-top: 10px">
                            <input type="radio" id="mbYTPlayer_browserfullscreen" name="mbYTPlayer_realfullscreen"
                                   value="false" <?php if (get_option('mbYTPlayer_realfullscreen') == "false") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label for="mbYTPlayer_browserfullscreen"><?php _e('Full screen containment is the browser window', 'wpmbytplayer'); ?></label>
                        </div>
                    </td>
                </tr>

                <!--
                mbYTPlayer_loop
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('The video should loop:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_loop"
                                   name="mbYTPlayer_loop"
                                   value="true" <?php if (get_option('mbYTPlayer_loop') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_loop"></label>
                        </div>
                        <label for="mbYTPlayer_loop"><?php _e('Check to loop the video once ended', 'wpmbytplayer'); ?></label>
                    </td>
                </tr>

                <!--
                mbYTPlayer_add_raster
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Add the raster image:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_add_raster"
                                   name="mbYTPlayer_add_raster"
                                   value="true" <?php if (get_option('mbYTPlayer_add_raster') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_add_raster"></label>
                        </div>
                        <label for="mbYTPlayer_add_raster"><?php _e('Check to add a raster effect to the video', 'wpmbytplayer'); ?></label>
                </tr>

                <!--
                mbYTPlayer_stop_on_blur
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Pause the player on window blur:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_stop_on_blur"
                                   name="mbYTPlayer_stop_on_blur"
                                   value="true" <?php if (get_option('mbYTPlayer_stop_on_blur') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_stop_on_blur"></label>
                        </div>
                        <label for="mbYTPlayer_stop_on_blur"><?php _e('Check to pause the player once the window blur', 'wpmbytplayer'); ?></label>
                    </td>
                </tr>

                <!--
                mbYTPlayer_remember_last_time
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top">
                    <th scope="row"><?php _e('Remember last video time position:', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_remember_last_time"
                                   name="mbYTPlayer_remember_last_time"
                                   value="true" <?php if (get_option('mbYTPlayer_remember_last_time') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_remember_last_time"></label>
                        </div>
                        <label for="mbYTPlayer_remember_last_time"><?php _e('Check to start the video from the where you left last time', 'wpmbytplayer'); ?></label>
                    </td>
                </tr>

                <!--
                mbYTPlayer_track_ga
                ---------------------------—---------------------------—---------------------------—---------------------------— -->
                <tr valign="top">
                    <th scope="row"><?php _e('Track the video views on Google Analytics', 'wpmbytplayer'); ?></th>
                    <td>
                        <div class="onoffswitch">
                            <input class="onoffswitch-checkbox" type="checkbox" id="mbYTPlayer_track_ga"
                                   name="mbYTPlayer_track_ga"
                                   value="true" <?php if (get_option('mbYTPlayer_track_ga') == "true") {
                                echo ' checked="checked"';
                            } ?>/>
                            <label class="onoffswitch-label" for="mbYTPlayer_track_ga"></label>
                        </div>
                        <label for="mbYTPlayer_track_ga"><?php _e('Check to track this video on Google Analytics if played', 'wpmbytplayer'); ?></label>
                    </td>
                </tr>

                <!--
                mbYTPlayer_init_delay
                --------------------–--------------------–--------------------–--------------------–--------------------–------- -->
                <tr valign="top" style="background: #ffd8d7">
                    <td colspan="2">
                        <div style="font-weight: normal; color: #a00102; text-transform: uppercase"><?php _e('Red zone!', 'wpmbytplayer') ?></div>
                        <div
                                style="margin-top: 10px"><?php _e('<strong>Rarely there could be a conflict with a theme or a plugins</strong> that prevent the player to be initialized; adding a delay to the initialize event could solve the problem. This option will delay the start of the video, use it only if you need.', 'wpmbytplayer'); ?></div>
                        <div style="font-weight: 100; margin-top: 10px"><?php _e('This is a global option and will affect any player in any page', 'wpmbytplayer'); ?></div>
                    </td>
                </tr>
                <tr valign="top" style="background: #ffd8d7">
                    <th scope="row"><?php _e('Time to wait before initialization:', 'wpmbytplayer'); ?></th>
                    <td>
                        <select id="mbYTPlayer_init_delay" name="mbYTPlayer_init_delay">
                            <option value="0" <?php echo(get_option('mbYTPlayer_init_delay') == 0 ? "selected" : "") ?>><?php _e('none', 'wpmbytplayer'); ?></option>
                            <option value="1000" <?php echo(get_option('mbYTPlayer_init_delay') == 1000 ? "selected" : "") ?>>
                                1 sec.
                            </option>
                            <option value="1500" <?php echo(get_option('mbYTPlayer_init_delay') == 1500 ? "selected" : "") ?>>
                                1.5 sec.
                            </option>
                            <option value="2000" <?php echo(get_option('mbYTPlayer_init_delay') == 2000 ? "selected" : "") ?>>
                                2 sec.
                            </option>
                            <option value="3000" <?php echo(get_option('mbYTPlayer_init_delay') == 3000 ? "selected" : "") ?>>
                                3 sec.
                            </option>
                        </select>
                        <label for="mbYTPlayer_init_delay"
                               style="display: block"><?php _e('Add a delay in seconds for the player initialization<br>(most times it needs 2 sec.)', 'wpmbytplayer'); ?></label>
                    </td>
                </tr>

            </table>

            <p class="submit"><input type="submit" class="button<?php echo !$ytp_xxx ? '' : '-primary' ?>"
                                     value="<?php _e('Save Advanced options', 'wpmbytplayer') ?>" <?php echo !$ytp_xxx ? "disabled" : "" ?> />
            </p>
            <span class="message" style="display: none"></span>
        </form>

        <!--
        Activation script
        ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <script>
            jQuery(function () {

                var activate = jQuery("#mbYTPlayer_is_active");
                activate.on("change", function () {
                    var val = this.checked ? 1 : 0;

                    jQuery.ajax({
                        type: "post",
                        dataType: "json",
                        url: ajaxurl,
                        data: {action: "mbytppro_activate", activate: val},
                        success: function (resp) {
                        }
                    })
                });

                var activate_on_mobile = jQuery("#mbYTPlayer_is_active_for_mobile");
                activate_on_mobile.on("change", function () {
                    var val = this.checked ? 1 : 0;

                    jQuery.ajax({
                        type: "post",
                        dataType: "json",
                        url: ajaxurl,
                        data: {action: "mbytppro_activate_on_mobile", activate: val},
                        success: function (resp) {
                            //console.debug(resp)
                        }
                    })
                });

                var no_cookie = jQuery("#mbYTPlayer_no_cookie");
                no_cookie.on("change", function () {
                    var val = this.checked ? 1 : 0;

                    jQuery.ajax({
                        type: "post",
                        dataType: "json",
                        url: ajaxurl,
                        data: {action: "mbytppro_no_cookie", activate: val},
                        success: function (resp) {
                        }
                    })
                });

                var is_development = jQuery("#mbYTPlayer_is_development_site");
                is_development.on("change", function () {
                    var val = this.checked ? 1 : 0;
                    console.debug("is_development::", val);
                    jQuery.ajax({
                        type: "POST",
                        // dataType: "json",
                        url: ajaxurl,
                        data: {action: "mbytppro_set_development", set_development: val},
                        success: function (resp) {
                            //console.debug("is_development::", resp);
                            self.location.reload();
                        }
                    })
                })
            });

            jQuery('#PROForm').submit(function () {
                var msg_box = jQuery(".message", this);
                show_message(msg_box, "Saving advanced options", 3000, "warning");
                var b = jQuery(this).serialize();
                jQuery.post('options.php', b).error(
                    function () {
                        show_message(msg_box, "Error saving options", 3000, "error");
                    }).success(function () {
                    show_message(msg_box, "Options have been saved successfully", 3000, "success", function () {
                        jQuery("#optionsForm").submit();
                    });
                });
                return false;
            });
        </script>
    </div>

    <!-- ---------------------------—---------------------------—---------------------------—---------------------------
  Right column
  ---------------------------—---------------------------—---------------------------—---------------------------— -->
    <div class="rightCol">

        <!--
        License info box
        ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <div id="validLic" class="box box-success"
             style="display: <?php echo !empty($mbYTPlayer_key) ? 'block' : 'none' ?>">
            <h3><?php _e('Your license:', 'wpmbytplayer'); ?></h3>
            <?php _e('This copy of <strong>YTPlayer Plus</strong> is registered.', 'wpmbytplayer'); ?>

            <?php
            if ($mbYTPlayer_key) {
                $registered_to = $lic["user_mail"];
                $lic_domain = $lic["lic_domain"];
                $lic_theme = $lic["lic_theme"];
                ?>
                <div>
                    <strong>Registered to</strong>: <span id="registered_to"><?php echo $registered_to ?></span><br>
                    <?php if ($lic["lic_type"] == "DEV") { ?>
                        <strong>For the theme</strong>: <span id="lic_theme"><?php echo $lic_theme ?></span>
                    <?php } else { ?>
                        <strong>For the domain</strong>: <span id="lic_domain"><?php echo $lic_domain ?></span>
                    <?php } ?>
                    <br>
                    <br>
                    <strong>KEY: <span id="lic_key"
                                       class="<?php echo (!empty($mbYTPlayer_key) && !$ytp_xxx) ? "invalid" : "valid" ?>"><?php echo $mbYTPlayer_key ?></span></strong>
                    <br>
                    <?php
                    if ($exp_days < 30) {
                        ?>
                        <strong>IT WILL EXPIRE IN</strong>: <span id="lic_exp_days"><?php echo $exp_days ?> DAYS</span>
                        <?php
                    }
                    ?>
                </div>
            <?php } ?>
        </div>

        <!--
        Info box
        ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <div class="box">
            <h3><?php _e('Thanks for purchasing <b>YTPlayer Plus</b>!', 'wpmbytplayer'); ?></h3>
            <p>
                <?php printf(__('You\'re using YTPlayer v. <b>%s</b>', 'wpmbytplayer'), MBYTPLAYER_PLUS_VERSION); ?>
                <br><?php _e('by', 'wpmbytplayer'); ?> <a href="https://pupunzi.com">mb.ideas (Pupunzi)</a>
            </p>
            <hr>
            <h3><?php _e('See the documentation', 'wpmbytplayer'); ?>:</h3>
            <p><a href="https://pupunzi.com/wpPlus/doc/public/YTPlayer-Doc/" target="_blank">https://pupunzi.com/wpPlus/doc/public/YTPlayer-Doc</a>
            </p>
            <hr>
            <p>
                <?php _e('Don’t forget to follow me on twitter', 'wpmbytplayer'); ?>: <a
                        href="https://twitter.com/pupunzi" target="_blank">@pupunzi</a><br>
                <?php _e('Visit Open lab site', 'wpmbytplayer'); ?>: <a href="https://open-lab.com" target="_blank">https://open-lab.com</a><br>
                <?php _e('Visit my site', 'wpmbytplayer'); ?>: <a href="https://pupunzi.com" target="_blank">https://pupunzi.com</a><br>
                <?php _e('Visit my blog', 'wpmbytplayer'); ?>: <a href="https://pupunzi.open-lab.com" target="_blank">https://pupunzi.open-lab.com</a><br><br>
                <?php _e('Need support', 'wpmbytplayer'); ?>? <a
                        href="https://pupunzi.open-lab.com/wordpress-plug-in-support/" target="_blank">https://pupunzi.open-lab.com/support</a><br>
            <hr>
            <!--
               MailChimp Signup Form
               ---------------------------—---------------------------—---------------------------—---------------------------— -->
            <form action="http://pupunzi.us6.list-manage2.com/subscribe/post?u=4346dc9633&amp;id=91a005172f"
                  method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate"
                  target="_blank" novalidate>
                <label for="mce-EMAIL"><?php _e('Subscribe to my mailing list <br>to stay in touch', 'wpmbytplayer'); ?>
                    :</label>
                <br>
                <br>
                <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL"
                       placeholder="<?php _e('your email address', 'wpmbytplayer'); ?>" required>
                <input type="submit" value="<?php _e('Subscribe', 'wpmbytplayer'); ?>" name="subscribe"
                       id="mc-embedded-subscribe" class="button">
            </form>

            <hr>

            <!-- ---------------------------—---------------------------—---------------------------—---------------------------
            SHARE
            ---------------------------—---------------------------—---------------------------—---------------------------— -->
            <div id="share" style="margin-top: 10px; min-height: 80px">
                <a href="https://twitter.com/share" class="twitter-share-button"
                   data-url="http://wordpress.org/extend/plugins/wpmbytplayer/"
                   data-text="I'm using the YTPlayer WP plugin for background videos" data-via="pupunzi"
                   data-hashtags="HTML5,wordpress,plugin">Tweet</a>
                <script>!function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (!d.getElementById(id)) {
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//platform.twitter.com/widgets.js";
                            fjs.parentNode.insertBefore(js, fjs);
                        }
                    }(document, "script", "twitter-wjs");</script>
                <div id="fb-root"></div>
                <script>(function (d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s);
                        js.id = id;
                        js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div style="margin-top: 10px" class="fb-like"
                     data-href="http://wordpress.org/extend/plugins/wpmbytplayer/" data-send="false"
                     data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
            </div>
        </div>

        <!--
        ADVs box
       ---------------------------—---------------------------—---------------------------—---------------------------— -->
        <div id="ADVs" class="box"></div>

    </div>

    <!-- ---------------------------—---------------------------—---------------------------—---------------------------
    ADVs script
    ---------------------------—---------------------------—---------------------------—---------------------------— -->
    <script>
        jQuery.ajax({
            type: "post",
            dataType: "html",
            url: "https://pupunzi.com/wpPlus/advs.php",
            data: {plugin: "YTPL", type: 'small'},
            success: function (resp) {
                jQuery("#ADVs").html(resp);
            }
        })
    </script>
    <?php
}

/**
 * Auto update
 * plugin-update-checker 4
 */
require_once 'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://pupunzi.com/wpPlus/wp-plugins/YTPL/YTPL.json',
    __FILE__,
    'wp-ytplayer-plus'
);
