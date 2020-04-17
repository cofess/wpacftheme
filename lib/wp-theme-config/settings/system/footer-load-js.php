<?php

/**
 * 在 Footer 载入 jQuery 代码
 * 来自 http://www.arefly.com/wordpress-move-script-to-footer/
 */
return function($value)
{
    //在 Footer 载入 jQuery 代码
    remove_action('wp_head', 'wp_print_scripts');
    remove_action('wp_head', 'wp_print_head_scripts', 9);
    remove_action('wp_head', 'wp_enqueue_scripts', 1);
    add_action('wp_footer', 'wp_print_scripts', 5);
    add_action('wp_footer', 'wp_enqueue_scripts', 5);
    add_action('wp_footer', 'wp_print_head_scripts', 5);
};
