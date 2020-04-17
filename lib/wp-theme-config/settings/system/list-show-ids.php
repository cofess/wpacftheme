<?php

/**
 * 后台列表显示ID
 */
return function($value) 
{
    if ( ! $value) return;

    require WP_THEME_CONFIG_INCLUDE_DIR .'/wpsite-show-ids.php';
};