<?php

/**
 * XML-PRC接口，即XML远程方法调用
 * http://www.wopus.org/wordpress-deepin/tech/2358.html
 */
return function($value) 
{
    if ( ! $value) return;
    
    add_filter( 'xmlrpc_methods', function(){
        unset( $methods['pingback.ping'] );
	    return $methods;
    });

    remove_action('wp_head','rsd_link');
	remove_action('wp_head','wlwmanifest_link');
	add_filter('xmlrpc_enabled', '__return_false'); 
};
