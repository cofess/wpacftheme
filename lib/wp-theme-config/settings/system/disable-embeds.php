<?php

/**
 * wordpress 4.4禁用embeds功能 移除wp-embed.min.js文件
 * http://www.iztwp.com/article/disable-embeds.html
 */
return function() 
{
    if (version_compare(get_bloginfo('version'),'5.0.2') >= 0) return;
    
    add_action('init', 'disable_embeds');
    // Disable Embeds
    function disable_embeds(){
        /* @var WP $wp */
        global $wp;

        // Remove the embed query var.
        $wp->public_query_vars = array_diff( $wp->public_query_vars, array(
            'embed',
        ) );

        // Remove the REST API endpoint.
        remove_action( 'rest_api_init', 'wp_oembed_register_route' );
        remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10);

        // No auto-embedding support
		add_filter('pre_option_embed_autourls', '__return_false');

        // Turn off
        add_filter( 'embed_oembed_discover', '__return_false' );

        // Don't filter oEmbed results.
        remove_filter( 'oembed_dataparse', 'wp_filter_oembed_result', 10 );

        // Remove oEmbed discovery links.
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );

        // Remove oEmbed-specific JavaScript from the front-end and back-end.
        remove_action( 'wp_head', 'wp_oembed_add_host_js' );
        add_filter( 'tiny_mce_plugins', 'disable_embeds_tiny_mce_plugin' );

        // Remove all embeds rewrite rules.
        add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );

        remove_filter( 'pre_oembed_result', 'wp_filter_pre_oembed_result', 10 );

        wp_deregister_script('wp-embed');
    }
    
    /**
     * Removes the 'wpembed' TinyMCE plugin.
     *
     * @since 1.0.0
     *
     * @param array $plugins List of TinyMCE plugins.
     * @return array The modified list.
     */
    function disable_embeds_tiny_mce_plugin( $plugins ) {
        return array_diff( $plugins, array( 'wpembed' ) );
    }

    /**
     * Remove all rewrite rules related to embeds.
     *
     * @since 1.2.0
     *
     * @param array $rules WordPress rewrite rules.
     * @return array Rewrite rules without embeds rules.
     */
    function disable_embeds_rewrites( $rules ) {
        foreach ( $rules as $rule => $rewrite ) {
            if ( false !== strpos( $rewrite, 'embed=true' ) ) {
                unset( $rules[ $rule ] );
            }
        }

        return $rules;
    }

    /**
     * Remove embeds rewrite rules on plugin activation.
     *
     * @since 1.2.0
     */
    function disable_embeds_remove_rewrite_rules() {
        add_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
        flush_rewrite_rules();
    }

    register_activation_hook( __FILE__, 'disable_embeds_remove_rewrite_rules' );

    /**
     * Flush rewrite rules on plugin deactivation.
     *
     * @since 1.2.0
     */
    function disable_embeds_flush_rewrite_rules() {
        remove_filter( 'rewrite_rules_array', 'disable_embeds_rewrites' );
        flush_rewrite_rules();
    }

    register_deactivation_hook( __FILE__, 'disable_embeds_flush_rewrite_rules' );
    
};
