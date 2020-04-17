<?php

/**
 * 自定义登录页面LOGO提示为任意文本
 * http://www.wpdaxue.com/custom-wordpress-login-page.html
 */
return function($value) 
{
    if ( ! $value) return;

    $text = $this->config['system.login-logo-title-text'];

    if($text){
        add_filter( 'login_headertitle', function() use($text){
            return $text;
        } );
    }
};