<?php

/**
 * 头部额外代码
 */
return function($code) 
{
    if ( ! $code) return;
    add_action( 'wp_head', function() use($code){
        echo $code;
    }, 10 );
};
