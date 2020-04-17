<?php

/**
 * WordPress 禁止切换主题
 * http://www.endskin.com/disable-change-theme.html
*/
return function() 
{
    function remove_theme_menu(){
			global $submenu, $userdata;
			get_currentuserinfo();
			//if( $userdata->ID != 1 ) unset( $submenu['themes.php'][5] );
			unset( $submenu['themes.php'][5] );
		}
		if( !current_user_can('administrator') ) {
			add_action( 'admin_init', 'remove_theme_menu' );
		}
};