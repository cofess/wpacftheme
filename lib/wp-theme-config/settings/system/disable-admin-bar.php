<?php

/**
 * 前台隐藏管理员工具条
 * 来自 http://shanmao.me/web-system/wordpress/wordpress-qu-diao-ye-mian-tou-bu-de-hou-tai-dao-hang
 */
return function() 
{
    add_filter('show_admin_bar', '__return_false');
    // Remove injected CSS on front-end site to add margin-top for admin toolbar (Does not remove admin toolbar)
    add_theme_support( 'admin-bar', array( 'callback' => '__return_false' ) );
};
