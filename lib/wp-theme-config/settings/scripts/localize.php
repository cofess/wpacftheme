<?php

/**
 * localize scripts
 * 脚本本地化
 */
return function($options) {
    add_action('wp_enqueue_scripts', function()use($options) {
        foreach ($options as $localize) {
            wp_enqueue_script($localize['handle']);
            wp_localize_script($localize['handle'], $localize['name'], $localize['data']);
        } 
    });
} ;
