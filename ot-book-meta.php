<?php
/* Define the custom box for Buy Links */

// WP 3.0+
add_action('add_meta_boxes', 'booklinks_meta_box');
// backwards compatible
add_action('admin_init', 'booklinks_meta_box', 1);

add_action('add_meta_boxes', 'ot_nlsignup_meta_box');
add_action('admin_init', 'ot_nlsignup_meta_box', 1);

/* Do something with the data entered */
add_action('save_post', 'booklinks_save_postdata');

/* Adds a box to the main column on the Post and Page edit screens */
function booklinks_meta_box() {
    add_meta_box( 'booklinks_sectionid', __( 'Book Details', 'booklinks_textdomain' ), 'booklinks_inner_custom_box','book', 'normal', 'high');
}
function ot_nlsignup_meta_box() {
    add_meta_box( 'ot_nlsignup_box', __( 'Learn how to market your book', 'ot_nlsignup_box_textdomain' ), 'ot_nlsignup_content','book', 'normal', 'high');
}

// Create the function to use in the action hook
function add_otnlsignup_widget() {
  wp_add_dashboard_widget( 'ot_nlsignup_content', __( 'Learn how to market your book' ), 'ot_nlsignup_content' );
	global $wp_meta_boxes;

	// Get the regular dashboard widgets array 
	// (which has our new widget already but at the end)
	$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

	// Backup and delete our new dashbaord widget from the end of the array

	$ot_nlsignup_content_backup = array('ot_nlsignup_content' => $normal_dashboard['ot_nlsignup_content']);
	unset($normal_dashboard['ot_nlsignup_content']);

	// Merge the two arrays together so our widget is at the beginning

	$sorted_dashboard = array_merge($ot_nlsignup_content_backup, $normal_dashboard);

	// Save the sorted array back into the original metaboxes 

	$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
}
// Hook into the wp_dashboar_setup to add the widget
add_action('wp_dashboard_setup', 'add_otnlsignup_widget' );

// This is the function of the contents of our Dashboard Widget
function ot_nlsignup_content() {  ?>
	<iframe width="100%" height="300" src="http://outthinkgroup.com/nlsignup/" scrolling="no" frameborder="0" overflow="0"></iframe>
<?php
}

/* Prints the box content for book links */

function booklinks_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'booklinks_noncename' );

	global $post;
//	$page_excerpt = get_post_meta($post->ID, 'page_excerpt', true);
	$book_subtitle  = get_post_meta($post->ID, 'book_subtitle', true);
	$amazon_url = get_post_meta($post->ID, 'amazon_url', true);
	$bn_url = get_post_meta($post->ID, 'bn_url', true);
	$bam_url = get_post_meta($post->ID, 'bam_url', true);
	$ceoread_url = get_post_meta($post->ID, 'ceoread_url', true);
	$ibooks_url = get_post_meta($post->ID, 'ibooks_url', true);	
	$itunes_url = get_post_meta($post->ID, 'itunes_url', true);	
	$audible_url = get_post_meta($post->ID, 'audible_url', true);	
	$indie_url = get_post_meta($post->ID, 'indie_url', true);

  // The actual fields for data entry ?>
<table border="0" cellspacing="5" cellpadding="5" width="100%">
	<tr>
	<td>
		<p>
			<label for="book_subtitle"><strong>Book Subtitle:</strong> </label><br>
			<input size="60" type="text" name="book_subtitle" value="<?php echo $book_subtitle; ?>" id="book_subtitle">
		</p>
		<p>
			<label for="amazon_url">Amazon URL: </label><br>
			<input size="60" type="text" name="amazon_url" value="<?php echo $amazon_url; ?>" id="amazon_url">
		</p>
		<p>
			<label for="bn_url">Barnes and Noble URL: </label><br>
			<input size="60" type="text" name="bn_url" value="<?php echo $bn_url; ?>" id="bn_url">
		</p>
		<p>
			<label for="bn_url">Books A Million: </label><br>
			<input size="60" type="text" name="bam_url" value="<?php echo $bam_url; ?>" id="bam_url">
		</p>
		<p>
			<label for="ibooks_url">iBooks URL: </label><br>
			<input size="60" type="text" name="ibooks_url" value="<?php echo $ibooks_url; ?>" id="ibooks_url">
		</p>
		<p>
			<label for="itunes_url">iTunes URL: </label><br>
			<input size="60" type="text" name="itunes_url" value="<?php echo $itunes_url; ?>" id="itunes_url">
		</p>
		<p>
			<label for="audible_url">Audible URL: </label><br>
			<input size="60" type="text" name="audible_url" value="<?php echo $audible_url; ?>" id="audible_url">
		</p>
		<p>
			<label for="ceoread_url">800ceoread.com URL: </label><br>
			<input size="60" type="text" name="ceoread_url" value="<?php echo $ceoread_url; ?>" id="ceoread_url">
		</p>
		<p>
			<label for="indie_url">Indiebound URL</label><br>
			<input size="60" type="text" name="indie_url" value="<?php echo $indie_url; ?>" id="indie_url">
		</p>
	</td>
	</tr>
</table>
  
<?php
}
   
/* When the post is saved, saves our custom data */
function booklinks_save_postdata( $post_id ) {

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
if (empty($_POST['booklinks_noncename'])) {
	$_POST['booklinks_noncename'] = '';
}
  if ( !wp_verify_nonce( $_POST['booklinks_noncename'], plugin_basename(__FILE__) ) )
      return $post_id;
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
      return $post_id;

  // Check permissions
  if ( !current_user_can( 'edit_post', $post_id ) )
		return $post_id;

  // OK, we're authenticated: we need to find and save the data

  	$amazon_url = $_POST['amazon_url'];
  	$bn_url = $_POST['bn_url'];
  	$bam_url = $_POST['bam_url'];
  	$ceoread_url = $_POST['ceoread_url'];
  	$ibooks_url = $_POST['ibooks_url'];
  	$itunes_url = $_POST['itunes_url'];
  	$audible_url = $_POST['audible_url'];
	$indie_url = $_POST['indie_url'];
	$book_subtitle = $_POST['book_subtitle'];

  // update the data
	update_post_meta($post_id, 'amazon_url', $amazon_url);
	update_post_meta($post_id, 'bn_url', $bn_url);
	update_post_meta($post_id, 'bam_url', $bam_url);
	update_post_meta($post_id, 'ceoread_url', $ceoread_url);
	update_post_meta($post_id, 'ibooks_url', $ibooks_url);
	update_post_meta($post_id, 'itunes_url', $itunes_url);		
	update_post_meta($post_id, 'audible_url', $audible_url);			
	update_post_meta($post_id, 'indie_url', $indie_url);		
	update_post_meta($post_id, 'book_subtitle', $book_subtitle);				
}
?>