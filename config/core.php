<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | admin theme 自定义后台外观
    |--------------------------------------------------------------------------
    | https://frique.me/clientside/
    |
    */
    'custom-admin-appearance' => true,
    'admin-theme' => false,
    'hide-separators' => true,
    'menu-collapsed' => false,
    'admin-favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | vendor 第三方插件
    |--------------------------------------------------------------------------
    */
    'vendors' => array(
        'disable-admin-notices' => true, // 通知中心
        'easy-redirect-manager' => true, // 重定向管理
        'posts-per-page' => true, // 分页设置
        'rewrite-rules-inspector' => true, // 重定向管理
        'smtp-mailer' => true, // 邮件服务器
        'user-switching' => true, // 调试：用户切换
        'wp-crontrol' => true, // 定时人物
        'wp-sweep' => true, // 数据库优化
        'wp-system-info' => true, // 系统信息
        'xml-sitemap-feed' => true, // sitemap网站地图
    ),
   

    /*
    |--------------------------------------------------------------------------
    | Custom error handling 自定义错误处理
    |--------------------------------------------------------------------------
    | https://frique.me/clientside/
    |
    */
    'custom-error-handle' => false,

    /*
    |--------------------------------------------------------------------------
    | 网站前台语言
    |--------------------------------------------------------------------------
    | example: 'zh_CN','en_US'
    */

    // 'front-language' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | post status 自定义文章状态
    |--------------------------------------------------------------------------
    | https://developer.wordpress.org/reference/functions/register_post_status/
    |
    */
   
    'post-status' => array(
        array(
            'status' => 'rejected',
            'args'   => array(
                'label'                     => __('退稿','BT_TEXTDOMAIN'),
                'public'                    => false,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( '退稿 <span class="count">(%s)</span>', '退稿 <span class="count">(%s)</span>' ),
            ),
        ),
        array(
            'status' => 'excellent',
            'args'   => array(
                'label'                     => __('加精','BT_TEXTDOMAIN'),
                'public'                    => true,
                'exclude_from_search'       => false,
                'show_in_admin_all_list'    => true,
                'show_in_admin_status_list' => true,
                'label_count'               => _n_noop( '加精 <span class="count">(%s)</span>', '加精 <span class="count">(%s)</span>' ),
            ),
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | floating menu
    |--------------------------------------------------------------------------
    | 后台悬浮菜单
    |
    */
    'floating-menu' => true,
    'menu-items'    => array(
        'event'      => 'hover', // option: 'hover' | 'click'
        'effect'     => 'zoomin', // option: 'zoomin' | 'slidein'
        'position'   => 'br', // option: 'tl' | 'tr' | 'bl' | 'br'
        'background' => '#e91e63',
        'links'      => array(
            array(
                'icon'  => 'dashicons-before dashicons-edit',
                'title' => __('Add New Product','CS_TEXTDOMAIN'),
                'url'   => admin_url('edit.php?post_type=product')
            ),
            array(
                'icon'  => 'dashicons-before dashicons-admin-post',
                'title' => __('Add New Post','CS_TEXTDOMAIN'),
                'url'   => admin_url('post-new.php')
            ),
            array(
                'icon'  => 'dashicons-before dashicons-admin-page',
                'title' => __('Add New Page','CS_TEXTDOMAIN'),
                'url'   => admin_url('post-new.php?post_type=page')
            )
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | first letter avatar
    |--------------------------------------------------------------------------
    | 首字头像
    |
    */
    'first-letter-avatar' => true,

    /*
    |--------------------------------------------------------------------------
    | remove meta box
    |--------------------------------------------------------------------------
    | https://codex.wordpress.org/Function_Reference/remove_meta_box
    | @para role 'administrator','editor','author','contributor','subscriber'
    */
    'remove-meta-boxes' => array(
        // Author metabox
        // array(
        //     'id'   => 'authordiv',
        //     'page' => array('post','page'),
        //     'role' => 'editor'
        // ),
        // Comments status metabox (discussion)
        array(
            'id'   => 'commentstatusdiv',
            'page' => array('post','page'),
            'role' => array('editor','author','contributor','subscriber')
        ),
        // Comments metabox
        array(
            'id'   => 'commentsdiv',
            'page' => array('post','page'),
            'role' => array('editor','author','contributor','subscriber')
        ),
        // Custom fields metabox
        array(
            'id'   => 'postcustom',
            'page' => array('post','page'),
            'role' => array('editor','author','contributor','subscriber')
        ),
        // Revisions metabox
        array(
            'id'   => 'revisionsdiv',
            'page' => array('post','page'),
            'role' => array('editor','author','contributor','subscriber')
        ),
        // Slug metabox
        array(
            'id'   => 'slugdiv',
            'page' => array('post','page'),
        ),
        // Trackbacks metabox
        array(
            'id'   => 'trackbacksdiv',
            'page' => array('post','page'),
        )
    ),

    /*
    |--------------------------------------------------------------------------
    | "post" 内容类型支持归档
    | has_archive for default post type
    |--------------------------------------------------------------------------
    | https://wordpress.stackexchange.com/questions/31089/has-archive-for-default-post-type
    */
    'default-post-type-archive' => true,

    /*
    |--------------------------------------------------------------------------
    | 自动保存远程图片（外链图片）
    |--------------------------------------------------------------------------
    | http://zmingcx.com/
    */
    'save-remote-image' => false,

    /*
    |--------------------------------------------------------------------------
    | 修正自定义文章类型更新提示
    |--------------------------------------------------------------------------
    | https://blog.wpjam.com/m/wpjam-post_updated_messages/
    */
    'fixed-post-updated-messages' => false,

    /*
    |--------------------------------------------------------------------------
    | 修正自定义分类更新提示
    |--------------------------------------------------------------------------
    | https://blog.wpjam.com/m/wpjam-term_updated_messages/
    */
    'fixed-term-updated-messages' => true,

    /*
    |--------------------------------------------------------------------------
    | 快速编辑-修改文章缩略图
    |--------------------------------------------------------------------------
    | https://rudrastyh.com/wordpress/quick-edit-featured-image.html
    */
    'featured-image-quick-edit'   => true,

);