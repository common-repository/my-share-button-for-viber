<?php
/*
	Plugin Name: My Share Button for Viber
	Plugin URI: http://www.codehubs.com/my-share-button-for-viber
	Description: Add Share on Viber button above and below your post content or just any custom Share On Viber button
	Author: CodeHub, Inc.
	Version: 1.0
	Author URI: http://www.codehubs.com
	License: GPL 2.0
*/

define('VIBER_SHARE_BUTTON_VERSION', '1.0');

/* add actions, filters and shortcodes */

add_action('admin_enqueue_scripts', 'viber_share_button_scripts_init');

add_filter('the_content', 'viber_share_top', 1);
add_filter('the_content', 'viber_share_bottom', 1000);

add_shortcode('viber_share', 'viber_share_shortcode');

/* functions */
function viber_share_button_scripts_init($page) {

	switch ($page) {
		case 'plugins.php':
			wp_deregister_style('my-share-button-for-viber-style');
			wp_register_style('my-share-button-for-viber-style', plugins_url('/css/share-button.css', __FILE__), null, '1.0');
			wp_enqueue_style('my-share-button-for-viber-style');
		break;
        }
}

/* filter function on top of the_content() */
function viber_share_top($content) {

	global $post;

	if (is_single()) {
		$viber_share_button = '<div align="right"><a href="viber://forward?text=' . urlencode(esc_attr($post->post_title)) . urlencode(' ' . get_permalink($post->ID)) . '"><img src="' . plugins_url('/images/viber-share.png', __FILE__) . '" alt=""/></a></div>';
		return $viber_share_button . $content;
	} 

}

/* filter function on bottom of the_content() */
function viber_share_bottom($content) {

        global $post;

        if (is_single()) {
                $viber_share_button = '<div align="right"><a href="viber://forward?text=' . urlencode(esc_attr($post->post_title)) . urlencode(' ' . get_permalink($post->ID)) . '"><img src="' . plugins_url('/images/viber-share.png', __FILE__) . '" alt=""/></a></div>';
                return $content . $viber_share_button;
        } 

}

/* shortcode function to share on viber any text with any url */
function viber_share_shortcode($atts) {
	if (isset($atts['align']) && isset($atts['text']) && isset($atts['url'])) {
		
		$align = $atts['align']; $text = $atts['text']; $url = $atts['url'];
		if ($align != 'right') $align = 'left';	

		return '<div align="' . $align . '"><a href="viber://forward?text=' . urlencode(esc_attr($text)) . urlencode(' ' . $url) .'"><img src="'. plugins_url('/images/viber-share.png', __FILE__) . '" alt=""/></a></div>';
	} else return;
}
/* eof */
