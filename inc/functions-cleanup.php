<?php
/**
 * Clean up WordPress <head>.
 * @package Croft
 */
function croft_head_cleanup() {
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// hybrid Core meta
	remove_action( 'wp_head', 'hybrid_meta_generator', 1 );
	remove_action( 'wp_head', 'hybrid_link_pingback',  3 );
}
add_action( 'init', 'legion_head_cleanup' );

/**
* Remove the WordPress version from RSS feeds
*/
add_filter( 'the_generator', '__return_false' );
