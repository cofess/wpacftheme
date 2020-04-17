<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 标签文本                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-labelText_section',
  'title'  => __('标签文本','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-text-height',
  'fields' => array(

    array(
      'id'      => 'admin_label_text',
      'type'    => 'text',
      'title'   => __('管理员的称号','CS_TEXTDOMAIN'),
      'default' => __('官方','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'post_readMoreLabel',
      'type'    => 'text',
      'title'   => __('阅读更多的标签文字','CS_TEXTDOMAIN'),
      'default' => __('阅读更多','CS_TEXTDOMAIN'),
    ),

    array(
      'id'         => 'postRelated_label',
      'type'       => 'text',
      'title'      => __('相关文章标签文字','CS_TEXTDOMAIN'),
      'default'    => __('相关文章','CS_TEXTDOMAIN'),
    ),

    array(
      'id'         => 'post_previousLabel',
      'type'       => 'text',
      'title'      => __('上一篇标签文字','CS_TEXTDOMAIN'),
      'default'    => __('上一篇','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'         => 'post_nextLabel',
      'type'       => 'text',
      'title'      => __('下一篇标签文字','CS_TEXTDOMAIN'),
      'default'    => __('下一篇','CS_TEXTDOMAIN'),
    ),

    array(
      'id'         => 'ajax_moreLabel',
      'type'       => 'text',
      'title'      => __('ajax无限加载中下一页的标签文字','CS_TEXTDOMAIN'),
      'default'    => __('加载更多','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'         => 'ajax_nomoreLabel',
      'type'       => 'text',
      'title'      => __('ajax无限加载完结的标签文字','CS_TEXTDOMAIN'),
      'default'    => __('没有更多文章了','CS_TEXTDOMAIN'),
    ),
  )
);