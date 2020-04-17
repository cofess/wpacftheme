<?php

/**
 * 从静态资源中删除查询字符串
 * 移除 WordPress 加载的JS和CSS链接中的版本号
 * http://www.wpdaxue.com/remove-js-css-version.html
 */
return function() 
{
    function remove_query_strings( $src ) {
        if( strpos( $src, '?ver=' ) )
            $src = remove_query_arg( 'ver', $src );
        return $src;
    }
    add_filter( 'style_loader_src', 'remove_query_strings', 10, 2 );
    add_filter( 'script_loader_src', 'remove_query_strings', 10, 2 );
};