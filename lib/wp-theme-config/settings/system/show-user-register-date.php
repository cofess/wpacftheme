<?php

/**
 * WordPress 后台用户列表显示注册时间
 * http://www.wpdaxue.com/display-user-registerdate.html
 */
return function() 
{
	//添加用户注册时间和其他字段
	add_filter('manage_users_columns', function($columns){
		$columns['registered']	= __('注册时间', 'CS_TEXTDOMAIN');
		return $columns;
	});


	//显示用户注册时间字段
	add_filter('manage_users_custom_column', function($value, $column, $user_id){
		if ( 'registered' != $column )
			return $value;
		$user = get_userdata( $user_id );
		$registerdate = get_date_from_gmt($user->user_registered);
		return $registerdate;
	},11,3);

	//设置注册时间为可排序列.
	add_filter( "manage_users_sortable_columns", function($sortable_columns){
		$sortable_columns['registered'] = 'registered';
		return $sortable_columns;
	});

	//按注册时间排序.
	add_action('pre_user_query', function($query){
		if(!isset($_REQUEST['orderby'])){
			if( empty($_REQUEST['order']) || !in_array($_REQUEST['order'], ['asc','desc']) ){
				$_REQUEST['order'] = 'desc';
			}
			$query->query_orderby = "ORDER BY user_registered ".$_REQUEST['order'];
		}
	});
};