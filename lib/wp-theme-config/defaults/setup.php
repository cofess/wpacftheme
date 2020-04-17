<?php

return array(

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
        // 'Primary Menu'
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

        // array(
        //     'name'          => __('侧边栏','BT_TEXTDOMAIN'),
        //     'id'            => 'sidebar',
        //     'description'   => __('通用侧边栏','BT_TEXTDOMAIN'),
        //     'before_widget' => '<div class="sidebar_item widget %2$s">',
        //     'after_widget'  => '</div>',
        //     'before_title'  => '<h3><span>',
        //     'after_title'   => '</span></h3>',
        // ),

    ),

    /*
    |--------------------------------------------------------------------------
    | Create pages
    |--------------------------------------------------------------------------
    |
    */

    'pages' => array(
        // array(
        //     'title'         => __('全宽页面','BT_TEXTDOMAIN'),
        //     'slug'          => 'page-full',
        //     'template'      => 'templates/page-full.php',
        // ),
    ),

    /*
    |--------------------------------------------------------------------------
    | post status 自定义文章状态
    |--------------------------------------------------------------------------
    | https://developer.wordpress.org/reference/functions/register_post_status/
    |
    */
   
    'post-status' => array(
        // array(
        //     'status'    => 'rejected',
        //     'args'      => array(
        //         'label'                     => __('退稿','BT_TEXTDOMAIN'),
        //         'public'                    => false,
        //         'exclude_from_search'       => false,
        //         'show_in_admin_all_list'    => true,
        //         'show_in_admin_status_list' => true,
        //         'label_count'               => _n_noop( '退稿 <span class="count">(%s)</span>', '退稿 <span class="count">(%s)</span>' ),
        //     ),
        // ),
    ),

);
