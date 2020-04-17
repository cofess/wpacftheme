<?php

/**
 * WordPress Browse Happy
 * http://browsehappy.com/
 */
return function($value) 
{
    if ( ! $value) return;

    add_action('admin_init', create_function( '$a', "remove_action('in_admin_footer', 'browse_happy');"));
};
