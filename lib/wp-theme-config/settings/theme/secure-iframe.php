<?php

/**
 * 防止WordPress站点被别人通过iframe框架引用
 * 参考：http://www.wpdaxue.com/break-out-of-frames-for-wordpress.html
 */
return function($value) 
{
    $iframe_except_domain = $this->config['theme.iframe-except-domain'];
    add_action('init', function() use($value,$iframe_except_domain){
        if( $value == '1' ){
            header('X-Frame-Options:Deny');
        }
        if( $value == '2' ){
            header('X-Frame-Options:SAMEORIGIN');
        }
        if( $value == '3' && $iframe_except_domain!= '' ){
            $domains = explode(PHP_EOL,$iframe_except_domain); // 按换行符截取字符串
            array_push($domains,site_url());
            $domains = implode(" ",$domains); // 拼接字符串，以空格符间隔两个网站
            header('X-Frame-Options:ALLOW-FROM '.$domains.'');
        }
    });
};