<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// vendor                  
// ------------------------------
$options[]   = array(
  'name'   => 'system-vendor_section',
  'title'  => __('第三方插件','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-wordpress',
  'fields' => array(
    array(
      'type'    => 'subheading',
      'content' => __('Contact Form 7','CS_TEXTDOMAIN'),
    ),

    array(
      'id'       => 'disable-cf7-email',
      'type'     => 'switcher',
      'title'    => __('关闭邮件通知','CS_TEXTDOMAIN'),
      'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('禁用后前端表单提交数据将不再发送邮件通知，同时设置的自动回复功能将失效','CS_TEXTDOMAIN').'</span>',
      'default'  => false,
      'settings' => array(
        'on_text'  => __('是','CS_TEXTDOMAIN'),
        'off_text' => __('否','CS_TEXTDOMAIN'),
      ),
    ),

    array(
      'type'    => 'subheading',
      'content' => __('Woocommerce','CS_TEXTDOMAIN'),
    ), 
    array(
      'id'      => 'disable-woocommerce-scripts',
      'type'    => 'switcher',
      'title'   => __('Disable Scripts','CS_TEXTDOMAIN'),
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('Disables WooCommerce scripts and styles except on product, cart, and checkout pages.','CS_TEXTDOMAIN').'</span>',
      'default' => false,
    ), 
    array(
      'id'      => 'disable-woocommerce-cart-fragmentation',
      'type'    => 'switcher',
      'title'   => __('Disable Cart Fragmentation','CS_TEXTDOMAIN'),
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('Completely disables WooCommerce cart fragmentation script.','CS_TEXTDOMAIN').'</span>',
      'default' => false,
    ),
    array(
      'id'      => 'disable-woocommerce-widgets',
      'type'    => 'switcher',
      'title'   => __('Disable Widgets','CS_TEXTDOMAIN'),
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('Disables all WooCommerce widgets.','CS_TEXTDOMAIN').'</span>',
      'default' => false,
    ), 
    array(
      'id'      => 'disable-woocommerce-reviews',
      'type'    => 'switcher',
      'title'   => __('Disable Reviews','CS_TEXTDOMAIN'),
      'default' => false,
    ),
    array(
      'id'      => 'disable-woocommerce-menu',
      'type'    => 'switcher',
      'title'   => __('Disable WooCommerce Menu','CS_TEXTDOMAIN'),
      'default' => false,
    ),

    array(
      'type'    => 'subheading',
      'content' => __('Jetpack','CS_TEXTDOMAIN'),
    ),
    array(
      'id'      => 'remove-jetpack-devicepx',
      'type'    => 'switcher',
      'title'   => __('移除devicepx-jetpack.js','CS_TEXTDOMAIN'),
      'default' => false,
    ), 
    array(
      'id'      => 'remove-jetpack-css',
      'type'    => 'switcher',
      'title'   => __('移除Jetpack css','CS_TEXTDOMAIN'),
      'default' => false,
    ),
  )
);