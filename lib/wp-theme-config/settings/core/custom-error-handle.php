<?php

/*
 |--------------------------------------------------------------------------
 | Custom error handling 自定义错误处理
 |--------------------------------------------------------------------------
 | https://frique.me/clientside/
 |
 */

return function ($value)
{
	// Only if this is the admin area
	if ( ! is_admin() ) {
		return;
	}
	
	require WP_THEME_CONFIG_DIR .'/class/class-clientside-error-handler.php';
	// Custom error handling
	add_action( 'init', 'clientside_init_errors' );
	function clientside_init_errors() {
		Clientside_Error_Handler::action_collect_php_errors(); // Init action
		add_action( 'all_admin_notices', array( 'Clientside_Error_Handler', 'action_output_php_errors' ) );
	}
};