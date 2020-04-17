<?php

/**
 * 非管理员用户后台登录后重定向到首页
 * http://www.wpdaxue.com/only-allow-administrators-to-access-wordpress-admin-area.html
 */
return function($value) 
{
    if ( ! $value) return;

    function redirect_non_admin_users() {
        if ( ! current_user_can( 'manage_options' ) && '/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF'] ) {
            wp_redirect( home_url() );
            exit;
        }
    }
    add_action( 'admin_init', 'redirect_non_admin_users' );
};