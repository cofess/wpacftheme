<?php

/*
Plugin Name: 增强 WordPress 用户搜索
Plugin URI: http://blog.wpjam.com/m/enhance-wordpress-user-query/
Description: WordPress 技巧：增强 WordPress 用户搜索
Version: 0.1
Author: Denis
Author URI: http://blog.wpjam.com/
*/
return function() 
{
    
    // function enhance_user_query($query){
        
    //     if(!empty($query->query_vars['search'])){
    //         global $wpdb;
    //         $keyword = $query->query_vars['search'];
    //         $keyword = str_replace('*','',$keyword);
    //         $query->query_where = $wpdb->prepare(" WHERE 1=1 AND (user_login LIKE %s OR user_email LIKE %s OR user_nicename LIKE %s OR display_name LIKE %s OR UM.meta_value LIKE  %s) AND UM.meta_key='nickname'","%".$keyword."%","%".$keyword."%","%".$keyword."%","%".$keyword."%","%".$keyword."%");
    //         $query->query_fields .= " ,$wpdb->users.display_name, UM.meta_value as nickname";
    //         $query->query_from .= " left join $wpdb->usermeta UM on ($wpdb->users.ID=UM.user_id) ";
    //     }
    // }
	
    // add_action( 'pre_user_query', 'enhance_user_query', 9 );

    // 后台可以根据显示的名字来搜索用户 
    add_filter('user_search_columns',function($search_columns){
        return ['ID', 'user_login', 'user_email', 'user_url', 'user_nicename', 'display_name'];
    });

};