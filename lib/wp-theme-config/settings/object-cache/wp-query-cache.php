<?php
/*
 |--------------------------------------------------------------------------
 | 使用内存缓存优化 WordPress 主循环，实现首页 0 SQL
 |--------------------------------------------------------------------------
 |
 | https://blog.wpjam.com/m/cache-wp_query/
 */
return function($value) {
    add_filter('posts_pre_query', function ($pre, $wp_query){
        if(!$wp_query->is_main_query()){    // 只缓存主循环
            return $pre;
        }

        // $cache_key  = md5(maybe_serialize($wp_query->query_vars));
        $cache_key  = md5(maybe_serialize($wp_query->query_vars)).':'.wp_cache_get_last_changed('posts');

        $wp_query->set('cache_key', $cache_key);

        $post_ids   = wp_cache_get($cache_key, 'wpjam_post_ids');

        if($post_ids === false){
            return $pre;
        }

        return wpjam_get_posts($post_ids);
    }, 10, 2);

    add_filter('posts_results',  function ($posts, $wp_query) {
        $cache_key  = $wp_query->get('cache_key');

        if($cache_key){
            $post_ids   = wp_cache_get($cache_key, 'wpjam_post_ids');
            if($post_ids === false){
                wp_cache_set($cache_key, array_column($posts, 'ID'), 'wpjam_post_ids', DAY_IN_SECONDS);
            }
        }

        return $posts;
    }, 10, 2);
} ;
