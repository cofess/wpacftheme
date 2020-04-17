<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 分享设置                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-share_section',
  'title'  => __('分享设置','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-share-alt',
  'fields' => array(

    array(
      'type'    => 'subheading',
      'content' => __('微信、QQ内分享自定义设置','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'share_title', 
      'type'    => 'text',
      'title'   => __('标题','CS_TEXTDOMAIN'),
      'default' => get_bloginfo('name'),
    ),

    array(
      'id'      => 'share_summary', 
      'type'    => 'text',
      'title'   => __('描述','CS_TEXTDOMAIN'),
      'default' => get_bloginfo('description'),
    ),

    array(
      'id'    => 'share_img',
      'type'  => 'image',
      'title' => __('图片','CS_TEXTDOMAIN'),
    ),

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => __('如果你想要在微信中直接分享，请按以下步骤操作：<br> 1、公众号通过微信认证 <br>2、添加域名 '.get_bloginfo('url').' 到 JS安全域名中 <br>3、添加服务器IP 到 IP白名单中 <br>4、填写 AppID 和 AppSecret <br>否则你只能通过QQ分享链接到微信，或者直接在QQ中分享','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'share_appid', 
      'type'    => 'text',
      'title'   => __('AppId','CS_TEXTDOMAIN'),
      'default' => '',
    ),

    array(
      'id'      => 'share_appsecret', 
      'type'    => 'text',
      'title'   => __('AppSecret','CS_TEXTDOMAIN'),
      'default' => '',
    ),

    array(
      'type'    => 'subheading',
      'content' => __('分享 - bigger封面','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'share_bigger_img',
      'type'    => 'switcher',
      'title'   => __('分享bigger封面','CS_TEXTDOMAIN'),
      'help'    => __('开启后将根据文章内容生成bigger封面图，并随用户的分享动作分享至第三方网站','CS_TEXTDOMAIN'),
      'default' => true
    ),

    // array(
    //   'id'        => 'bigger_logo',
    //   'type'      => 'image',
    //   'title'     => 'LOGO',
    //   'help'      => __('上传一张显示在bigger封面底部的LOGO','CS_TEXTDOMAIN'),
    //   'add_title' => __('选择LOGO','CS_TEXTDOMAIN'),
    //   'dependency' => array(
    //     'share_bigger_img',
    //     '==',
    //     'true'
    //   ),
    // ),

    // array(
    //   'id'        => 'bigger_desc',
    //   'type'      => 'text',
    //   'title'     => __('描述','CS_TEXTDOMAIN'),
    //   'help'      => __('显示在LOGO下方的一句话描述','CS_TEXTDOMAIN'),
    //   'dependency' => array(
    //     'share_bigger_img',
    //     '==',
    //     'true'
    //   ),
    // ),

    array(
      'id'      => 'share_bigger_img_qrcode',
      'type'    => 'switcher',
      'title'   => __('右下角二维码','CS_TEXTDOMAIN'),
      'help'    => __('开启后将再bigger封面图的右下角现在当前文章的二维码','CS_TEXTDOMAIN'),
      'default' => false,
      'dependency' => array(
        'share_bigger_img',
        '==',
        'true'
      ),
    ),

    array(
      'id'      => 'thumbnail_handle',
      'type'    => 'select',
      'title'   => __('处理方式','CS_TEXTDOMAIN'),
      'options' => array(
        'timthumb' => __('timthumb.php','CS_TEXTDOMAIN'),
        'wpthumb'  => __('内置裁切','CS_TEXTDOMAIN'),
        'original' => __('输出原图','CS_TEXTDOMAIN'),
      ),
      'default'        => '1',
      'default_option' => __('请选择','CS_TEXTDOMAIN'),
    ),

  )
);