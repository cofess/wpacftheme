<?php

/**
 * 主题颜色切换
 */
return function($color) {
    add_action( 'wp_enqueue_scripts', function() use($color){
    	$theme_color = cs_get_option( 'theme-switch','','_theme_options' );
        $css_path = get_template_directory_uri() . '/static/front/css/';
        $style = $css_path . 'style-' . $theme_color . '.css';
        wp_enqueue_style('theme', $style);
    });
};
