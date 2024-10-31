<?
/*
The following is the code for the book widget
*/
// initializes the widget on WordPress Load
add_action('widgets_init', 'books_init_widget');

// Should be called above from "add_action" [line 28]
function books_init_widget() {
	register_widget( 'Books_Widget' );
} 

// new class to extend WP_Widget function
class Books_Widget extends WP_Widget {
	/** Widget setup.  */
	function Books_Widget() {
		/* Widget settings. */
		$widget_ops = array(
			'classname' => 'books_widget',
			'description' => __('MyBooks: Books Widget', 'books_widget') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'books-widget' );

		/* Create the widget. */
		$this->WP_Widget( 'books-widget', __('Books Widget', 'Options'), $widget_ops, $control_ops );
	}
	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		$booksnum = $instance['otbooks_num'];
		$orderby = $instance['otbooks_orderby'];
		$slide = $instance['otbooks_slide'];
		$timeout = $instance['otbooks_timeout'];
		$title = apply_filters('widget_title', $instance['title'] );
		$link = $instance['otbooks_link'];
		/* Before widget (defined by themes). */
		echo $before_widget;

		if ( $title )
			echo $before_title . $title . $after_title;
		
		// Settings from the widget

	$books = get_posts('numberposts='.$booksnum.'&orderby='.$orderby.'&order=ASC&post_type=book&post_status=publish');

	if ($books) { 
		if ($slide == 'true') { ?>
			<script type="text/javascript" charset="utf-8">
				jQuery(document).ready(function() {
					jQuery('.book-wrapper').cycle({
						timeout: <?php echo $timeout * 1000; ?>,
						fx: 'scrollUp' // choose your transition type, ex: fade, scrollUp, shuffle, etc...
					});
				});
			</script>
			<? } ?>
		<div class="book-wrapper">
		<?php $c = 1;
		foreach ($books as $book) {
			$amazon = get_post_meta($book->ID, 'amazon_url', true);
			$bn = get_post_meta($book->ID, 'bn_url', true);
			$ceoread = get_post_meta($book->ID, 'ceoread_url', true);
			$indie = get_post_meta($book->ID, 'indie_url', true);
			$ibooks = get_post_meta($book->ID, 'ibooks_url', true);			
			$itunes = get_post_meta($book->ID, 'itunes_url', true);
			$audible = get_post_meta($book->ID, 'audible_url', true);
			$bam = get_post_meta($book->ID, 'bam_url', true);			
			$subtitle = get_post_meta($book->ID, 'book_subtitle', true);
			?>
		<div class="books-text">
			<?php if (has_post_thumbnail($book->ID)) :
				if (strlen($amazon) > 0 && $link != 'true') {
					echo '<a href="'.$amazon.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';
				} elseif (strlen($bn) > 0 && $link != 'true') {
					echo '<a href="'.$bn.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';
				} elseif (strlen($ceoread) > 0 && $link != 'true') {
					echo '<a href="'.$ceoread.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';
				} elseif (strlen($indie) > 0 && $link != 'true') {
					echo '<a href="'.$indie.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';										
				} elseif (strlen($ibooks) > 0 && $link != 'true') {
					echo '<a href="'.$ibooks.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';
				} elseif (strlen($itunes) > 0 && $link != 'true') {
					echo '<a href="'.$itunes.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';
				} elseif (strlen($audible) > 0 && $link != 'true') {
					echo '<a href="'.$audible.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';										
				} elseif (strlen($bam) > 0 && $link != 'true') {
					echo '<a href="'.$bam.'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';					
				} else {
					echo '<a href="'.get_permalink($book->ID).'">'.get_the_post_thumbnail( $book->ID, 'book-thumb', array('title' => $book->post_title)).'</a>';
				}
			endif; ?>
			<p class="booktitle"><?php echo $book->post_title; ?></p>
			<p class="subtitle">
				<?php if (!empty($subtitle)): ?>
					<?php echo $subtitle; ?><br>
				<?php endif; ?>					
				<a href="<?php echo get_permalink($book->ID); ?>">Learn More...</a>
			</p>
			<p class="store-links">
				<?php echo ot_booklinks( $amazon, $bn, $ceoread, $ibooks, $indie, $itunes, $audible, $bam); ?>
			</p>	
			<div style="clear:both;height:1px;"></div>
		</div>
		<?php $c++; } ?>
		</div><!--END book-wrapper-->
	<?php } // endif
		
