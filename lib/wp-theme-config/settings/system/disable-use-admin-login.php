<?php

/**
 * 禁止使用 admin 用户名尝试登录
 * http://blog.wpjam.com/m/no-admin-try/
 */
return function() 
{
    add_filter('wp_authenticate', 'unusing_admin_as_username_login');
    function unusing_admin_as_username_login($user)
    {
        if ('admin' == $user) {
            exit;
        }
    }
    
    add_filter('sanitize_user', 'sanitize_user_unusing_admin_as_username', 10, 3);
    function sanitize_user_unusing_admin_as_username($username, $raw_username, $strict)
    {
        if ('admin' == $raw_username || 'admin' == $username) {
            exit;
        }
    
        return $username;
    }
};