<?php

/**
 * Disable WooCommerce Reviews Widgets
 */
return function() 
{
    add_action('widgets_init', 'disable_woocommerce_reviews', 99);

    function disable_woocommerce_reviews() {
    
        unregister_widget('WC_Widget_Recent_Reviews');
		unregister_widget('WC_Widget_Top_Rated_Products');
		unregister_widget('WC_Widget_Rating_Filter');
    
    }
    
};
