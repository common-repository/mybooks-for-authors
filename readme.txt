=== Plugin Name ===
Contributors: jhinson, timgrahl
Tags: books, authors, books widget, books plugin, books post type, author plugin, add books, display books, sell books
Requires at least: 3.1
Tested up to: 3.6
Stable tag: 1.5.6
License: GPLv2

MyBooks gives authors the ability to easily add books to their site, complete with buy links, optional sidebar widget, and shortcode for buy buttons. Install the plugin, activate, and you're done!

== Description ==

MyBooks for Authors is a WordPress plugin that gives authors the ability to quickly and easily add books, complete with cover images and buy links, to their WordPress blog. By creating a post type called "Books", authors can add all of their books under "Books" just as they would new posts or pages. By also uploading a book cover and setting it as featured, the book will be displayed on the page. The plugin also includes an optional widget to be used in the sidebar with several options, including an animation to slide through the books.

Additionally, a shortcode is available for users of this plugin to place anywhere in the book page that will show the buylinks by simply inserting [booklinks].

Use this plugin to feature your books, along with optional buy links for the following:

* Amazon.com
* Barnesandnoble.com
* iBooks
* 800ceoread.com
* Indiebound
* iTunes
* Audible.com
* Books A Million

== Installation ==

1. Upload mybooks-for-authors to the /wp-content/plugins/ directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add new books by going to Books > Add New in your admin menu

== Frequently Asked Questions ==

Video and FAQ available here:

http://support.outthinkgroup.com/mybooks

== Screenshots ==

For more information, see:

http://support.outthinkgroup.com/mybooks

== Changelog ==

= 1.5.6 =
* Fixed plugin for WordPress 3.6 conflicting function (has_shortcode()) which caused a fatal error.

= 1.5.5 =
* Fixed a css issue where some margin was removed on the buy links

= 1.5.4 =
* Added an advanced feature to turn off the buttons and allow for custom CSS styling of links for buy buttons
* Added a parameter to hide "buy the book" text and wrapper from the booklinks shortcode, use as follows: [booklinks text="hide"]

= 1.5.3 =
* Fixed an issue where abbreviated php opening tags would cause fatal errors on some old hosts.
* Added Booksamillion.com link options.

= 1.5.2 =
* Added functionality to support a custom title for the widget -- defaults to nothing -- if blank, no title will be used.
* Added a checkbox to force book images in widget to always link to book overview page. If NOT checked, book links to ONE of the following: Amazon.com, BN.com, 800ceoread.com, indiebound.com, iBooks, iTunes, and Audible (in that order).

= 1.5.1 =
* Added feature to support iTunes and Audible buy links
* Fixed bug where widget didn't order books properly.

= 1.5 =
* Fixed issue that was causing pages to 404, simply deactivate, and reactivate plugin in order to fix.
* Added settings panel to allow users to control book thumbnail size, turn content filter on/off, and an optional field for CSS to override plugin styles.

= 1.0 =
* Version 1.0 Released. Thoroughly tested in WordPress 3.4.1

== Upgrade Notice ==
If you're using the PHP function ot_booklinks() directly, this update will remove the "buy the book" text. The ot_booklinks() now only inserts book links, wrapped in a span. If you don't know what this means, this update won't affect you.

Upgrading will not break your exising settings or widgets.