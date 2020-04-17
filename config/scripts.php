<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | jQuery
    |--------------------------------------------------------------------------
    |
    | Define paths to local and CDN-hosted versions of jQuery, as in HTML5
    | Boilerplate. Local path is relative to the theme, and CDN path should be
    | a protocol-independent path to a CDN-served version of jQuery. Set to
    | false to disable.
    |
    | https://github.com/h5bp/html5-boilerplate/blob/v4.3.0/doc/html.md#google-cdn-for-jquery
    |
    | Example CDN jQuery URL: '//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',
    |
    */

   'jquery-local'   => site_url() .'/wp-includes/js/jquery/jquery.js',
   'jquery-cdn'     => 'https://cdn.jsdelivr.net/npm/jquery@1.12.4/dist/jquery.min.js',

    /*
    |--------------------------------------------------------------------------
    | Public scripts
    |--------------------------------------------------------------------------
    |
    | The scripts listed here will be registered and opionally enqueued for the
    | public side in the order they are defined.
    |
    | Setting `enqueue` to `true` will enqueue the script globally.
    |
    | https://developer.wordpress.org/reference/functions/wp_register_script/
    |
    */
    'public' => array(

        array(
            'handle'        => 'bootstrap',
            'src'           => get_template_directory_uri() . '/static/public/js/bootstrap.min.js',
            'deps'          => array('jquery'),
            'ver'           => '3.3.7',
            'in_footer'     => true,
            'enqueue'       => true
        )

    ),

    /*
    |--------------------------------------------------------------------------
    | localize scripts 脚本本地化
    |--------------------------------------------------------------------------
    |
    |
    | Localizes a registered script with data for a JavaScript variable.
    |
    | https://codex.wordpress.org/Function_Reference/wp_localize_script
    |
    */

    'localize' => array(

        array(
            'handle'        => 'bootstrap',
            'name'          => 'globals',
            'data'          => array(
                'ajax_url' => admin_url("admin-ajax.php"),
                'url_theme' => get_template_directory_uri(),
                'single' => (is_single() ? 1 : 0),
                'home' => (is_home() ? 1 : 0),
                'page' => (is_page() ? 1 : 0),
            )
        ),

    ),

    /*
    |--------------------------------------------------------------------------
    | comment-reply 加载系统自带嵌套评论js
    |--------------------------------------------------------------------------
    */
    'comment-reply' => true,

    /*
    |--------------------------------------------------------------------------
    | Admin scripts
    |--------------------------------------------------------------------------
    |
    | The scripts listed here will be registered and optionally enqueued for the
    | admin side in the order they are defined.
    |
    | https://developer.wordpress.org/reference/functions/wp_register_script/
    |
    */
    'admin' => array(

        array(
            'handle'        => 'floating-menu',
            'src'           => get_template_directory_uri() . '/static/admin/js/floating-menu.js',
            'deps'          => array('jquery'),
            'ver'           => null,
            'in_footer'     => true,
            'enqueue'       => true
        ),

        array(
            'handle'        => 'clientside-admin',
            'src'           => get_template_directory_uri() . '/static/admin/js/clientside-admin.js',
            'deps'          => array('jquery'),
            'ver'           => null,
            'in_footer'     => true,
            'enqueue'       => true
        ),

        // array(
        //     'handle'        => 'admin',
        //     'src'           => get_template_directory_uri() . '/assets/dist/scripts/admin.js',
        //     'deps'          => array('jquery'),
        //     'ver'           => null,
        //     'in_footer'     => true,
        //     'enqueue'       => true
        // ),

    ),

);
