<?php

/**
 * Remove jQuery Migrate
 */
return function($option)
{
    if(is_array($option) && in_array('frontend', $option)) {
        add_filter('wp_default_scripts', 'remove_frontend_jquery_migrate');
    }

    function remove_frontend_jquery_migrate(&$scripts) {
        if(!is_admin()) {
            $scripts->remove('jquery');
            $scripts->add('jquery', false, array( 'jquery-core' ), '1.12.4');
        }
    }

    /**
     * Disable jQuery Migrate in WordPress.
     *
     * @author Guy Dumais.
     * @link https://en.guydumais.digital/disable-jquery-migrate-in-wordpress/
     * @link https://wordpress.stackexchange.com/questions/224661/annoying-jqmigrate-migrate-is-in-console-after-update-to-wp-4-5
     */
    if(is_admin() && is_array($option) && in_array('admin', $option)) {
        add_filter( 'wp_default_scripts', function( &$scripts) {
            $scripts->remove( 'jquery');
            $scripts->add( 'jquery', false, array( 'jquery-core' ), '1.12.4' );  
        }, 99 );
    }
};