<?php

/**
 * 链接管理
 * enable link manager
 */
return function($value) 
{
    if ( ! $value) return;
    
    add_filter( 'pre_option_link_manager_enabled', '__return_true' );
};
