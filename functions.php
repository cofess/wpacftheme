<?php
 
/* File Security Check */ 
if ( ! defined( 'ABSPATH' ) ) { die; } 

/*
 |--------------------------------------------------------------------------
 | define
 |--------------------------------------------------------------------------
*/
 
/* Sets the path to the parent theme directory URI. */
if ( !defined( 'THEME_URI' ) ) {
	define( 'THEME_URI', get_template_directory_uri() );
}

/* Sets the path to the parent theme directory. */
if ( !defined( 'THEME_DIR' ) ) {
	define( 'THEME_DIR', get_template_directory() );
}

/* 第三方拓展目录 */
if ( !defined( 'VENDOR_DIR' ) ) {
	define( 'VENDOR_DIR', get_template_directory() . '/lib/vendor');
}

if ( !defined( 'VENDOR_URI' ) ) {
	define( 'VENDOR_URI', get_template_directory_uri() . '/lib/vendor');
}

/* 缓存目录 */
if ( !defined( 'CACAHE_DIR' ) ) {
	define( 'CACAHE_DIR', WP_CONTENT_DIR . '/cache');
}

if ( ! is_dir( CACAHE_DIR ) ) {
	@mkdir( CACAHE_DIR );
}

/*
 |--------------------------------------------------------------------------
 | 加载语言包
 |--------------------------------------------------------------------------
*/
add_action('after_setup_theme', 'load_theme_lang');
function load_theme_lang(){
    load_theme_textdomain( 'BT_TEXTDOMAIN', THEME_DIR . '/languages' );
}

/*
 |--------------------------------------------------------------------------
 | WordPress Library
 |--------------------------------------------------------------------------
*/
require_once 'lib/wp-lib/boot.php';
require_once 'lib/wp-lib-function/boot.php';

/**
 * wp-scss-compiler
 * https://github.com/NazarkinRoman/WP-SCSS-Compiler
 */
require_once 'lib/wp-scss-compiler/wp-scss-compiler.php';

/**
 * autoload
 */
require_once 'lib/autoload.php';

/*
 |--------------------------------------------------------------------------
 | load classes
 |--------------------------------------------------------------------------
*/
require_once 'lib/classes/breadcrumb.class.php';
require_once 'lib/classes/breadcrumb.php';
require_once 'lib/classes/category_template.php';
require_once 'lib/classes/custom-post-type-archive-in-menu.php';
require_once 'lib/classes/Pagination.php';
require_once 'lib/classes/simple-widget-classes.php';
require_once 'lib/classes/simple-featured-image-column.php';
require_once 'lib/classes/walkers/wp_bootstrap_comment_walker.php';
require_once 'lib/classes/walkers/wp_bootstrap_navwalker.php';
require_once 'lib/classes/walkers/wp_category_walker.php';
// require_once 'lib/classes/wp-export.php'; // 与sitemap插件冲突

/*
 |--------------------------------------------------------------------------
 | load inc functions
 |--------------------------------------------------------------------------
*/
require_once 'lib/inc/core.inc.php';
// require_once 'lib/inc/post-thumbnail.php';
require_once 'lib/inc/post-views.php';
require_once 'lib/inc/no-external-links.php';

/*
 |--------------------------------------------------------------------------
 | wp theme config
 |--------------------------------------------------------------------------
 | // get config option
 | // get all options
 | // var_dump(WpThemeConfig\Configurator::getInstance()->all());
 | // get one option
 | // var_dump(WpThemeConfig\Configurator::getInstance()->get('system.clean-wp-header'));
*/
require_once 'lib/wp-theme-config/Configurator.php';
require_once 'lib/wp-theme-config/Settings.php';
require_once 'lib/wp-theme-config/ThemeConfig.php';

// Initialize ThemeConfig.
WpThemeConfig\ThemeConfig::getInstance();

/*
 |--------------------------------------------------------------------------
 | Options Page
 |--------------------------------------------------------------------------
 | * github：https://github.com/Codestar/codestar-framework
 | * site：http://codestarframework.com/
*/
require_once 'lib/options-page/boot.php';

/*
 |--------------------------------------------------------------------------
 | theme init
 |--------------------------------------------------------------------------
*/
// autoload('/lib/init/', false, 'init.php');
require_once 'lib/init/admin.init.php';
// require_once 'lib/init/features.init.php';
require_once 'lib/init/plugin.init.php';
require_once 'lib/init/route.init.php';
require_once 'lib/init/shortcode.init.php';
require_once 'lib/init/theme.init.php';

/*
 |--------------------------------------------------------------------------
 | bigger生成封面
 |--------------------------------------------------------------------------
*/
require_once 'lib/poster/boot.php';

/*
 |--------------------------------------------------------------------------
 | typerocket
 |--------------------------------------------------------------------------
*/
require_once 'lib/core/boot.php';
// tr_frontend();

/*
 |--------------------------------------------------------------------------
 | load verdor
 |--------------------------------------------------------------------------
*/
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.disable-admin-notices')){
	require_once VENDOR_DIR . '/disable-admin-notices/disable-admin-notices.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.easy-redirect-manager')){
	require_once VENDOR_DIR . '/easy-redirect-manager/easy-redirect-manager.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.rewrite-rules-inspector')){
	require_once VENDOR_DIR . '/rewrite-rules-inspector/rewrite-rules-inspector.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.posts-per-page')){
	require_once VENDOR_DIR . '/posts-per-page/pppp.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.smtp-mailer')){
	require_once VENDOR_DIR . '/smtp-mailer/main.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.user-switching')){
	require_once VENDOR_DIR . '/user-switching/user-switching.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.wp-crontrol')){
	require_once VENDOR_DIR . '/wp-crontrol/wp-crontrol.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.wp-sweep')){
	require_once VENDOR_DIR . '/wp-sweep/wp-sweep.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.wp-system-info')){
	require_once VENDOR_DIR . '/wp-system-info/system-info.php';
}
if(WpThemeConfig\Configurator::getInstance()->get('core.vendors.xml-sitemap-feed')){
	require_once VENDOR_DIR . '/xml-sitemap-feed/xml-sitemap.php';
}

// log
if(!is_admin()){
	require_once 'lib/wp-log-in-browser/wp-log-in-browser.php';
	browser()->log( Lib\Core\Thumbnail::get_post_images(get_post(1)->post_content) , 'thumb' );
	browser()->log( Lib\Core\Thumbnail::get_post_thumbnail_uri(1));
}

// $user_agent = new Lib\UserAgent\UA;
// var_dump( $user_agent->user_agent(),$user_agent->Hostname(),$user_agent->OS(),$user_agent->get_referer(),$user_agent->parse_ip('123.125.115.110'));

// var_dump(get_letter_avatar('林凡', 32));

/*
 |--------------------------------------------------------------------------
 | 主题激活后跳转到插件安装页面
 |--------------------------------------------------------------------------
*/
if (is_admin() && $_GET['activated'] == 'true') {
    header('Location: plugins.php?page=tgmpa-install-plugins');
}