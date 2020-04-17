<?php

/**
 * 为WordPress页面（page）添加标签和分类功能
 * 参考：http://www.wpdaxue.com/post-tags-and-categories-for-pages.html
 */
return function($value) 
{
    if ( ! $value) return;

    add_action('init', function()
    {
        register_taxonomy_for_object_type( 'post_tag', 'page' );
        register_taxonomy_for_object_type( 'category', 'page' );
    });

    /**
     * 确保这些查询修改不会作用于管理后台，防止文章和页面混杂 
     * ensure all tags and categories are included in queries
     */
    if ( ! is_admin() ) {
        add_action( 'pre_get_posts', function($wp_query)
        {
            if ($wp_query->get('tag')) $wp_query->set('post_type', 'any');
            if ($wp_query->get('category_name')) $wp_query->set('post_type', 'any');
        });
    }
    
};
