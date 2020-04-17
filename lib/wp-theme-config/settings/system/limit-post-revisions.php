<?php

/**
 * 禁用所有文章类型的修订版本
 * http://my.oschina.net/9iphp/blog/378348
 * http://www.zhiyanblog.com/wordpress-4-x-continuous-posts-id.html
*/
return function($value) 
{
    if ( ! $value) return;
    
    $num = $value;
    if( $value=="false" ) {
        $num = 0;
    }
    define('WP_POST_REVISIONS', $num);
    add_filter( 'wp_revisions_to_keep', 'limit_wp_revisions_to_keep', 10, 2 );
	function limit_wp_revisions_to_keep( $num, $post ) {
    	return $num;
	}
};