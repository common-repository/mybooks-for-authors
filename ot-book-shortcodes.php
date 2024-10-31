<?php
// [booklinks text="hide"]
function products_booklinks($atts) {
	extract(shortcode_atts(array(
		"text" => 'show'
	), $atts));
	global $post;
	$amazon = get_post_meta($post->ID, 'amazon_url', true);
	$bn = get_post_meta($post->ID, 'bn_url', true);
	$ceoread = get_post_meta($post->ID, 'ceoread_url', true);
	$indie = get_post_meta($post->ID, 'indie_url', true);
	$ibooks = get_post_meta($post->ID, 'ibooks_url', true);
	$itunes = get_post_meta($post->ID, 'itunes_url', true);
	$audible = get_post_meta($post->ID, 'audible_url', true);		
	$bam = get_post_meta($post->ID, 'bam_url', true);		
	$return = '';
	if ($text != 'hide') {
		$return .='<div class="order-book"><p class="booklinks"><span class="buy-book-text">Buy the book:<br /></span>';
		$return .= ot_booklinks( $amazon, $bn, $ceoread, $ibooks, $indie, $itunes, $audible, $bam);
		$return .='</p></div>';
	} else {
		$return .= ot_booklinks( $amazon, $bn, $ceoread, $ibooks, $indie, $itunes, $audible, $bam);
	}
	return $return;
}
add_shortcode("booklinks", "products_booklinks");
?>
