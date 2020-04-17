<?php

/**
 * 自定义登录界面LOGO链接为任意链接
 * http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
return function($url) 
{
    add_filter( 'login_headerurl', function() use($url){
        return $url; 
    } );
};