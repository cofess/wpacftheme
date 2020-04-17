<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 自定义代码                   
// ------------------------------
$options[]   = array(
  'name'  => 'theme-code_section',
  'title' => __('自定义代码','CS_TEXTDOMAIN'),
  'icon'  => 'fa fa-code',

  // begin: fields
  'fields'    => array(
      
    array(
      'id'       => 'custom-meta',
      'type'     => 'textarea',
      'before'   => '<h4>'.__('META标签','CS_TEXTDOMAIN').'</h4>',
      'after'    => '<span class="cs-text-muted">'.__('说明：可以用于各种Meta验证，或者自定义的meta信息。每行一个，回车换行','CS_TEXTDOMAIN').'</span>',
      'sanitize' => false,
      'attributes' => array(
        'style'       => 'min-height: 80px',
      ) 
    ),
    
    array(
      'id'         => 'dns-prefetch',
      'type'       => 'textarea',
      'before'     => '<h4>'.__('DNS Prefetch','CS_TEXTDOMAIN').'</h4>',
      'after'      => '<span class="cs-text-muted">'.__('说明：DNS Prefetch是一种DNS预解析技术，浏览器通过DNS Prefetch来提高访问的流畅性，减少用户等待时间，提高用户体验。每行一个域名，回车换行','CS_TEXTDOMAIN').'</span>',
      'sanitize'   => false,
      'attributes' => array(
        'placeholder' => __('请输入需要预解析的外部域名，每行一个，回车换行','CS_TEXTDOMAIN'),
      )      
    ),
      
    array(
      'id'       => 'head-code',
      'type'     => 'textarea',
      'before'   => '<h4>'.__('网站头部添加额外代码','CS_TEXTDOMAIN').'</h4>',
      'after'    => '<span class="cs-text-muted">'.__('说明：代码将添加到&lt;head&gt;标签中，您可以添加一些额外的CSS或JS','CS_TEXTDOMAIN').'</span>',
      'sanitize' => false,
    ),
    
    array(
      'id'       => 'footer-code',
      'type'     => 'textarea',
      'before'   => '<h4>'.__('网站页脚添加额外代码','CS_TEXTDOMAIN').'</h4>',
      'after'    => '<span class="cs-text-muted">'.__('说明：代码将添加到&lt;footer&gt;标签中，可以添加第三方代码（一般用于放置百度商桥代码、站长统计代码、谷歌翻译代码等）','CS_TEXTDOMAIN').'</span>',
      'sanitize' => false,
    ),

  ), // end: fields
);