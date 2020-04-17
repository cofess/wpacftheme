<?php

/**
 * 禁用WordPress登录错误的提示信息
 * http://www.wpdaxue.com/modify-wordpress-login-error-message.html
 */ 
return function($value) 
{
    if ( ! $value) return;
    
    // Disable error messages on login page
    function disable_login_error_message($a)
    {
        echo '<style type="text/css">#login_error { display: none; }</style>' . "\n";
        return null;
    }

    add_filter('login_errors', 'disable_login_error_message');
};