<?php

/**
 * Disable WooCommerce Cart Fragmentation
 */
return function() 
{
    add_action('wp_enqueue_scripts', 'disable_woocommerce_cart_fragmentation', 99);

    function disable_woocommerce_cart_fragmentation() {
        if(function_exists('is_woocommerce')) {
            wp_dequeue_script('wc-cart-fragments');
        }
    }
    
};
