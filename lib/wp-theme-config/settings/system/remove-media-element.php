<?php

/**
 * Remove Media Element
 * 有bug，会导致codestar framework 上传组件无效
 */
return function($option)
{
    // add_action('init', 'remove_media_element', 10);
    // function remove_media_element()
    // {	
    //     wp_deregister_script('wp-mediaelement');
    //     wp_deregister_style('wp-mediaelement');
    // }
};