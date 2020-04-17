<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$settings           = array(
  'menu_title'      => __('网站设置','CS_TEXTDOMAIN'),
  'menu_type'       => 'submenu',               // menu, submenu, options, theme, etc.
  'menu_parent'     => 'options-general.php',
  'menu_slug'       => 'theme-options',
  'menu_icon'       => 'dashicons-art',
  'ajax_save'       => false,
  'show_reset_all'  => false,
  'framework_title' => __('网站设置','CS_TEXTDOMAIN'),
  'option_array'    => '_theme_options',
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();

require dirname( __FILE__ ) . '/_frameork/base.option.php';
require dirname( __FILE__ ) . '/_frameork/appearance.option.php';
// require dirname( __FILE__ ) . '/_frameork/customer.option.php';
require dirname( __FILE__ ) . '/_frameork/seo.option.php';
require dirname( __FILE__ ) . '/_frameork/list.option.php';
require dirname( __FILE__ ) . '/_frameork/post.option.php';
require dirname( __FILE__ ) . '/_frameork/search.option.php';
require dirname( __FILE__ ) . '/_frameork/comment.option.php';
require dirname( __FILE__ ) . '/_frameork/share.option.php';
require dirname( __FILE__ ) . '/_frameork/extend.option.php';
require dirname( __FILE__ ) . '/_frameork/code.option.php';
require dirname( __FILE__ ) . '/_frameork/analytics.option.php';
require dirname( __FILE__ ) . '/_frameork/labelText.option.php';

// ------------------------------
// backup                       
// ------------------------------
$options[]   = array(
  'name'   => 'theme-backup_section',
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

CSFramework:: instance( $settings, $options );

if(cs_get_option( 'blogName','','_theme_options' )!=""){
	update_option('blogname', cs_get_option( 'blogName','','_theme_options' ));//更新网站名称
}
if(cs_get_option( 'blogDescription','','_theme_options' )!=""){
	update_option('blogdescription', cs_get_option( 'blogDescription' ));//更新网站副标题
}
if(cs_get_option( 'icp','','_theme_options' )!=""){
	update_option('zh_cn_l10n_icp_num', cs_get_option( 'icp','','_theme_options' ));//更新ICP备案号
}
