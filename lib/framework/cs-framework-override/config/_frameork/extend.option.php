<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 拓展功能                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-extend_section',
  'title'  => __('拓展功能','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-plug',
  'fields' => array(

    array(
      'type'    => 'subheading',
      'content' => __('悬浮菜单','CS_TEXTDOMAIN'),
    ),

    array(
      'id'      => 'enable_gotoTop',
      'type'    => 'switcher',
      'title'   => __('回到页面顶部按钮','CS_TEXTDOMAIN'),
      'default' => true,
    ),

    array(
      'id'      => 'enable_float_menu',
      'type'    => 'switcher',
      'title'   => __('开启悬浮菜单','CS_TEXTDOMAIN'),
      'default' => false,
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('只显示QQ号码和电话号码','CS_TEXTDOMAIN').'</span>',
    ),

    array(
      'id'      => 'float_menu',
      'type'    => 'checkbox',
      'title'   => __('悬浮菜单','CS_TEXTDOMAIN'),
      'desc'    => __('选择您希望在悬浮菜单中显示的内容','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'search'      => __('搜索功能','CS_TEXTDOMAIN'),
        'wechat'      => __('微信二维码','CS_TEXTDOMAIN'),
        'qq'          => __('QQ','CS_TEXTDOMAIN'),
        'weibo'       => __('微博','CS_TEXTDOMAIN'),
        'tel'         => __('电话','CS_TEXTDOMAIN'),
        'email'       => __('邮箱','CS_TEXTDOMAIN'),
      ),
      'default'    => array( 'facebook', 'twitter', 'google-plus', 'weibo', 'wechat' )
    ),

    array(
      'type'    => 'subheading',
      'content' => __('社交分享','CS_TEXTDOMAIN'),
    ),
    
    array(
      'id'      => 'share',
      'type'    => 'checkbox',
      'title'   => __('PC端分享方式','CS_TEXTDOMAIN'),
      'desc'    => __('选择您希望在PC端显示的分享方式','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'facebook'    => __('Facebook','CS_TEXTDOMAIN'),
        'twitter'     => __('Twitter','CS_TEXTDOMAIN'),
        'google-plus' => __('Google Plus','CS_TEXTDOMAIN'),
        'linkedin'    => __('LinkedIn','CS_TEXTDOMAIN'),
        'weibo'       => __('新浪微博','CS_TEXTDOMAIN'),
        'tencent'     => __('腾讯微博','CS_TEXTDOMAIN'),
        'qzone'       => __('QQ空间','CS_TEXTDOMAIN'),
        'qq'          => __('QQ','CS_TEXTDOMAIN'),
        'wechat'      => __('微信','CS_TEXTDOMAIN'),
        'douban'      => __('豆瓣','CS_TEXTDOMAIN'),
        'diandian'    => __('点点网','CS_TEXTDOMAIN'),
      ),
      'default'    => array( 'facebook', 'twitter', 'google-plus', 'weibo', 'wechat' )
    ),

    array(
      'id'      => 'm_share',
      'type'    => 'checkbox',
      'title'   => __('移动端分享方式','CS_TEXTDOMAIN'),
      'desc'    => __('选择您希望在移动端显示的分享方式','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'facebook'    => __('Facebook','CS_TEXTDOMAIN'),
        'twitter'     => __('Twitter','CS_TEXTDOMAIN'),
        'google-plus' => __('Google Plus','CS_TEXTDOMAIN'),
        'linkedin'    => __('LinkedIn','CS_TEXTDOMAIN'),
        'weibo'       => __('新浪微博','CS_TEXTDOMAIN'),
        'tencent'     => __('腾讯微博','CS_TEXTDOMAIN'),
        'qzone'       => __('QQ空间','CS_TEXTDOMAIN'),
        'qq'          => __('QQ','CS_TEXTDOMAIN'),
        'wechat'      => __('微信','CS_TEXTDOMAIN'),
        'douban'      => __('豆瓣','CS_TEXTDOMAIN'),
        'diandian'    => __('点点网','CS_TEXTDOMAIN'),
      ),
      'default' => array( 'facebook', 'twitter', 'google-plus', 'weibo', 'wechat' )
    ),

    array(
      'type'    => 'subheading',
      'content' => __('谷歌翻译','CS_TEXTDOMAIN'),
    ),

    array(
      'id'       => 'enable_translate',
      'type'     => 'switcher',
      'title'    => __('启用谷歌翻译','CS_TEXTDOMAIN'),
      'default'  => false,
      'settings' => array(
        'on_text'  => __('是','CS_TEXTDOMAIN'),
        'off_text' => __('否','CS_TEXTDOMAIN'),
      ),
    ),

    array(
      'id'      => 'site_lang',
      'type'    => 'radio',
      'title'   => __('网站语言','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'zh' => __('中文','CS_TEXTDOMAIN'),
        'en' => __('English','CS_TEXTDOMAIN'),
      ),
      'default' => 'zh',
    ),

    array(
      'id'      => 'lang_codes',
      'type'    => 'checkbox',
      'title'   => __('翻译语种','CS_TEXTDOMAIN'),
      'desc'    => __('选择网站需要翻译的语种','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        'zh-CN' => __('汉语','CS_TEXTDOMAIN'),
        'en'    => __('英语','CS_TEXTDOMAIN'),
        'de'    => __('德语','CS_TEXTDOMAIN'),
        'es'    => __('西班牙语','CS_TEXTDOMAIN'),
        'fr'    => __('法语','CS_TEXTDOMAIN'),
        'it'    => __('意大利语','CS_TEXTDOMAIN'),
        'ja'    => __('日语','CS_TEXTDOMAIN'),
        'ko'    => __('韩语','CS_TEXTDOMAIN'),
        'pt'    => __('葡萄牙语','CS_TEXTDOMAIN'),
        'ru'    => __('俄罗斯语','CS_TEXTDOMAIN'),
      ),
      'default'    => array( 'en', 'de', 'es', 'fr', 'ru' )
    ),

  )
);