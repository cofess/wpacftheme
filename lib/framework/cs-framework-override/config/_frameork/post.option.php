<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 文章                       
// ------------------------------
$options[]   = array(
  'name'   => 'theme-post_section',
  'title'  => __('文章','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-newspaper-o',
  'fields' => array(  
  
    array(
      'type'    => 'subheading',
      'content' => __('文章常规设置','CS_TEXTDOMAIN'),
    ),
  
    array(
      'id'      => 'enable_post_views',
      'type'    => 'switcher',
      'title'   => __('浏览次数统计','CS_TEXTDOMAIN'),
      'default' => true,
    ),

    array(
      'id'      => 'enable_post_text_indent',
      'type'    => 'switcher',
      'title'   => __('文章页每段文字首行缩进2个字符','CS_TEXTDOMAIN'),
      'default' => true,
    ),

    array(
      'id'      => 'enable_post_fancybox',
      'type'    => 'switcher',
      'title'   => __('图片fancybox暗箱功能','CS_TEXTDOMAIN'),
      'default' => true,
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('打开后，文章中如带【有图片链接的图片】，点击都将弹窗显示','CS_TEXTDOMAIN').'</span>',
    ),
  
    array(
      'id'      => 'enable_post_like',
      'type'    => 'switcher',
      'title'   => __('访客点赞','CS_TEXTDOMAIN'),
      'default' => false,
    ),  
  
    array(
      'id'      => 'enable_post_copyright',
      'type'    => 'switcher',
      'title'   => __('转载声明','CS_TEXTDOMAIN'),
      'default' => true,
    ),
  
    array(
      'id'      => 'enable_post_authorInfo',
      'type'    => 'switcher',
      'title'   => __('作者信息','CS_TEXTDOMAIN'),
      'default' => false,
    ),  
  
    array(
      'id'      => 'enable_post_shareButton',
      'type'    => 'switcher',
      'title'   => __('分享按钮','CS_TEXTDOMAIN'),
      'default' => true,
    ),    
  
    array(
      'type'    => 'subheading',
      'content' => __('文章相关链接设置','CS_TEXTDOMAIN'),
    ), 
  
    array(
      'id'      => 'enable_post_pager',
      'type'    => 'switcher',
      'title'   => __('文章的上一篇和下一篇链接','CS_TEXTDOMAIN'),
      'default' => true,
    ),  
  
    array(
      'id'      => 'enable_postRelated',
      'type'    => 'switcher',
      'title'   => __('相关文章','CS_TEXTDOMAIN'),
      'default' => true,
    ),
    
    array(
      'id'         => 'postRelated_num',
      'type'       => 'number',
      'title'      => __('相关文章展示','CS_TEXTDOMAIN'),
      'after'      => '<span class="cs-text-muted">'.__('条','CS_TEXTDOMAIN').'</span>',
      'default'    => '8',
      'dependency' => array( 'enable_postRelated', '==', 'true' ),
      'attributes' => array(
        'style' => 'width: 50px;margin-right: 5px;'
      ), 
    ),  

    array(
      'id'      => 'postRelated_style',
      'type'    => 'radio',
      'title'   => __('相关文章展示方式','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '1' => __('无序列表','CS_TEXTDOMAIN'),
        '2' => __('图文列表','CS_TEXTDOMAIN'),
      ),
      'default'    => '1',
      'dependency' => array( 'enable_postRelated', '==', 'true' ),
    ),  

  )
);