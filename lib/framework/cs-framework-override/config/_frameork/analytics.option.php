<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 统计代码                   
// ------------------------------
$options[]   = array(
  'name'  => 'theme-analytics_section',
  'title' => __('统计代码','CS_TEXTDOMAIN'),
  'icon'  => 'fa fa-gg',
  'fields'    => array(

    array(
      'type'    => 'subheading',
      'content' => __('基本设置','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'tracking-method',
      'type'    => 'radio',
      'title'   => __('选择统计方式','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'baidu' => __('百度统计','CS_TEXTDOMAIN'),
        'ga'    => __('Google Analytics','CS_TEXTDOMAIN')
      ),
      'default' => 'baidu'
    ),

    array(
      'id'      => 'tracking-code-position',
      'type'    => 'select',
      'title'   => __('统计代码加载位置','CS_TEXTDOMAIN'),
      'options' => array(
        'header' => __('Header','CS_TEXTDOMAIN'),
        'footer' => __('Footer(default)','CS_TEXTDOMAIN'),
      ),
      'default'        => 'footer'
    ),

    array(
      'type'    => 'subheading',
      'content' => __('百度统计','CS_TEXTDOMAIN'),
    ),

    array(
      'id'    => 'baidu-tracking-id',
      'type'  => 'text',
      'title' => __('跟踪ID','CS_TEXTDOMAIN')
    ),

    array(
      'type'    => 'subheading',
      'content' => __('Google Analytics','CS_TEXTDOMAIN'),
    ),

    array(
      'id'    => 'ga-tracking-id',
      'type'  => 'text',
      'title' => __('跟踪ID','CS_TEXTDOMAIN')
    ),

    array(
      'id'       => 'enable-local-ga',
      'type'     => 'switcher',
      'title'    => __('统计代码缓存到本地','CS_TEXTDOMAIN'),
      'help'     => __('Google被墙，建议将统计代码缓存到本地,提升网页加载速度','CS_TEXTDOMAIN'),
      'default'  => true,
      'settings' => array(
        'on_text'  => __('是','CS_TEXTDOMAIN'),
        'off_text' => __('否','CS_TEXTDOMAIN'),
      ),
    ),

  ),
);