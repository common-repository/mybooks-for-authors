<?php
// create custom plugin settings menu
add_action('admin_menu', 'mybooks_create_menu');

function mybooks_create_menu() {

	//create new top-level menu
	add_options_page('MyBooks Settings', 'MyBooks Settings', 'administrator', 'mybooks_settings', 'mybooks_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_mybooks_settings' );
}

function register_mybooks_settings() {
	//register our settings
	register_setting( 'mybooks-settings-group', 'mybooks_filter_content' );
	register_setting( 'mybooks-settings-group', 'mybooks_thumbnail_width' );
	register_setting( 'mybooks-settings-group', 'mybooks_plugin_css' );
	register_setting( 'mybooks-settings-group', 'mybooks_customlinks' );	
}

function mybooks_settings_page() {
?>
<div class="wrap">
<h2>MyBooks for Authors - Plugin Settings</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'mybooks-settings-group' ); ?>
    <table class="form-table">
		<tr valign="top">
			<th scope="row"><strong>Sidebar Thumbnail Width</strong><br>
				<small>What size would you like to make the book thumbnails?</small></th>
			<td><fieldset><legend class="screen-reader-text"><span>Book Thumbnail</span></legend>
			<label for="mybooks_thumbnail_width">Max Width</label>
			<input type="number" name="mybooks_thumbnail_width" step="1" min="0" id="mybooks_thumbnail_width" value="<?php if (get_option('mybooks_thumbnail_width')){ echo get_option('mybooks_thumbnail_width'); } else { echo '250'; } ?>" class="small-text">
			</fieldset>
			</td>
		</tr>
		<tr valign="top">
			<td colspan="2">
				<hr />
				<h2>Advanced</h2>
				(If you don't know what these do, it's probably best to leave them alone.)</p>
			</td>
		</tr>
	        <tr valign="top">
	        <th scope="row"><strong>Filter Content</strong></th>
	        <td><label for="mybooks_filter_content"><input <?php if(get_option('mybooks_filter_content')=='1') : ?>checked="checked" <?php endif; ?> type="checkbox" id="mybooks_filter_content" name="mybooks_filter_content" value="1" /> <strong>Turn content filter OFF</strong></label><br>
			<em>Checking this option will remove MyBooks' automatic filtering of the individual books pages. This is useful if want to create a template file <code>single-book.php</code></em>
			</td>
	    </tr>
		</tr>
	        <tr valign="top">
	        <th scope="row"><strong>Use Custom Links</strong></th>
	        <td><label for="mybooks_customlinks"><input <?php if(get_option('mybooks_customlinks')=='true') : ?>checked="checked" <?php endif; ?> type="checkbox" id="mybooks_customlinks" name="mybooks_customlinks" value="true" /> <strong>Use links instead of buttons</strong></label><br>
			<em>Checking this option will use simple links (instead of buttons) for custom styling. Use this only if you know how to style links with CSS.</em>
			</td>
	    </tr>

        <tr valign="top">
        <th scope="row"><strong>MyBooks CSS</strong><br><small><em>(If you'd like to add CSS to override the default mybooks css, you can add that here)</em></small></th>
        <td><textarea rows="5" cols="60" name="mybooks_plugin_css"><?php echo get_option('mybooks_plugin_css'); ?></textarea></td>
        </tr>
    </table>
    
    <p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
    </p>
	<div style="background: rgb(255, 255, 213);border-radius: 3px;padding: 2px 10px;border: 1px solid #FFE479;">
		<p style="margin-bottom: 8px;margin-top: 8px;">To get the most out of the MyBooks plugin, <a href="http://support.outthinkgroup.com/mybooks">check out our short tutorial</a>.</p>
	</div>

</form>
</div>
<?php } ?>