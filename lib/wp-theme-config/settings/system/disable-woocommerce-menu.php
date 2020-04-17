<?php

/**
 * Disable WooCommerce Menu
 */
return function() 
{
    function disable_woocommerce_menu() {
        remove_menu_page( 'woocommerce' );
    }
    add_action( 'admin_menu', 'disable_woocommerce_menu' );  
};
