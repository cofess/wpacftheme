<?php

/**
 * Remove wordpress version
 * 隐藏wordpress版本信息
 */

return function($value)
{
    // 移除head部分wordpress版本信息
    remove_action('wp_head', 'wp_generator');

    // 移除RSS订阅中wordpress版本信息
    add_filter('the_generator', '__return_false');

    /**
     * 隐藏仪表盘“概况”下的WordPress版本信息
     * http://www.wpdaxue.com/remove-dash-wordpress-version.html
     */
    function remove_dash_wordpress_version(){
        echo '<style type="text/css">
                #wp-version-message {display:none!important}
                </style>';
    }
    add_action('admin_head', 'remove_dash_wordpress_version' );

    /**
     * Modify footer text RIGHT
     * 自定义后台底部文字-right
     */
    add_filter('update_footer', 'clean_admin_footer_text_right', 1234);
    function clean_admin_footer_text_right($text) {
        // var_dump(sprintf( __( 'Version %s' ), '' ));
        if( strpos($text,sprintf( __( 'Version %s' ), '' )) !== false ){
            $text = '';
        }
        return $text;
    }
};
