<?php

/**
 * WordPress drop-in to check requirements
 * https://github.com/Kubitomakita/Requirements
 */
return function($value) 
{
	global $require_options;
	$require_options = WpThemeConfig\Configurator::getInstance()->get('require.require-check-options');
    /**
	 * If installed by download
	 */
	require_once( WP_THEME_CONFIG_DIR . '/class/underDEV_Requirements.php' );

	$requirements = new underDEV_Requirements( 'This Theme',  $require_options );

	/**
	 * Add your own check
	 */
	// function my_plugin_custom_check( $comparsion, $r ) {
	// 	if ( $comparsion != 'thing to check' ) {
	// 		$r->add_error( 'this thing to be that' );
	// 	}
	// }

	// $requirements->add_check( 'custom_check', 'my_plugin_custom_check' );

	/**
	 * Run all the checks and check if requirements has been satisfied
	 * If not - display the admin notice and exit from the file
	 */
	if ( ! $requirements->satisfied() ) {

		add_action( 'admin_notices', array( $requirements, 'notice' ) );
		return;

	}
};
