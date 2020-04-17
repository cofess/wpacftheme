<?php

return function($widgets)
{
    add_action('wp_dashboard_setup', function() use($widgets) {
        foreach( $widgets as $widget){
            remove_meta_box($widget, 'dashboard', 'normal');
        }
    } );
};