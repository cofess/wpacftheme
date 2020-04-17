<?php


return array(
    /*
    |--------------------------------------------------------------------------
    | Frontend
    |--------------------------------------------------------------------------
    |
    | Determine frontend settings
    |
    */
    'frontend' => [
        'assets' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | System Tooling
    |--------------------------------------------------------------------------
    |
    | Enable system tools.
    |
    */
    'system' => [
        'ssl' => false,
        'on_demand_image_sizing' => false
    ],

    /*
    |--------------------------------------------------------------------------
    | Post Messages
    |--------------------------------------------------------------------------
    |
    | Determine admin settings
    |
    */
    'admin' => [
        'post_messages' => true,
    ],
    

    'routes' => [
        /*
        |--------------------------------------------------------------------------
        | Routing Hook
        |--------------------------------------------------------------------------
        |
        | Determine how routes are loaded and used. If you want routes
        | loaded instantly set hook to _instant_. Other hook options
        | include: muplugins_loaded, plugins_loaded, or setup_theme
        |
        | Default option: typerocket_loaded
        |
        */
        'hook' => 'typerocket_loaded',

        /*
        |--------------------------------------------------------------------------
        | Match Routes
        |--------------------------------------------------------------------------
        |
        | Routing rules and configurations. Updating these settings can effect
        | third-party and official plugins or extensions. Only update these
        | settings if you are sure it will not break your site.
        |
        | Match options: null or 'site_url'
        |
        */
        'match' => 'site_url',
    ],

    /*
    |--------------------------------------------------------------------------
    | custom post type
    |--------------------------------------------------------------------------
    | 自定义内容类型
    | https://www.wpbeginner.com/wp-tutorials/how-to-add-categories-to-a-custom-post-type-in-wordpress/
    |
    */
    'post-types' => array(
        'banner',  // 轮播
        'service', // 服务
        'product', // 产品
        'module', // 产品导航
        'portfolio', // 作品
        'project', // 项目、案例
        'download', // 下载
        'faq', // 常见问题
        'knowledge', // 帮助文档
        'glossary', // 术语解释
        'testimonial', // 客户评价
        'event', // 活动
        'video', // 视频
        'topic', // 专题
    ),

    /*
    |--------------------------------------------------------------------------
    | meta box
    |--------------------------------------------------------------------------
    |
    */
    'meta-boxs' => array(
        'post-meta-box-side',  // 文章meta-box
        'post-meta-box-tab', // 文章meta-box
        'page-meta-box', // 页面meta-box
        'taxonomy-meta-box', // 分类meta-box
        'user-meta-box', // 用户meta-box
    ),

    /*
    |--------------------------------------------------------------------------
    | custom widgets
    |--------------------------------------------------------------------------
    | 自定义小工具
    |
    */
    'widgets' => array(
        'author-profile-widget',
        'content-list-widget',
        'daterange-posts-widget',
        'follow-us-widget',
        'image-promotion-widget',
        'message-board-widget',
        'navmenu-widget',
        'popular-post-widget',
        'popular-tag-widget',
        'post-slider-widget',
        'posts-widget',
        'posts-with-thumb-widget',
        'post-tab-widget',
        'promotion-widget',
        'qq-group-widget',
        'random-post-widget',
        'recent-update-post-widget',
        'recommend-column-widget',
        'recommend-content-widget',
        'same-category-posts-widget',
        'site-profile-widget',
        'special-recommend-widget',
        'tag-cloud-widget'
    ),

    /*
    |--------------------------------------------------------------------------
    | plugins
    |--------------------------------------------------------------------------
    | 插件
    |
    */
    'plugins' => array(
        'plugin-brand', // 品牌插件
        'plugin-cloud-storage',  // 云存储
        'plugin-content-block',  // 区块插件
        'plugin-home-layout', // 首页布局设置插件
        'plugin-module-options', // 模块设置插件
        'plugin-floating-menu', // 悬浮菜单插件
    ),

    /*
    |--------------------------------------------------------------------------
    | plugin config
    |--------------------------------------------------------------------------
    | 插件设置
    |
    */
   // 品牌插件
   'plugin-brand' => array(
        'post-types' => array(
            'office', // 自定义内容类型：分公司
            'person',  // 自定义内容类型：团队
            'gallery', // 自定义内容类型：图集
            'job', // 自定义内容类型：职位
        ),
        'options' => array(
            'brand-values', // 文化价值观
            'brand-honors',  // 企业荣誉
            'brand-story', // 发展历程
            'brand-data', // 数据展示
            'brand-features', // 核心优势
            'brand-partners', // 合作伙伴
        ),
    ),
    // 模块设置插件 
   'plugin-module-options' => array(
        'options' => array(
            'list-ads',  // 列表页广告
            'single-ads', // 详情页广告
        ),
    ),

);
