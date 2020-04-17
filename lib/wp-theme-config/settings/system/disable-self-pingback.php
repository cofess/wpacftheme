<?php

/**
 * 禁止WordPress向站内链接发送PingBack引用通告
 * 参考：http://www.wpdaxue.com/disable-self-ping.html
 */
return function($value) 
{
    if ( ! $value) return;
    
    add_action( 'pre_ping', function(){
        $home = get_option('home');
        foreach($links as $l => $link) {
            if(strpos($link, $home) === 0) {
                unset($links[$l]);
            }
        }
    } );
};
