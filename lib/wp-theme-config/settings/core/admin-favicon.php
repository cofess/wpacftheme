<?php
// Pull favicon from the theme folder (Front-end calls are in includes/metagraphics.php).
return function ($value) {
	add_action('admin_head', 'admin_favicon'); 
	function admin_favicon() {
		$cache_buster = (WP_DEBUG)? '?r' . mt_rand(1000, mt_getrandmax()) : '';
		echo '<link rel="shortcut icon" href="' . get_theme_file_uri('/static/admin/images/favicon/favicon.png') . $cache_buster . '" />';
	} 
} ;
