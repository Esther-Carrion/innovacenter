<?php
/**
 * The template for displaying the footer
 *
 * @package Catch Themes
 * @subpackage Parallax Frame
 * @since Parallax Frame 0.1
 */
?>

<?php
    /**
     * parallax_frame_after_content hook
     *
     * @hooked parallax_frame_content_end - 20
     * @hooked parallax_frame_featured_content_display (move featured content below homepage posts) - 30
     *
     */
    do_action( 'parallax_frame_after_content' );
?>

<?php
    /**
     * parallax_frame_footer hook
     *
     * @hooked parallax_frame_footer_content_start - 10
     * @hooked parallax_frame_footer_sidebar - 20
     * @hooked parallax_frame_footer_menu - 40
     * @hookedparallax_frame_footer_content - 50
     * @hooked parallax_frame_footer_content_end - 90
     * @hooked parallax_frame_page_end - 100
     *
     */
    do_action( 'parallax_frame_footer' );
?>

<?php
/**
 * parallax_frame_after hook
 *
 * @hooked parallax_frame_scrollup - 10
 * @hooked parallax_frame_mobile_menus- 20
 *
 */
do_action( 'parallax_frame_after' );?>

<?php wp_footer(); ?>

</body>
</html>