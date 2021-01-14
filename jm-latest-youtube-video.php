<?php

/*
Plugin Name: JM Latest YouTube Video
Plugin URI:
Description: show latest public youtube videos of 'St. Laurentius Möhrendorf' channel
Version:     0.0.1
Author:      Johannes Michaelis
Author URI:  https://jomichaelis.de
License:
License URI:
Text Domain: jm-latest-youtube-video
Domain Path: /languages
*/

add_action( 'init', 'register_shortcodes');

function register_shortcodes() {
	add_shortcode('jm-latest-youtube', 'jm_latest_youtube_shortcode');
}

function jm_latest_youtube_shortcode( $atts = array() ) {
	extract(shortcode_atts(array(
		'video' => 0,
	), $atts));

	$channel_id = "UCBs__BGQEq5Z1eEusob3XGQ";
	$Content = "";
	$videoID = "error";

	if (isset($video)) {
		$videoNum = intval($video);
		$xml = simplexml_load_file(sprintf('https://www.youtube.com/feeds/videos.xml?channel_id=%s', $channel_id));

		if (!empty($xml->entry[$videoNum]->children('yt', true)->videoId[0])){
			$videoID = $xml->entry[$videoNum]->children('yt', true)->videoId[0];
		}

		if ($videoID != "error") {
			// $videoLink = 'https://www.youtube.com/watch?v='.$videoID;
			$videoEmbedLink = 'https://www.youtube.com/embed/'.$videoID;

			$Content .= '<div class="wp-block-group">';
			$Content .= '	<div class="wp-block-group__inner-container">';
			$Content .= '		<figure class="wp-block-embed-youtube wp-block-embed is-type-video is-provider-youtube wp-embed-aspect-16-9 wp-has-aspect-ratio">';
			$Content .= '			<div class="wp-block-embed__wrapper">';
			$Content .= '				<span class="embed-youtube" style="text-align:center; display: block;">';
			$Content .= '					<iframe class="youtube-player" width="1200" height="675" src="'.$videoEmbedLink.'" allowfullscreen="true" style="border:0;"></iframe>';
			$Content .= '				</span>';
			$Content .= '			</div>';
			$Content .= '		</figure>';
			$Content .= '	</div>';
			$Content .= '</div>';
		}
	}

	return $Content;
}