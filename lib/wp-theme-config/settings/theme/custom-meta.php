<?php

/**
 * custom meta
 */
return function($metas) 
{
    if ( ! $metas) return;
    add_action( 'wp_head', function() use($metas){
        $metas = explode(PHP_EOL,$metas); // 按换行符截取字符串
        $html = '';
        foreach($metas as $meta){
            $html.=$meta."\n";
        }
        echo $html;
    }, 1 );
};
