<?php

/**
 * Disable wordpress update
 * 关闭系统更新检测
 */

return function($value)
{
    // Tell WP everything is up to date
	function filter_prevent_updates() {

		global $wp_version;

		// Return
		return (object) array(
			'last_checked' => time(),
			'version_checked' => $wp_version
		);

    }
    
    // Stop checking for core, plugin, theme updates
	add_filter( 'pre_site_transient_update_core', 'filter_prevent_updates' );
	add_filter( 'pre_site_transient_update_plugins', 'filter_prevent_updates' );
    add_filter( 'pre_site_transient_update_themes', 'filter_prevent_updates' );
    
    // Remove Updates page from the admin menu
    add_action( 'admin_menu', 'action_remove_update_menu', 999 );
    function action_remove_update_menu() {
        $page = remove_submenu_page( 'index.php', 'update-core.php' );
    }	
};
