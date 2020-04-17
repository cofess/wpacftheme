<?php

/**
 * DNS预解析
 */
return function($links) 
{
    if ( ! $links) return;
    // var_dump(explode(PHP_EOL,$links));
    add_action( 'wp_head', function() use($links){
        $links = explode(PHP_EOL,$links); // 按换行符截取字符串
        $html = '<meta http-equiv="x-dns-prefetch-control" content="on">'."\n";
        foreach($links as $link){
            $html.='<link rel="dns-prefetch" href="'.$link.'">'."\n";
        }
        echo $html;
    }, 1 );
};
