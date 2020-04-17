<?php
if ( ! defined( 'ABSPATH' ) ) { die; } 

add_action( 'typerocket_loaded', function() {
    // deregister the wp-block-library CSS for the front-end of your site
    // https://github.com/TypeRocket/core/releases
    add_action('wp_enqueue_scripts', function() {
        $gb = \TypeRocket\Core\Config::locate('app.features.gutenberg');
        if(!gb){
            wp_deregister_style( 'wp-block-library' );
        }
    }, 1, 100);

    // plugin
    foreach($plugins = \TypeRocket\Core\Config::locate('typerocket.plugins') as $plugin){
        require_once THEME_DIR . '/lib/core/plugins/'.$plugin.'/init.php';
    }

    // custom post type
    foreach($post_types = \TypeRocket\Core\Config::locate('typerocket.post-types') as $post_type){
        require THEME_DIR . '/lib/core/post-type/'.$post_type.'-post-type.php';
    }

    // custom meta box
    foreach($meta_boxs = \TypeRocket\Core\Config::locate('typerocket.meta-boxs') as $meta_box){
        require THEME_DIR . '/lib/core/meta-box/'.$meta_box.'.php';
    }

    // custom widget
    foreach($widgets = \TypeRocket\Core\Config::locate('typerocket.widgets') as $widget){
        require THEME_DIR . '/lib/core/widget/'.$widget.'.php';
    }

    // custom post taxonomy
    require_once THEME_DIR . '/lib/core/taxonomy/post-taxonomy-series.php';

    // custom seo metabox
    // require_once THEME_DIR . '/lib/core/seo/taxonomy-meta-box-seo.php';
    // require_once THEME_DIR . '/lib/core/seo/user-meta-box-seo.php';

    // custom theme options
    add_filter('tr_theme_options_page', function() {
        return THEME_DIR . '/lib/core/theme-options/theme-options.php';
    });

    // post type options
    require_once THEME_DIR . '/lib/core/post-type-options/post-type-options.php';

    // Adding builder to a custom post type
    add_filter( 'tr_builder_post_types', function( $post_types ) {
        $post_types = array('block','module');
        return $post_types; // need to return the whole list of post types
    } );
    new \TypeRocketPageBuilder\Plugin;

    // admin page
    // require_once THEME_DIR . '/lib/core/admin-page/post-type-manager.php';

    // form
    // require_once THEME_DIR . '/lib/core/form/form.php';
});
