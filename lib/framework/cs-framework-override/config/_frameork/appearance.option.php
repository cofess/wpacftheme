<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 主题设置                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-appearance_section',
  'title'  => __('主题设置','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-fort-awesome',
  'fields' => array(

    array(
      'type'    => 'subheading',
      'content' => __('主题设置','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'site-grayscale',
      'type'    => 'radio',
      'title'   => __('网站变灰','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      // 'label'   => __('使网站变灰，支持IE、Chrome，基本上覆盖了大部分用户，不会降低访问速度','CS_TEXTDOMAIN'),
      'options' => array(
        '0' => __('禁用','CS_TEXTDOMAIN'),
        '1' => __('全站','CS_TEXTDOMAIN'),
        '2' => __('仅首页','CS_TEXTDOMAIN'),
      ),
      'default' => '0',
    ),
    
    array(
      'id'      => 'theme-switch',
      'type'    => 'image_select',
      'title'   => __('主题配色','CS_TEXTDOMAIN'),
      'options' => array(
        'default' => get_template_directory_uri()."/static/admin/images/palette/color-default.png",
        'black' => get_template_directory_uri()."/static/admin/images/palette/color-black.png",
        'blue' => get_template_directory_uri()."/static/admin/images/palette/color-blue.png",
        'brown' => get_template_directory_uri()."/static/admin/images/palette/color-brown.png",
        'green' => get_template_directory_uri()."/static/admin/images/palette/color-green.png",
        'lime' => get_template_directory_uri()."/static/admin/images/palette/color-lime.png",
        'magenta' => get_template_directory_uri()."/static/admin/images/palette/color-magenta.png",
        'orange' => get_template_directory_uri()."/static/admin/images/palette/color-orange.png",
        'pink' => get_template_directory_uri()."/static/admin/images/palette/color-pink.png",
        'purple' => get_template_directory_uri()."/static/admin/images/palette/color-purple.png",
        'red' => get_template_directory_uri()."/static/admin/images/palette/color-red.png",
        'teal' => get_template_directory_uri()."/static/admin/images/palette/color-teal.png",
        'custom' => get_template_directory_uri()."/static/admin/images/palette/color-custom.png",
      ),
      'radio'   => true,
      'default' => '1'
    ),    
      
    array(
      'id'      => 'enable_skinSwitch',
      'type'    => 'switcher',
      'title'   => __('前台换肤','CS_TEXTDOMAIN'),
      'default' => false,
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('此项禁用，前台换肤小工具失效；开启后，自定义主题将失效','CS_TEXTDOMAIN').'</span>',
    ),

    array(
      'type'    => 'subheading',
      'content' => __('特效设置','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'enable_page_preload',
      'type'    => 'switcher',
      'title'   => __('加载特效','CS_TEXTDOMAIN'),
      'default' => false,
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('开启后将在全站显示加载特效','CS_TEXTDOMAIN').'</span>',
    ),

    array(
      'type'    => 'subheading',
      'content' => __('其他设置','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'enable_friendlyLink',
      'type'    => 'switcher',
      'title'   => __('前台友情链接','CS_TEXTDOMAIN'),
      'default' => false,
      'after'   => '<span class="cs-text-warning" style="margin-left:5px;line-height:26px">'.__('前提是要先开启“友情链接”功能','CS_TEXTDOMAIN').'</span>',
    ), 

    array(
      'id'      => 'enable_breadcrumbs',
      'type'    => 'switcher',
      'title'   => __('面包屑导航','CS_TEXTDOMAIN'),
      'default' => false,
    ),

  )
);