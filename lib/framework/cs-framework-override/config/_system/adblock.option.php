<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// adblock section              
// ------------------------------
$options[]   = array(
  'name'   => 'system-adblock_section',
  'title'  => __('Adblock Detect','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-adn',
  'fields' => array(

    array(
      'id'       => 'adblock-detect',
      'type'     => 'switcher',
      'title'    => __('启用广告屏蔽插件检测','CS_TEXTDOMAIN'),
      'default'  => false,
      'settings' => array(
        'on_text'  => __('是','CS_TEXTDOMAIN'),
        'off_text' => __('否','CS_TEXTDOMAIN'),
      ),
    ),

    array(
      'id'      => 'adbd-type',
      'type'    => 'select',
      'title'   => __('Popup Types','CS_TEXTDOMAIN'),
      'options' => array(
        'warning'  => __('Warning','CS_TEXTDOMAIN'),
        'info'     => __('Info','CS_TEXTDOMAIN'),
        'error'    => __('Error','CS_TEXTDOMAIN'),
        'question' => __('Question','CS_TEXTDOMAIN'),
      ),
      'default'        => 'warning',
    ),

    array(
      'type'    => 'subheading',
      'content' => __('提示信息','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'adbd-title',
      'type'    => 'text',
      'title'   => __('标题','CS_TEXTDOMAIN'),
      'default' => __('Adblock Detect','CS_TEXTDOMAIN'),
    ),

    array(
      'id'         => 'adbd-text',
      'type'       => 'textarea',
      'title'      => __('内容','CS_TEXTDOMAIN'),
      'default'    => __('Please support this website by disabling your AdBlocker','CS_TEXTDOMAIN'),
      'attributes' => array(
        'placeholder' => __('Please support this website by disabling your AdBlocker','CS_TEXTDOMAIN')
      ),
    ),

    array(
      'id'      => 'adbd-button-text',
      'type'    => 'text',
      'title'   => __('按钮文本','CS_TEXTDOMAIN'),
      'default' => __('I understand, I have disabled my ad blocker.  Let me in!','CS_TEXTDOMAIN'),
    ),

    array(
      'id'         => 'adbd-button-color',
      'type'       => 'color_picker',
      'title'      => __('按钮颜色','CS_TEXTDOMAIN'),
      'rgba'       => false,
      'default'    => '#f1f1f1',
    ),

  )
);