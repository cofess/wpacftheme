<?php
/*
 |--------------------------------------------------------------------------
 | 使用内存缓存优化 WordPress 文章编辑锁定功能
 |--------------------------------------------------------------------------
 |
 | https://blog.wpjam.com/m/optimize-wordpress-post-edit-lock/
 */
return function($value) {
    add_filter('update_post_metadata', function($pre, $post_id, $meta_key, $meta_value) {
        if ($meta_key == '_edit_lock') {
            return wp_cache_set($post_id, $meta_value, 'wpjam_post_edit_lock', 300);
        } 

        return $pre;
    } , 10, 4);

    add_filter('get_post_metadata', function($pre, $post_id, $meta_key) {
        if ($meta_key == '_edit_lock') {
            return [wp_cache_get($post_id, 'wpjam_post_edit_lock')];
        } 

        return $pre;
    } , 10, 3);
} ;
