<?php

/**
 * 严格用户注册验证
 */

return function($value)
{
    add_filter('sanitize_user', 'strict_sanitize_user', 3, 3);
    function strict_sanitize_user($username, $raw_username, $strict)
    {
        // 设置用户名只能大小写字母和 - . _
        $username = preg_replace('|[^a-z0-9_.\-]|i', '', $username);
    
        //检测待审关键字和黑名单关键字
        if (Lib\Util\Check::blacklist_check($username)) {
            $username = '';
        }
    
        return $username;
    }
};
