<?php

/**
 * WordPress 后台用户列表显示用户昵称
 * http://www.wpdaxue.com/add-user-nickname-column.html
 */
return function() 
{
    function add_user_nickname_column($columns) {
		$columns['user_nickname'] = '昵称';
		return $columns;
	}
	function show_user_nickname_column_content($value, $column_name, $user_id) {
		$user = get_userdata( $user_id );
		$user_nickname = $user->nickname;
		if ( 'user_nickname' == $column_name )
			return $user_nickname;
		return $value;
	}
	add_filter('manage_users_columns', 'add_user_nickname_column');
	add_action('manage_users_custom_column','show_user_nickname_column_content', 20, 3);
};