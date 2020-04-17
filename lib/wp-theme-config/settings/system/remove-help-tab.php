<?php

/**
 * 隐藏WordPress后台帮助链接
 * http://www.solagirl.net/how-to-remove-screen-options-help-tabs.html
 */
return function() 
{
    function remove_help_tab($old_help, $screen_id, $screen){
        $screen->remove_help_tabs();
        return $old_help;
    }
    
    if( !current_user_can('administrator') ) {
        add_filter( 'contextual_help', 'remove_help_tab', 999, 3 );
    }
};