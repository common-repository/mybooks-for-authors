<?php
add_filter('the_content', 'ot_books_content');
function ot_books_content($content) {
	// make sure it's the post type 'book'
	if (get_post_type() == 'book' and get_option('mybooks_filter_content') == 0) {
		$newcontent = '';
		$booklinks = '';
		$image = '';
		global $post;
		$amazon = get_post_meta($post->ID, 'amazon_url', true);
		$bn = get_post_meta($post->ID, 'bn_url', true);
		$ceoread = get_post_meta($post->ID, 'ceoread_url', true);
		$indie = get_post_meta($post->ID, 'indie_url', true);
		$subtitle = get_post_meta($post->ID, 'book_subtitle', true);
		$ibooks = get_post_meta($post->ID, 'ibooks_url', true);
		$itunes = get_post_meta($post->ID, 'itunes_url', true);
		$audible = get_post_meta($post->ID, 'audible_url', true);
		$bam = get_post_meta($post->ID, 'bam_url', true);
		$newcontent .= '<div class="book-content">';

		// Building the Book links to go AFTER content:
		$booklinks .= ot_booklinks( $amazon, $bn, $ceoread, $ibooks, $indie, $itunes, $audible, $bam);

		if (has_post_thumbnail($post->ID)) {
			$image .= '<a href="'.$amazon.'">'.get_the_post_thumbnail( $post->ID, 'medium', array('title' => $post->post_title, 'class' => 'bookimg alignleft')).'</a>';
			$newcontent .= $image;
		}
		$newcontent .= $booklinks;
		$newcontent .= '<div class="clr"></div>
	</div><!--END book- content-->';
	
	if ( stripos( $content, '<img') ) {
		// if there is an image inserted into the content...continue inside here:
		if (has_shortcode($content, 'booklinks')) {
//			echo "We have the image in the content, and the shortcode for booklinks has been added.";
			$content = $content;
		} else {
//			echo "We don't have the booklinks, but we do have an image, so just put the booklinks at the bottom.";
			$content = $content . $booklinks;
		}

	}
	// this is checking to see what happens if NO image has been uploaded and set as featured.
	elseif (empty($image)) {
		$content = $content . $booklinks;
	}
	// END check for empty and inserted image, now we'll see what happens if NO image has been inserted, but there is one set as featured
	else
	{
		if (has_shortcode($content, 'booklinks')) {
//			echo "we don't have an image, but we do have the booklinks shortcode";
			$content = $image . $content;
		} else {
//			echo "we don't have an image or a booklink shortcode";
			$content = $newcontent . $content;
		}
	}
	
//	$content = $newcontent . $content;

	} // end check for post type
	return $content;
}