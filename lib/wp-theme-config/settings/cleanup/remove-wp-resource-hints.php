<?php

/**
 * remove dns-prefetch //s.w.org
 * http://zmingcx.com/ban-load-s-w-org.html
 */
return function()
{
    if (!is_admin()) {
        // remove dns-prefetch //s.w.org
        remove_action( 'wp_head', 'wp_resource_hints', 2 );
    }
};