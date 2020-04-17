<?php

/**
 * 关闭pingback和trackback
 * 参考：http://www.wfuyu.com/wordpress/609.html
 */
return function($value) 
{
    if ( ! $value) return;
    
    // Remove pingback method
    function disable_trackbacks_step1($method) {
        unset($method['pingback.ping']);
        unset($method['pingback.extensions.getPingbacks']);
        return $method;
    }
  
    // Remove header
    function disable_trackbacks_step2($headers) {
        if(isset($headers['X-Pingback'])) {
            unset($headers['X-Pingback']);
        }
        return $headers;
    }
    
    // Remove trackback rewrite
    function disable_trackbacks_step3($rules) {
        foreach($rules as $rule => $rewrite) {
            if(preg_match('/trackback\/\?\$$/i', $rule)) {
                unset($rules[$rule]);
            }
        }
        return $rules;
    }
    
    // Remove bloginfo(pingback_url)
    function disable_trackbacks_step4($output, $show) {
        if($show == 'pingback_url') {
            $output = '';
        }
        return $output;
    }
    
    // Disable XMLRPC
    function disable_trackbacks_step5($action) {
        if($action == 'pingback.ping') {
            wp_die('Pingbacks are not supported', 'Not Allowed!', array('response' => 403));
        }
    } 

    //禁用 pingbacks, enclosures, trackbacks
    remove_action( 'do_pings', 'do_all_pings', 10 );
    
    //去掉 _encloseme 和 do_ping 操作。
	remove_action( 'publish_post','_publish_post_hook',5 );

    // add filter
    add_filter('xmlrpc_methods', 'disable_trackbacks_step1', 10, 1);
    add_filter('wp_headers', 'disable_trackbacks_step2', 10, 1);
    add_filter('rewrite_rules_array', 'disable_trackbacks_step3');
    add_filter('bloginfo_url', 'disable_trackbacks_step4', 10, 2);
    add_action('xmlrpc_call', 'disable_trackbacks_step5');
};
