<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | body class
    |--------------------------------------------------------------------------
    | https://developer.wordpress.org/reference/functions/body_class/
    |
    */
    'body-class' => array(
        'hold-transition',
        'no-radius-all'
    ),

    /*
    |--------------------------------------------------------------------------
    | Register menu locations
    |--------------------------------------------------------------------------
    |
    | Array of menu titles.
    | Menus are automatically registered with a slugified version of the title.
    |
    | http://codex.wordpress.org/Function_Reference/register_nav_menus
    |
    */

    'menus' => array(
        'Primary Menu'
    ),

    /*
    |--------------------------------------------------------------------------
    | Register sidebar
    |--------------------------------------------------------------------------
    |
    | Array of sidebar.
    |
    | https://codex.wordpress.org/Function_Reference/register_sidebar
    |
    */

    'sidebars' => array(

        array(
            'name'          => __('侧边栏','BT_TEXTDOMAIN'),
            'id'            => 'sidebar',
            'description'   => __('通用侧边栏','BT_TEXTDOMAIN'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ),

        array(
            'name'          => __('文章侧边栏','BT_TEXTDOMAIN'),
            'id'            => 'post-sidebar',
            'description'   => __('文章侧边栏','BT_TEXTDOMAIN'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ),

        array(
            'name'          => __('页面侧边栏','BT_TEXTDOMAIN'),
            'id'            => 'page-sidebar',
            'description'   => __('页面侧边栏','BT_TEXTDOMAIN'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ),

        array(
            'name'          => __('分类/标签/搜索页侧栏','BT_TEXTDOMAIN'),
            'id'            => 'other-sidebar',
            'description'   => __('分类/标签/搜索页侧栏','BT_TEXTDOMAIN'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ),

        array(  
            'name'          => __('文章内容顶部','BT_TEXTDOMAIN'),
            'id'            => 'content-top-adsense',
            'description'   => __('文章详情页顶部','BT_TEXTDOMAIN'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        ),

        array(  
            'name'          => __('文章内容底部','BT_TEXTDOMAIN'),
            'id'            => 'content-bottom-adsense',
            'description'   => __('文章详情页底部','BT_TEXTDOMAIN'),
            'before_widget' => '<div class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title"><span>',
            'after_title'   => '</span></h3>',
        )
    ),

    /*
    |--------------------------------------------------------------------------
    | Create pages
    |--------------------------------------------------------------------------
    |
    */

    'pages' => array(
        array(
            'title'         => __('全宽页面','BT_TEXTDOMAIN'),
            'slug'          => 'page-full',
            'template'      => 'views/page-full.php',
        ),
    ),
  
    /*
    |--------------------------------------------------------------------------
    | Archives pagination 自定义每页显示文章数
    |--------------------------------------------------------------------------
    | https://jonchristopher.us/blog/wordpress-posts-per-page-per-custom-post-type/
    |
    */
    // 'posts-per-page' => array(
    //     array(
    //         'post_type' => 'post',
    //         'per_page'  => 12,
    //     ),

    //     array(
    //         'post_type' => 'product',
    //         'per_page'  => 60,
    //     ),

    //     array(
    //         'post_type' => 'gallery',
    //         'per_page'  => 12,
    //     ),

    //     array(
    //         'post_type' => 'knowledge',
    //         'per_page'  => 20,
    //     )
    // ),

);
