<?php
/**
 * object-cache缓存配置
 * 将object-cache.php 文件复制到 wp-content 目录下即可
 * https://blog.wpjam.com/m/wpjam-rewrite/
 */
return array(

    /*
    |--------------------------------------------------------------------------
    | 使用内存缓存优化 WordPress 文章编辑锁定功能
    |--------------------------------------------------------------------------
    |
    | https://blog.wpjam.com/m/optimize-wordpress-post-edit-lock/
    */
    
    'edit-lock-cache' => true,

    /*
    |--------------------------------------------------------------------------
    | 使用内存缓存优化 WordPress 文章浏览统计效率
    |--------------------------------------------------------------------------
    |
    | https://blog.wpjam.com/m/memcached-postviews/
    */
    
    'post-views-cache' => true,

    /*
    |--------------------------------------------------------------------------
    | 使用内存缓存优化 WordPress 主循环，实现首页 0 SQL
    |--------------------------------------------------------------------------
    |
    | https://blog.wpjam.com/m/cache-wp_query/
    */
    
    'wp-query-cache' => true,
);