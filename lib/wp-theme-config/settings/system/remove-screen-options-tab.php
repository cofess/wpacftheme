<?php

/**
 * 隐藏WordPress后台显示选项链接
 * http://www.solagirl.net/how-to-remove-screen-options-help-tabs.html
 */
return function() 
{
    if( !current_user_can('administrator') ) {
        add_filter('screen_options_show_screen', '__return_false');
    } 
};