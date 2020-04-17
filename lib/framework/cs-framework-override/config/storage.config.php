<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings = array(
	'menu_title'      => __('CDN加速','CS_TEXTDOMAIN'),
	'menu_type'       => 'submenu',                   // menu, submenu, options, theme, etc.
	'menu_parent'     => 'options-general.php',
	'menu_slug'       => 'storage-options',
	'ajax_save'       => false,
	'show_reset_all'  => false,
	'framework_title' => __('CDN加速','CS_TEXTDOMAIN'),
	'option_array'    => '_storage_options',          //this most unique variable **required** from now on. Leave to use default CS_OPTION but not recommended. BETTER to use your plugin name or theme name. <<SHOULD BE UNIQUE>>. This is the variable that gets used as the option name. So get_option('<<option_array>>') | update_option('<<option_array>>')
);

$options        = array();

require dirname( __FILE__ ) . '/_storage/cdn.option.php';
require dirname( __FILE__ ) . '/_storage/local.option.php';
require dirname( __FILE__ ) . '/_storage/remote.option.php';
require dirname( __FILE__ ) . '/_storage/qiniu.option.php';
require dirname( __FILE__ ) . '/_storage/thumbnail.option.php';

// ------------------------------
// backup                       
// ------------------------------
$options[]   = array(
    'name'   => 'storage-backup_section',
    'title'  => __('备份设置','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-database',
    'fields' => array(

        array(
            'type'    => 'notice',
            'class'   => 'warning',
            'content' => __('网站迁移前请务必备份当前设置，迁移后导入即可','CS_TEXTDOMAIN'),
        ),

        array(
            'type' => 'backup',
        ),

  )
);

CSFramework::instance( $settings, $options );