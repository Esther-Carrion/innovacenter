=== mb.YTPlayer for background videos ===

Contributors: pupunzi
Tags: video player, youtube, full background, video, HTML5, flash, mov, jquery, pupunzi, mb.components, cover video, embed, embed videos, embed youtube, embedding, plugin, shortcode, video cover, video HTML5, youtube, youtube embed, youtube player, youtube videos
Requires at least: 3.0
Tested up to: 5.5
Stable tag:  3.5.7
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=DSHAHSJJCQ53Y
License: GPLv2 or later

3.6.0:
Bug fix:
		• If an error is thrown while retrieving data from server there was a fatal error preventing the plugin to work.

3.5.9:
Bug fix:
		• Fixed an error with the mb.ideas menu.

3.5.8::
Bug Fix:
		• Fixed a possible fatal error caused by the mb.ideas menu definition.

3.5.7::
Update:
		• The license now validate using the Wordpress wp_remote_post call to the server instead of the Curl method.

3.5.6::
Bug Fix:
		• The plugin updater was firing a warning for strpos() compatibility issue with PHP 7+.

3.5.5::
Bug Fix:
		• The Gutenberg block element didn't work due to a bug introduced with the previous update.

3.5.4::
Feature:
		• The plugin now supports the https://www.youtube-nocookie.com host to remove the Youtube cookies.
		• Defined a better behaviour If you've set the autoplay option of a video that has the audio active: Instead of starting the video at the first user interaction with the page, now the video start playing mute and the audio is activated with the first user interaction.

3.5.3::
Bug fix:
		• Bug Fix: With the latest maOS Big Sur system update the User Agent has been changed and the OS detection was failing on Safari causing a blocking error.

3.5.1::
Bug fix:
		• Fixed a blocking bug for servers that display decimals using comma.

3.5.0::
New feature:
    • If you set the player as inline (via the short-code editor) you can now activate the "Go Full Screen on Play" feature.
Bug fix:
		• The inline Player "Play" icon was not working properly.

3.4.9::
Bug Fix:
    • Solved a fatal error if called via WP-CLI.

3.4.8::
Update:
    • Removed the "quality" parameter as it is deprecated in the YT API and never more used. YouTube now adjusts the quality of your video stream based on your viewing conditions.

3.4.7::
Update:
    • Updated with the latest mb.YTPlayer.js that fixes a bug if the wrong YT API key is used.

3.4.6::
Bug fix:
    • Fixed a problem with the mb_notice class that in some cases was causing a blocking error.

3.4.5::
Bug fix:
    • On mobile Chrome browser the size of the background video was broken on orientation change.

3.4.4::
Feature:
    • You can now test the plugin in development on a localhost server using 127.0.0.1 environment.

3.4.3::
Bug fix:
    • Dom fix.

3.4.2::
Bug fix:
    • The cover-image property was removing the original background image also if it was not set.

3.4.1::
Bug fix:
    • The anchor point of the video was not properly set by the OptimizeDisplay method if the abundance was higher then 0.

3.4.0::
Update:
    • Gutemberg ready: Added a YTPlayer Gutemberg block for the new Wordpress editor available under the mb.ideas Blocks section in the Block menu.

3.3.9::
Bug fix:
    • On Safari the video didn't auto play.
    • the mute option didn't work.
    • The optimizeDisplay method was not working properly.

3.3.8::
Bug fix:
    • The startAt option didn't work as aspected with the last Chrome release.

3.3.6::
Bug fix:
    • Changed the name of the jQuery.browser object to jQuery.mbBrowser to prevent rare conflicts.
    • bug-fix: if the plug-in is activated the test-mode get disabled.

3.3.5::
Bug fix:
    • the autoPlay was always active for background videos.

3.3.4::
1. Bug fix:
    • If there were two or more instances of a player on a page options were overwritten for all.
2. New feature:
    • The mobile fallback image and the cover image can be chosen via the media chooser both on the settings page and the short-code editor.

3.3.3::
1. New feature:
    • You can now activate the "Test mode" to use the plugin on development; this option let the plug-in work without a license key for all logged users;
      useful to test it and to use it on a development environment.

3.3.2::
1. Bug fix:
    • Video some times didn't start on Safari.

3.3.1::
1. new feature:
    • Added new "Optimize display" property to choose if the video should cover entirely the containment area or if it should be contained;
    • Added new "Abundance" property to set the margin for the video abundance;
    • Added new "Anchor" property to set the point of the containment where the video should be anchored;
2. Updated to the latest jquey.mb.YTPlayer.js file.

3.3.0::
1. Update: updated to the latest javascript version.

3.2.9::
1. Bug fix: Fixed a bug that was preventing the correct behavior if the "Remember last video time position" was checked.

3.2.8::
1. Bug fix: The control bar display setting was not applied.

3.2.7::
1. Bug fix: There was an error that was preventing the plug-in to work.

3.2.6::
1. New feature: Add "Active on mobile" option.

3.2.5::
1. Improve: the "delay" option for the initialization is now in seconds.

3.2.4::
1. New feature: Rarely there could be conflicts with other plugin or theme on player initialization. I add a delay option that can solve those incompatibilities.

3.2.3::
1. Bug fix: fixed a bug that was preventing the correct initialization of the component on certain mobile devices.

3.2.2::
1. Bug fix: fixed a bug that was preventing the correct initialization of the component.

3.2.1::
1. Bug fix: fixed a bug that was preventing the correct initialization of the component.

3.2.0::
1. New feature: Now you can play the background video also on mobile device.

3.1.90::
1. Updates: Added a new option to remember the video time elapse next time you enter the page.

3.1.85::
1. Bug fix: removed a debug text left in the last release.

3.1.8::
1. Bug fix: In some cases the short-code editor didn't work firing a javascript error .

3.1.7::
1. Updates: better performances and some changes in the admin panel.

3.1.6::
1. Updates: Updated to the latest version of the jquery.mb.YTPlayer.js file (3.0.20) fixing a error if viewed on mobile devices; updated the PLUS box.

3.1.5::
1. Bug fix: There was an error on the OS detection method.

3.1.4::
1. Better check if is static home or if is blog home method and introduced debug variables to check the correct state.

3.1.3::
1. Bug fix: The short-code wos not working anymore.

3.1.2::
1. Bug fix: There was an hack for Safari freeze that is not needed anymore with the latest safari release (it was breaking the plugin on Safari).

3.1.1::
1. Bug fix: there was an error deleting the unused options.

3.0.10::
1. New feature: Added video thumbnails on plug-in settings page.
2. Update: Updated mb.YTPlayer.js to the latest version.

3.0.9::
1. New feature: In the post/page editor you can edit the short-code by clicking on the short-code placeholder.
2. New feature: You can now set a custom ID for each player that you can refer to using the API (https://github.com/pupunzi/jquery.mb.YTPlayer/wiki#external-methods).
3. bug fix: some minor fix.

3.0.8::
1. New feature: the short code editor button is outside the TinyMCE so you can use it also in text modality.
2. bug fix: The verification process failed if on Wrdpress multisite.

3.0.7::
1. bug fix: The plug-in could not be activated in development if the port was different then 80.
2. bug fix: On certain server the SERVER_NAME is not defined. In that case now it takes the SITE_NAME as unique association param for the license.
3. Bug fix: The short code generator window could be broken with certain PHP server configurations.
