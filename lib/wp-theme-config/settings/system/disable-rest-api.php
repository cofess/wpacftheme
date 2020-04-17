<?php

/**
 * 禁用 WordPress 的 JSON REST API 
 * http://www.wpdaxue.com/disable-json-rest-api-in-wordpress.html
 * http://www.mfbuluo.com/21008.html
 */
return function() 
{
    
    /**
    * Remove WP API Links and Scripts
    */
    remove_action( 'wp_head', 'rest_output_link_wp_head' );
    // remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

    /**
    * Remove WP API Link from HTTP Headers
    */
    remove_action( 'template_redirect', 'rest_output_link_header', 11 );

    /**
    * Disable WP API Feature
    */
    add_filter( 'json_enabled', '__return_false' );
    add_filter( 'json_jsonp_enabled', '__return_false' );
    add_filter( 'rest_enabled', '__return_false' );
    add_filter( 'rest_jsonp_enabled', '__return_false' );

    // show error message
    add_filter( 'rest_authentication_errors', 'wp_snippet_disable_rest_api' );
    function wp_snippet_disable_rest_api( $access ) {
        return new WP_Error( 'rest_disabled', __('The WordPress REST API has been disabled.'), array( 'status' => rest_authorization_required_code()));
    }
};