<?php

/**
 * Remove unnecessary dashboard widgets
 *
 * https://digwp.com/2014/02/disable-default-dashboard-widgets/
 * http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */

return function($widgets)
{
    add_action('admin_init', function() use($widgets) {
        remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
        foreach( $widgets as $widget){
            if( $widget == 'welcome_panel' ){
                remove_action('welcome_panel', 'wp_welcome_panel');
            } else{
                remove_meta_box($widget, 'dashboard', 'normal');
            }
        }
    });
};
