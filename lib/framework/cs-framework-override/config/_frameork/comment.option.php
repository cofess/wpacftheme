<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 评论设置                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-comment_section',
  'title'  => __('评论','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-comments',
  'fields' => array( 
  
    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => __('温馨提示：网站启用第三方评论以下设置有可能会失效！','CS_TEXTDOMAIN'),
    ),  
  
    array(
      'id'    => 'enable_comment_autoSave',
      'type'  => 'switcher',
      'title' => __('评论自动保存','CS_TEXTDOMAIN'),
    ),  
    
    array(
      'id'    => 'enable_comment_no_html',
      'type'  => 'switcher',
      'title' => __('评论中禁止含有链接的评论（防垃圾评论机制）','CS_TEXTDOMAIN'),
    ),

    array(
      'id'    => 'enable_comment_no_english',
      'type'  => 'switcher',
      'title' => __('评论中禁止全英文评论（防垃圾评论机制）','CS_TEXTDOMAIN'),
    ), 
  
    array(
      'id'    => 'enable_loginToComment',
      'type'  => 'switcher',
      'title' => __('用户必须注册并登录才可以发表评论','CS_TEXTDOMAIN'),
    ), 
  
    array(
      'id'      => 'enable_loginToComment',
      'type'    => 'switcher',
      'title'   => __('评论者必须填写姓名和电子邮件','CS_TEXTDOMAIN'),
      'default' => '1',
    ),
  
    array(
      'id'    => 'enable_comment_url',
      'type'  => 'switcher',
      'title' => __('评论网址URL表单','CS_TEXTDOMAIN'),
    ), 
  
    array(
      'id'    => 'enable_comments_author_link',
      'type'  => 'switcher',
      'title' => __('评论人名字的链接','CS_TEXTDOMAIN'),
      'after' => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('此方法只对使用 WordPress 默认评论表单的主题才有效','CS_TEXTDOMAIN').'</span>',
    ),      
  
    array(
      'id'    => 'comment-email-notice',
      'type'  => 'switcher',
      'title' => __('评论邮箱提醒功能','CS_TEXTDOMAIN'),
      'after' => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('需要主机空间支持mail()函数，或者通过安装WP-Mail-SMTP插件实现','CS_TEXTDOMAIN').'</span>',
    ), 
  
    array(
      'id'      => 'enable_avatarLazyload',
      'type'    => 'switcher',
      'title'   => __('头像Lazyload功能','CS_TEXTDOMAIN'),
      'default' => true,
    ),  
  
    array(
      'id'      => 'enable_commentAjax',
      'type'    => 'switcher',
      'title'   => __('AJAX无刷新评论','CS_TEXTDOMAIN'),
      'default' => true,
    ),
  
    array(
      'id'      => 'enable_commentEmoji',
      'type'    => 'switcher',
      'title'   => __('启用表情','CS_TEXTDOMAIN'),
      'default' => false,
    ),    
  
    array(
      'id'      => 'enable_commentFilter',
      'type'    => 'switcher',
      'title'   => __('过滤垃圾评论','CS_TEXTDOMAIN'),
      'default' => true,
    ),
  
    array(
      'id'      => 'enable_commentMinLimit',
      'type'    => 'switcher',
      'title'   => __('限制评论内容最小字数','CS_TEXTDOMAIN'),
      'default' => false,
    ),  
  
    array(
      'id'      => 'commentMinLimit',
      'type'    => 'number',
      'title'   => __('评论内容最小字数','CS_TEXTDOMAIN'),
      'default' => '10',
      //'validate' => 'numeric',
      'dependency' => array( 'enable_commentMinLimit', '==', 'true' ),
      'after'      => '<span class="cs-text-muted">'.__('(字符)','CS_TEXTDOMAIN').'</span>',
    )
  )
);