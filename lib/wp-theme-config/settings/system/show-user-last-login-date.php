<?php

/**
 * WordPress 后台用户列表添加上次登录时间
 * http://www.wpdaxue.com/wp-user-last-login-date.html
 */
return function() 
{
    // 创建一个新字段存储用户登录时间
	function insert_last_login( $login ) {
		global $user_id;
		$user = get_userdatabylogin( $login );
		update_user_meta( $user->ID, 'last_login', current_time( 'mysql' ) );
	}
	
	// 添加一个新栏目“上次登录”
	function add_last_login_column( $columns ) {
		$columns['last_login'] = '上次登录';
		return $columns;
	}
	
	// 显示登录时间到新增栏目
	function add_last_login_column_value( $value, $column_name, $user_id ) {
		$user = get_userdata( $user_id );
		if ( 'last_login' == $column_name && $user->last_login )
			$value = get_user_meta( $user->ID, 'last_login', ture );
		else $value = '从未登录';
		return $value;
	}
	
	add_action( 'wp_login', 'insert_last_login' );
	add_filter( 'manage_users_columns', 'add_last_login_column' );
	add_action( 'manage_users_custom_column', 'add_last_login_column_value', 10, 3 );
};