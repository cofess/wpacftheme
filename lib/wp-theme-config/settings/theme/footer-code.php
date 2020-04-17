<?php

/**
 * 页脚额外代码
 */
return function($code) 
{
    if ( ! $code) return;
    add_action( 'wp_footer', function() use($code){
        echo $code;
    }, 99 );
};
