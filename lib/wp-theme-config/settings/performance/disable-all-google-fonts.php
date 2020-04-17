<?php

/**
 * Disable Google Fonts
 */

return function($value)
{
	// Deactivate the default Google Fonts version of Open Sans while viewing the site
	function action_dequeue_google_fonts() {

		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );

	}

	function disable_all_google_fonts()
	{
		global $wp_styles;

		//	multiple patterns hook
		$regex = '/fonts\.googleapis\.com\/css\?family/i';

		foreach($wp_styles->registered as $registered) {

			if( preg_match($regex, $registered->src) ) {
				wp_dequeue_style($registered->handle);
			}
		}
	}

	add_action( 'wp_enqueue_scripts', 'action_dequeue_google_fonts' );
	add_action('wp_enqueue_scripts', 'disable_all_google_fonts', 999);
};
