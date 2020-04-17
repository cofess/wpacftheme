<?php

/**
 * dequeue jetpack devicepx
 */
return function() 
{
    function dequeue_jetpack_devicepx() {
        wp_dequeue_script( 'devicepx' );
    }
    add_action( 'wp_enqueue_scripts', 'dequeue_jetpack_devicepx', 20 );
    add_action( 'customize_controls_enqueue_scripts', 'dequeue_jetpack_devicepx', 20);
    add_action( 'admin_enqueue_scripts', 'dequeue_jetpack_devicepx', 20);
    //add_action('wp_enqueue_scripts', create_function(null, "wp_dequeue_script('devicepx');"), 20);//移除devicepx-jetpack.js
};
