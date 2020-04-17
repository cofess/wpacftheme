<?php

/**
 * Disable wordpress update
 * 关闭系统更新检测
 */

return function($options)
{
    // Tell WP everything is up to date
	function disable_check_updates() {

		global $wp_version;

		// Return
		return (object) array(
			'last_checked' => time(),
			'version_checked' => $wp_version
		);

    }
    
    /*
    |--------------------------------------------------------------------------
    | Disable wordpress core update
    | 关闭核心程序更新
    |--------------------------------------------------------------------------
    |
    | https://wordpress.org/plugins/stops-core-theme-and-plugin-updates/
    |
    */
    /**
	 * Initialize and load the plugin stuff
	 *
	 * @since 		1.3
	 * @author 		scripts@schloebe.de
	 */
	function disable_core_updates_init() {
		/*
		 * Disable Core Updates
		 * 2.8 to 3.0
		 */
		remove_action( 'wp_version_check', 'wp_version_check' );
		remove_action( 'admin_init', '_maybe_update_core' );
		wp_clear_scheduled_hook( 'wp_version_check' );
		
		
		/*
		 * 3.0
		 */
		wp_clear_scheduled_hook( 'wp_version_check' );
		
		
		/*
		 * 3.7+
		 */
		remove_action( 'wp_maybe_auto_update', 'wp_maybe_auto_update' );
		remove_action( 'admin_init', 'wp_maybe_auto_update' );
		remove_action( 'admin_init', 'wp_auto_update_core' );
		wp_clear_scheduled_hook( 'wp_maybe_auto_update' );
	}
    if( in_array('update_core',$options) ){

        add_action( 'admin_init', 'disable_core_updates_init' );
		
		/*
		 * Disable Core Updates
		 * 2.8 to 3.0
		 */
		add_filter( 'pre_transient_update_core', 'disable_check_updates' );

		/*
		 * 3.0
		 */
        // add_filter( 'pre_site_transient_update_core', 'disable_check_updates' );
        add_filter( 'pre_site_transient_update_core', create_function('$a', "return null;") );
		

		/*
		 * Disable All Automatic Updates
		 * 3.7+
		 * 
		 * @author	sLa NGjI's @ slangji.wordpress.com
		 */
		add_filter( 'automatic_updater_disabled', '__return_true' );
		add_filter( 'allow_minor_auto_core_updates', '__return_false' );
		add_filter( 'allow_major_auto_core_updates', '__return_false' );
		add_filter( 'allow_dev_auto_core_updates', '__return_false' );
		add_filter( 'auto_update_core', '__return_false' );
		add_filter( 'wp_auto_update_core', '__return_false' );
		add_filter( 'auto_core_update_send_email', '__return_false' );
		add_filter( 'send_core_update_notification_email', '__return_false' );
		add_filter( 'automatic_updates_send_debug_email', '__return_false' );
		add_filter( 'automatic_updates_is_vcs_checkout', '__return_true' );
    }

    /*
    |--------------------------------------------------------------------------
    | Disable plugin update
    | 关闭插件更新
    |--------------------------------------------------------------------------
    |
    | https://wordpress.org/plugins/stops-core-theme-and-plugin-updates/
    |
    */
    /**
	 * Initialize and load the plugin stuff
	 *
	 * @since  1.3
	 * @author scripts@schloebe.de
	 */
	function disable_plugin_updates_init() {
		/*
		 * Disable Plugin Updates
		 * 2.8 to 3.0
		 */
		remove_action( 'load-plugins.php', 'wp_update_plugins' );
		remove_action( 'load-update.php', 'wp_update_plugins' );
		remove_action( 'admin_init', '_maybe_update_plugins' );
		remove_action( 'wp_update_plugins', 'wp_update_plugins' );
		wp_clear_scheduled_hook( 'wp_update_plugins' );
		
		/*
		 * 3.0
		 */
		remove_action( 'load-update-core.php', 'wp_update_plugins' );
		wp_clear_scheduled_hook( 'wp_update_plugins' );
		
	}
    if( in_array('update_plugins',$options) ){
        
        add_action( 'admin_init', 'disable_plugin_updates_init' );
		
		/*
		 * Disable Plugin Updates
		 * 2.8 to 3.0
		 */
        add_action( 'pre_transient_update_plugins', 'disable_check_updates' );
        
        /*
		 * 3.0
		 */
        // add_filter( 'pre_site_transient_update_plugins', 'disable_check_updates' );
        add_filter( 'pre_site_transient_update_plugins', create_function('$a', "return null;") );
		
		/*
		 * Disable All Automatic Updates
		 * 3.7+
		 * 
		 * @author	sLa NGjI's @ slangji.wordpress.com
		 */
		add_filter( 'auto_update_plugin', '__return_false' );
    }

    /*
    |--------------------------------------------------------------------------
    | Disable theme update
    | 关闭主题更新
    |--------------------------------------------------------------------------
    |
    | https://wordpress.org/plugins/stops-core-theme-and-plugin-updates/
    |
    */
    /**
	 * Initialize and load the plugin stuff
	 *
	 * @since  1.3
	 * @author scripts@schloebe.de
	 */
	function disable_theme_updates_init() {
		/*
		 * Disable Theme Updates
		 * 2.8 to 3.0
		 */
		remove_action( 'load-themes.php', 'wp_update_themes' );
		remove_action( 'load-update.php', 'wp_update_themes' );
		remove_action( 'admin_init', '_maybe_update_themes' );
		remove_action( 'wp_update_themes', 'wp_update_themes' );
		wp_clear_scheduled_hook( 'wp_update_themes' );
		
		/*
		 * 3.0
		 */
		remove_action( 'load-update-core.php', 'wp_update_themes' );
		wp_clear_scheduled_hook( 'wp_update_themes' );
		
    }
    
    if( in_array('update_themes',$options) ){

        add_action( 'admin_init', 'disable_theme_updates_init' );
		
		/*
		 * Disable Theme Updates
		 * 2.8 to 3.0
		 */
        add_filter( 'pre_transient_update_themes', 'disable_check_updates' );
        
        /*
		 * 3.0
		 */
        // add_filter( 'pre_site_transient_update_themes', 'disable_check_updates' );
        add_filter( 'pre_site_transient_update_themes', create_function( '$a', "return null;" ) );
		
		/*
		 * Disable All Automatic Updates
		 * 3.7+
		 * 
		 * @author	sLa NGjI's @ slangji.wordpress.com
		 */
        add_filter( 'auto_update_theme', '__return_false' );
    }

    /*
    |--------------------------------------------------------------------------
    | Disable translations update
    | 关闭翻译文件更新
    |--------------------------------------------------------------------------
    |
    | https://wordpress.org/plugins/stops-core-theme-and-plugin-updates/
    |
    */
    if( in_array('update_translation',$options) ){
        /*
		 * Disable All Automatic Updates
		 * 3.7+
		 * 
		 * @author	sLa NGjI's @ slangji.wordpress.com
		 */
		add_filter( 'auto_update_translation', '__return_false' );	
    }
    
    /*
    |--------------------------------------------------------------------------
    | Remove Updates page from the admin menu
    | 删除“更新”菜单
    |--------------------------------------------------------------------------
    */
    function action_remove_update_menu() {
        $page = remove_submenu_page( 'index.php', 'update-core.php' );
    }	

    if( count(array_intersect($options,array( 'update_core', 'update_plugins', 'update_themes', 'update_translation' ))) == 4 ){
        add_action( 'admin_menu', 'action_remove_update_menu', 999 );
    }
};