		/* After widget (defined by themes). */
		echo $after_widget;
	}


  /**
    * Saves the widgets settings.
    *
    */
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['otbooks_timeout'] = strip_tags(stripslashes($new_instance['otbooks_timeout']));
		$instance['otbooks_num'] = strip_tags(stripslashes($new_instance['otbooks_num']));
		$instance['otbooks_orderby'] = $new_instance['otbooks_orderby'];
		$instance['otbooks_slide'] = $new_instance['otbooks_slide'];
		$instance['otbooks_link'] = $new_instance['otbooks_link'];
		$instance['title'] = strip_tags( $new_instance['title'] );
	return $instance;
  }

/**
 * Displays the widget settings controls on the widget panel.
 * Make use of the get_field_id() and get_field_name() function
 * when creating your form elements. This handles the confusing stuff.
*/
	function form( $instance ) { 
		// Set up some default widget settings.
		
		$defaults = array(
			'otbooks_timeout' => '12',
			'otbooks_num' => '-1',
			'otbooks_orderby' => 'menu_order',
			'otbooks_slide' => 'false',
			'title' => __('', 'books_widget'),
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<!-- Widget Title: Text Input -->
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'books_widget'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" class="widefat" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'otbooks_num'); ?>">Number of Books to display</label><br><input type="text" name="<?php echo $this->get_field_name( 'otbooks_num'); ?>" value="<?php echo $instance['otbooks_num']; ?>" id="<?php echo $this->get_field_id( 'otbooks_num'); ?>">
		</p>
		<p><label for="<?php echo $this->get_field_id( 'otbooks_orderby' ); ?>">In which order do you want the books to display?</label><br>
			<select name="<?php echo $this->get_field_name( 'otbooks_orderby'); ?>" id="<?php echo $this->get_field_id( 'otbooks_orderby'); ?>">
				<option <?php if ( 'menu_order' == $instance['otbooks_orderby'] ) echo 'selected="selected"'; ?> value="menu_order">Menu Order</option>
				<option <?php if ( 'rand' == $instance['otbooks_orderby'] ) echo 'selected="selected"'; ?> value="rand">Random</option>
				<option <?php if ( 'modified' == $instance['otbooks_orderby'] ) echo 'selected="selected"'; ?> value="modified">Last Modified</option>				
			</select>
		</p>
		<p>
			<input style="margin-right: 5px;margin-top: 3px;" type="checkbox" name="<?php echo $this->get_field_name( 'otbooks_slide'); ?>" value="true" <?php if($instance['otbooks_slide']=='true') : ?>checked="checked" <?php endif; ?>id="<?php echo $this->get_field_id( 'otbooks_slide'); ?>"><label for="<?php echo $this->get_field_id( 'otbooks_slide'); ?>">Rotate books with animation <small>(If selected, books widget will be an animated slideshow)</small></label>
		</p>
		
		<p>
			<input style="margin-right: 5px;margin-top: 3px;" type="checkbox" name="<?php echo $this->get_field_name( 'otbooks_link'); ?>" value="true" <?php if($instance['otbooks_link']=='true') : ?>checked="checked" <?php endif; ?>id="<?php echo $this->get_field_id( 'otbooks_link'); ?>"><label for="<?php echo $this->get_field_id( 'otbooks_link'); ?>">Link books to overview pages <small>(If selected, book images will always link to book page, instead of linking to Amazon by default)</small></label>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'otbooks_timeout' ); ?>">Seconds between transitions <small>(If above option is checked)</small></label><br><input type="text" name="<?php echo $this->get_field_name( 'otbooks_timeout' ); ?>" value="<?php echo $instance['otbooks_timeout']; ?>" id="<?php echo $this->get_field_id( 'otbooks_timeout' ); ?>">
		</p>

		<small>This widget was created by Joseph Hinson of <a href="http://outthinkgroup.com" target="_blank" title="Out:think Group - Book and Author Marketing">Out:think Group</a>. If you have problems with it. Report them at <a href="http://support.outthinkgroup.com" target="_blank">Out:think Support</a></small>
	<?php
	}
}
?>