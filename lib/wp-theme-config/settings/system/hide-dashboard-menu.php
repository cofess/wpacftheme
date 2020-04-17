<?php

/**
 * 隐藏WordPress后台仪表盘菜单链接
 * https://wordpress.stackexchange.com/questions/39087/remove-dashboard-use-pages-tab-as-default
 */
return function() 
{
	function dashboard_redirect_to_profile(){
		wp_redirect(admin_url('profile.php'));
	}
	
	function login_redirect_to_profile( $redirect_to, $request, $user ){
		return admin_url('profile.php');
	}
	
	function hide_dashboard_menu(){
		remove_menu_page( 'index.php' ); //dashboard
	}

	if( !current_user_can('administrator') ) {
		add_action('load-index.php','dashboard_redirect_to_profile');
		add_filter('login_redirect','login_redirect_to_profile',10,3);
		add_action( 'admin_menu', 'hide_dashboard_menu', 99 );
	}
};