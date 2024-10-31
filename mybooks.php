<?php
/*
Plugin Name: MyBooks for Authors, by Out:think Group
Plugin URI: http://outthinkgroup.com/mybooks
Description: This plugin gives authors the ability to easily add books to their blog, complete with buy links, optional sidebar blocks, and shortcodes to be used elsewhere. Install the plugin, activate, and you're done!
Version: 1.5.6
Author: Joseph Hinson of Out:think Group
Author URI: http://outthinkgroup.com

    Copyright 2011 - Out:think Group  (email : joseph@outthinkgroup.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function mybooks_plugin_activate() {
	// register taxonomies/post types here
	register_book_init();
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
register_activation_hook( __FILE__, 'mybooks_plugin_activate' );

function mybooks_plugin_deactivate() {
	global $wp_rewrite;
	$wp_rewrite->flush_rules();
}
register_deactivation_hook( __FILE__, 'mybooks_plugin_deactivate' );

// initializes the post type
add_action( 'init', 'register_book_init' );

function register_book_init() {
register_post_type('book',
array(	
	'label' => 'Books',
	'public' => true,
	'show_ui' => true,
	'show_in_menu' => true,
	'show_in_nav_menus' => true,
	'has_archive' => true,
	'capability_type' => 'post',
	'hierarchical' => false,
	'rewrite' => array('slug' => 'books'),
	'query_var' => true,
	'supports' => array(
		'title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes',),
	'labels' => array (
		'name' => 'Books',
		'singular_name' => 'Book',
		'menu_name' => 'Books',
		'add_new' => 'Add Book',
		'add_new_item' => 'Add New Book',
		'edit' => 'Edit',
		'edit_item' => 'Edit Book',
		'new_item' => 'New Book',
		'view' => 'View Book',
		'view_item' => 'View Book',
		'search_items' => 'Search Books',
		'not_found' => 'No Books Found',
		'not_found_in_trash' => 'No Books Found in Trash',
		'parent' => 'Parent Book'
	),
) );
} // end register book

include	'ot-book-options.php';
include	'ot-functions.php';
include 'ot-book-widget.php';
include 'ot-book-content.php';
include 'ot-book-shortcodes.php';
include 'ot-book-meta.php';