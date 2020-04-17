<?php
/*
 |--------------------------------------------------------------------------
 | 使用内存缓存优化 WordPress 文章浏览统计效率
 |--------------------------------------------------------------------------
 | 另外可能存在一个小问题：由于 Memcached 的缓存不是持久的，如果不小心把将内存缓存的清空，文章的浏览数会丢失一部分，但是肯定少于10了。
 | https://blog.wpjam.com/m/memcached-postviews/
 */
return function($value) {
    // 更新文章浏览数的时候，首先更新到内存中，然后每10次，才写到数据库中
    add_filter('update_post_metadata', function($check, $post_id, $meta_key, $meta_value){
        if($meta_key == 'views'){
            if($meta_value % 10 != 0){
                $check  = true;

                wp_cache_set($post_id, $meta_value, 'views');
            }else{
                wp_cache_delete($post_id, 'views');
            }
        }

        return $check;
    }, 1, 4);

    // 获取文章浏览数的时候，首先从内存中获取，没有才从数据库中获取
    add_filter('get_post_metadata', function($pre, $post_id, $meta_key){
        if($meta_key == 'views'){
            $views  = wp_cache_get($post_id, 'views');

            if($views !== false){
                return [$views];
            }
        }

        return $pre;
    }, 1, 3);
} ;
