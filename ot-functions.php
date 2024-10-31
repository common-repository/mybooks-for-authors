<?php

/* Display a notice that can be dismissed */

add_action('wp_head', 'mybooks_plugin_css');
function mybooks_plugin_css() {
	if (get_option('mybooks_plugin_css')) { ?>
		<style type="text/css" media="screen">
			<?php echo get_option('mybooks_plugin_css'); ?>
		</style>
	<?php }
}

add_action('init', 'ot_enqueue_headstuff');
add_theme_support( 'post-thumbnails' );
if ( function_exists( 'add_image_size' ) ) { 
	if (get_option('mybooks_thumbnail_width')) {
		add_image_size( 'book-thumb', get_option('mybooks_thumbnail_width'), 2000);
	} else {
		add_image_size( 'book-thumb', 250, 650 );
	}
}
function ot_enqueue_headstuff() {
    wp_enqueue_script('jquery');
	wp_enqueue_style( 'ot-book-styles', plugins_url( 'css/ot-book-styles.css', __FILE__ ));
	wp_enqueue_script( 'ot-js-setup', plugins_url( 'js/ot-setup.js', __FILE__ ));
	wp_enqueue_script( 'jquery-cycle', plugins_url( 'js/jquery.cycle.all.min.js', __FILE__ ));
}
if (!function_exists('has_shortcode')) {
	function has_shortcode( $content, $tag ) {
		if ( shortcode_exists( $tag ) ) {
			preg_match_all( '/' . get_shortcode_regex() . '/s', $content, $matches, PREG_SET_ORDER );
			if ( empty( $matches ) )
				return false;

			foreach ( $matches as $shortcode ) {
				if ( $tag === $shortcode[2] )
					return true;
			}
		}
		return false;
	}
}
if (!function_exists('shortcode_exists')) {
	function shortcode_exists( $tag ) {
		global $shortcode_tags;
		return array_key_exists( $tag, $shortcode_tags );
	}
}

function ot_booklinks( $amazon = '', $bn = '', $ceoread = '', $ibooks = '', $indie = '', $itunes = '', $audible = '', $bam = '') {	
	$booklinks = '';
	$customlinks = get_option('mybooks_customlinks');
	if ($amazon or $bn or $ceoread or $ibooks or $indie or $itunes or $audible or $bam) {
		// if user has checked the box that says "I would like to style the links to make custom buttons";
		$booklinks .= '<span class="bookseller-links">';
		if ($customlinks == 'true') {
			if ($amazon) {
				$booklinks .= '<a class="amazon" href="'.$amazon.'">Amazon.com</a>';
			}
			if ($bn) {
				$booklinks .= '<a class="barnes" href="'.$bn.'">Barnes &amp; Noble</a>';
			}
			if ($bam) {
				$booklinks .= '<a class="bam" href="'.$bam.'">BooksAMillion</a>';
			}

			if ($ibooks) {
				$booklinks .= '<a class="ibooks" href="'.$ibooks.'">iBooks</a>';
			}
			if ($itunes) {
				$booklinks .= '<a class="itunes" href="'.$itunes.'">iTunes</a>';
			}
			if ($audible) {
				$booklinks .= '<a class="audible" href="'.$audible.'">Audible.com</a>';
			}
			if ($ceoread) {
				$booklinks .= '<a class="ceoread" href="'.$ceoread.'">800ceoread.com</a>';
			}
			if ($indie) {
				$booklinks .= '<a class="indie" href="'.$indie.'">IndieBound.org</a>';
			}
		// otherwise, use the buttons
		} else {
			if ($amazon) {
				$booklinks .= '<a class="amazon" href="'.$amazon.'"><img src="'.plugins_url( 'images/icon-amazon.png' , __FILE__ ).'" width="96" height="32" alt="Amazon.com"></a>';
			}
			if ($bn) {
				$booklinks .= '<a class="barnes" href="'.$bn.'"><img src="'.plugins_url( 'images/icon-barnes.png' , __FILE__ ).'" width="96" height="32" alt="Barnes and Noble"></a>';
			}
			if ($bam) {
				$booklinks .= '<a class="bam" href="'.$bam.'"><img src="'.plugins_url( 'images/icon-bam.png' , __FILE__ ).'" width="96" height="32" alt="Books A Million"></a>';
			}

			if ($ibooks) {
				$booklinks .= '<a class="ibooks" href="'.$ibooks.'"><img src="'.plugins_url( 'images/icon-ibooks.png' , __FILE__ ).'" width="96" height="32" alt="iBooks"></a>';
			}
			if ($itunes) {
				$booklinks .= '<a class="itunes" href="'.$itunes.'"><img src="'.plugins_url( 'images/icon-itunes.png' , __FILE__ ).'" width="96" height="32" alt="iTunes"></a>';
			}
			if ($audible) {
				$booklinks .= '<a class="audible" href="'.$audible.'"><img src="'.plugins_url( 'images/icon-audible.png' , __FILE__ ).'" width="96" height="32" alt="Audible.com"></a>';
			}
			if ($ceoread) {
				$booklinks .= '<a class="ceoread" href="'.$ceoread.'"><img src="'.plugins_url( 'images/icon-ceoread.png' , __FILE__ ).'" width="96" height="32" alt="800ceoread.com"></a>';
			}
			if ($indie) {
				$booklinks .= '<a class="indie" href="'.$indie.'"><img src="'.plugins_url( 'images/icon-indie.png' , __FILE__ ).'" width="96" height="32" alt="Buy the book at a local bookseller"></a>';
			}
		}
		$booklinks .= '</span>';

		return $booklinks;
	}
	
}