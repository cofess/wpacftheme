<?php

/**
 * 搜索结果与标签自动跳转 
 * http://www.51php.com/wordpress/24077.html
 */

 return function($value)
 {
    add_action('template_redirect', 'redirect_single_post'); 
    function redirect_single_post() { 
        if (is_tag() || is_search()) { 
            global $wp_query; 
            if ($wp_query->post_count == 1) { 
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) ); 
            } 
        }
    }
 };