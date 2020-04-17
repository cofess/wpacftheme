<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
$login_private_key = cs_get_option( 'login-private-Key','','_system_options' );
$login_private_Url = site_url().'/wp-login.php?q='.$login_private_key;//加密后台登录地址
$current_login_url = (cs_get_option( 'login-encryption','','_system_options' )==true && $login_private_key)? $login_private_Url : site_url().'/wp-login.php';//当前后台登录地址
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title'      => __('系统设置','CS_TEXTDOMAIN'),
    'menu_type'       => 'submenu', // menu, submenu, options, theme, etc.
    'menu_parent'     => 'options-general.php',
    'menu_slug'       => 'system-options',
	'ajax_save'       => false,
	'show_reset_all'  => false,
	'framework_title' => __('系统设置','CS_TEXTDOMAIN'),
	'option_array'    => '_system_options', //this most unique variable **required** from now on. Leave to use default CS_OPTION but not recommended. BETTER to use your plugin name or theme name. <<SHOULD BE UNIQUE>>. This is the variable that gets used as the option name. So get_option('<<option_array>>') | update_option('<<option_array>>')
);

$options        = array();

require dirname( __FILE__ ) . '/_system/general.option.php';
require dirname( __FILE__ ) . '/_system/clean.option.php';
require dirname( __FILE__ ) . '/_system/wpCustomize.option.php';
require dirname( __FILE__ ) . '/_system/entrance.option.php';
require dirname( __FILE__ ) . '/_system/safe.option.php';
require dirname( __FILE__ ) . '/_system/extend.option.php';
// require dirname( __FILE__ ) . '/_system/smtp.option.php';
require dirname( __FILE__ ) . '/_system/adblock.option.php';
require dirname( __FILE__ ) . '/_system/vendor.option.php';
require dirname( __FILE__ ) . '/_system/login.option.php';
require dirname( __FILE__ ) . '/_system/maintenance.option.php';

// ------------------------------
// backup                       
// ------------------------------
$options[]   = array(
    'name'     => 'system-backup_section',
    'title'    => __('备份设置','CS_TEXTDOMAIN'),
    'icon'     => 'fa fa-database',
    'fields'   => array(

        array(
        'type'    => 'notice',
        'class'   => 'warning',
        'content' => __('网站迁移前请务必备份当前设置，迁移后导入即可','CS_TEXTDOMAIN'),
        ),

        array(
        'type'    => 'backup',
        ),

    )
);

CSFramework::instance( $settings, $options );

if ( cs_get_option( 'disable-gravatar','','_system_options' ) ) {
    update_option( 'show_avatars', false );
} else {
    update_option( 'show_avatars', true );
}
