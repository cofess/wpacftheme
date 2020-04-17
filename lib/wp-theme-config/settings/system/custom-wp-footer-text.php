<?php

/**
 * Modify footer text
 * 自定义后台底部文字
 */
return function($value) 
{
    global $footer_text_left,$footer_text_right;
    $footer_text_left = $this->config['system.footer-text-left'];
    $footer_text_right = $this->config['system.footer-text-right'];

    if( $value == '1' ){
        $footer_text_left = '';
        $footer_text_right = '';
    }

    /**
     * Modify footer text LEFT
     * 自定义后台底部文字-left
     */
    add_filter('admin_footer_text', 'admin_footer_text_left');
    function admin_footer_text_left($text) {
        global $footer_text_left;
        $text = $footer_text_left;
        return $text;
    }

    /**
     * Modify footer text RIGHT
     * 自定义后台底部文字-right
     */
    add_filter('update_footer', 'admin_footer_text_right', 1234);
    function admin_footer_text_right($text) {
        global $footer_text_right;
        $text = $footer_text_right;
        return $text;
    }
};