<?php

/**
 * YTPLayer Gutemberg block
 *  Copyright (c) 2001-2018. Matteo Bicocchi (Pupunzi)
 */

function ytp_block_init()
{
    /**
     * Check if Gutemberg is active
     */
    if (!function_exists('register_block_type'))
        return;

    /**
     * Register our block editor script
     */
    wp_register_script(
        'ytpl-block',
        plugins_url( 'ytp-block.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' )
    );

    /**
     * Register our block, and explicitly define the attributes we accept
     */
    register_block_type( 'ytplayer/ytpl-block', array(

        /** Define the attributes used in your block */
        'attributes'      => array(
            'ytp_shortcode' => array(
                'type' => 'string',
            ),
            'ytp_urls' => array(
                'type' => 'string',
            ),
            'ytp_containment' => array(
                'type' => 'string',
            )
        ),

        /** Define the category for your block */
        'category' => 'mb.ideas',

        /** The script name we gave in the wp_register_script() call */
        'editor_script'   => 'ytpl-block',

        /** The callback called by the javascript file to render the block */
        'render_callback' => 'ytp_block_render',
    ) );

}
add_action( 'init', 'ytp_block_init' );

/**
 * Define the server side callback to render your block in the front end
 *
 * @param $attributes
 * @return string
 * @param array $attributes The attributes that were set on the block or shortcode.
 */
function ytp_block_render( $attributes )
{
    global $ytp_plugin_base;

    /** @var  $is_in_edit_mode  Check if we are in the editor */
    $is_in_edit_mode = strrpos($_SERVER['REQUEST_URI'], "context=edit");
    $UID = rand(0, 10000);

    /** If we are in the editor */
    if ($is_in_edit_mode) {

        /** If the specific attribute exist (it's not new) */
        if($attributes['ytp_shortcode']){
            $content = '<img class="YTPlayer-editor" id="YTPlayer-editor_' . $UID . '" src="' . $ytp_plugin_base . '/images/ytplayershortcode.png">';
            /** If it's new */
        } else {
            $content = '<img style="opacity:0.4" class="YTPlayer-editor" id="YTPlayer-editor_' . $UID . '" src="' . $ytp_plugin_base . '/images/ytplayershortcode.png">';
        }

        /** If we are in the front end */
    } else {
        $content = $attributes['ytp_shortcode'];
    }
    return $content;
}

/**
 * Create your Gutemberg category
 *
 * @param $categories
 * @param $post
 * @return array
 */
add_filter( 'block_categories', 'ytp_block_categories', 10, 2 );
function ytp_block_categories( $categories, $post )
{
    return array_merge(
        $categories,
        array(
            array(
                'slug' => 'mb.ideas',
                'title' => __( 'mb.ideas', 'wpmbytplayer' ),
            ),
        )
    );
}
