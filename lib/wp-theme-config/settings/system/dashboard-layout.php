<?php

/**
 * WordPress 仪表盘布局
 * http://www.wpdaxue.com/wordpress-3-8-single-column-dashboard.html
 */
return function($col) 
{
    function dashboard_screen_layout_columns($columns) {
        $columns['dashboard'] = 3;
        return $columns;
    }
    add_filter('screen_layout_columns', 'dashboard_screen_layout_columns');
     
    add_filter('get_user_option_screen_layout_dashboard', function() use($col){
        return $col;
    });
};