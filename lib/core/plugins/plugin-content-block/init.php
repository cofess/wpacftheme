<?php
/*
 Plugin Name: Content Blocks (Custom Post Widget)
 Plugin URI: http://www.vanderwijk.com/wordpress/wordpress-custom-post-widget/?utm_source=wordpress&utm_medium=plugin&utm_campaign=custom_post_widget
 Description: Show the content of a custom post of the type 'block' in a widget or with a shortcode.
 Version: 3.0.3
 Author: Johan van der Wijk
 Author URI: http://vanderwijk.nl
 Text Domain: custom-post-widget
 Domain Path: /languages
 License: GPL2

 Release notes: You can now show the featured image when using the shortcode to display a content block.

 Copyright 2017 Johan van der Wijk
*/

// Loads the widgets packaged with the plugin.
require_once( 'block-post-type.php' );
require_once( 'post-widget.php' );
register_widget( 'custom_post_widget' );


// Admin-only functions
if ( is_admin() ) {

	require_once( 'meta-box.php' );
	require_once( 'popup.php' );

}
