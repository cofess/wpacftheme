<?php
return array(
    
    /*
    |--------------------------------------------------------------------------
    | Check Requirements 环境检测
    | https://github.com/Kubitomakita/Requirements
    |--------------------------------------------------------------------------
    |
    | * WordPress drop-in to check requirements
    */
   
    'require-check' => false,

    'require-check-options' => array(
        'php'            => '7.0',
        'php_extensions' => array( 'fileinfo','PDO','Mbstring' ),
        'wp'             => '4.8',
        'plugins'        => array(
            'akismet/akismet.php'   => array( 'name' => 'Akismet', 'version' => '3.0' ),
            'hello-dolly/hello.php' => array( 'name' => 'Hello Dolly', 'version' => '1.5' )
        ),
        'theme'              => array(
            'slug' => 'twentysixteen',
            'name' => 'Twenty Sixteen'
        ),
        'function_collision' => array( 'my_function_name', 'some_other_potential_collision' ),
        'class_collision'    => array( 'My_Test_Plugin', 'My_Test_Plugin_Other_Class' ),
        'custom_check'       => 'thing to check', // this is not default check and will have to be registered
    ),

    /*
    |--------------------------------------------------------------------------
    | TGM Plugin Activation 推荐安装插件
    | https://github.com/TGMPA/TGM-Plugin-Activation
    |--------------------------------------------------------------------------
    |
    | * allows you to easily require or recommend plugins for your WordPress themes (and plugins).
    */
   
    'require-plugins' => array(

        // This is an example of how to include a plugin bundled with a theme.
        array(
            'name'               => 'Thumbnails', // The plugin name.
            'slug'               => 'thumbnails', // The plugin slug (typically the folder name).
            'source'             => get_stylesheet_directory() . '/plugins/thumbnails.1.1.2.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.1.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => 'https://wordpress.org/plugins/thumbnails/', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

        // TypeRocket Framework
        array(
            'name'         => 'TypeRocket Framework 4', // The plugin name.
            'slug'         => 'typerocket-framework', // The plugin slug (typically the folder name).
            'required'     => true, // If false, the plugin is only 'recommended' instead of required.
            'version'      => 'v4.0.15',
            'source'       => 'https://codeload.github.com/TypeRocket/typerocket-framework/zip/v4.0.15', 
            'external_url' => 'https://github.com/TypeRocket/typerocket-framework',
        ),

        // Permalinks.
        array(
            'name'         => 'Custom Post Type Permalinks',
            'slug'         => 'custom-post-type-permalinks',
            'required'     => true,
            'source'       => 'https://codeload.github.com/torounit/custom-post-type-permalinks/zip/3.3.4',
            'external_url' => 'https://github.com/torounit/custom-post-type-permalinks',
        ),

        // Contact Form
        array(
            'name'         => 'WP Libre Form',
            'slug'         => 'wp-libre-form',
            'required'     => false,
            'source'       => get_stylesheet_directory() . '/plugins/wp-libre-form-1.5.0.2修复版.zip',
            'external_url' => 'https://github.com/libreform/wp-libre-form',
        ),

        // Media Folders
        array(
            'name'         => 'WP Real Media Library',
            'slug'         => 'real-media-library',
            'required'     => false,
            'source'       => get_stylesheet_directory() . '/plugins/wp-real-media-library_v406.zip',
            'external_url' => 'https://codecanyon.net/item/wordpress-real-media-library-media-categories-folders/13155134'
        ),

        // Post Folders
        array(
            'name'         => 'WP Real Categories Management',
            'slug'         => 'real-category-library',
            'required'     => false,
            'source'       => get_stylesheet_directory() . '/plugins/wp-real-media-library_v406.zip',
            'external_url' => 'https://codecanyon.net/item/wordpress-real-category-management-custom-category-order-tree-view/13580393'
        ),

        // Cache
        array(
            'name'         => 'WP Rocket',
            'slug'         => 'wp-rocket',
            'required'     => false,
            'source'       => get_stylesheet_directory() . '/plugins/wp-rocket3.0.3.zip',
            'external_url' => 'https://wp-rocket.me'
        ),

        // seo
        array(
            'name'         => 'Yoast Seo Premium',
            'slug'         => 'wordpress-seo-premium',
            'is_callable'  => 'wpseo_init',
            'required'     => false,
            'source'       => 'https://gitee.com/devbank/yoast-seo-premium/repository/archive/master.zip',
            'external_url' => 'https://yoast.com/wordpress/plugins/seo/'
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        // array(
        //     'name'     => 'BuddyPress',
        //     'slug'     => 'buddypress',
        //     'required' => false,
        // ),
    ),
);