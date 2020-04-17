<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 基本设置                      
// ------------------------------
$options[]   = array(
  'name'   => 'theme-basic_section',
  'title'  => __('基本设置','CS_TEXTDOMAIN'),
  'icon'   => 'fa fa-cog',
  'fields' => array(
  
    array(
      'type'    => 'subheading',
      'content' => __('基本信息','CS_TEXTDOMAIN'),
    ),
    
    array(
      'id'         => 'blogName',
      'type'       => 'text',
      'title'      => __('网站名称','CS_TEXTDOMAIN'),
      'attributes' => array(
        //'readonly' => 'only-key'
      ),
      'default'  => get_bloginfo('name'),
      'validate' => 'required',
    ),
    
    array(
      'id'         => 'blogDescription',
      'type'       => 'text',
      'title'      => __('副标题','CS_TEXTDOMAIN'),
      'attributes' => array(
        //'readonly' => 'only-key'
      ),
      'default'  => get_bloginfo('description'),
      'validate' => 'required',
    ),
    
    array(
      'id'      => 'icp',
      'type'    => 'text',
      'title'   => __('备案号','CS_TEXTDOMAIN'),
      'default'  => get_option('zh_cn_l10n_icp_num'),
    ), 
    
    array(
      'id'         => 'footer_copyright',
      'type'       => 'textarea',
      'title'      => __('页脚版权信息','CS_TEXTDOMAIN'),
      'attributes' => array(
        'placeholder' => 'All Rights Reserved.',
      ),
    ),

    array(
      'type'    => 'subheading',
      'content' => __('网站图标','CS_TEXTDOMAIN'),
    ),

    array(
      'id'       => 'custom_favicon',
      'type'     => 'upload',
      'title'    => __('Favicon图标','CS_TEXTDOMAIN'),
      'default'  => get_template_directory_uri()."/static/admin/favicon/favicon.ico",
      'settings' => array(
        'upload_type'  => 'image',
        'button_title' => __('上传','CS_TEXTDOMAIN'),
        'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
        'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
      ), 
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('上传favicon.ico，并通过FTP上传到网站根目录','CS_TEXTDOMAIN').'</span>',     
    ),

    array(
      'id'       => 'custom_apple_icon',
      'type'     => 'upload',
      'title'    => __('IOS屏幕图标','CS_TEXTDOMAIN'),
      'default'  => get_template_directory_uri()."/static/admin/favicon/favicon.png",
      'settings' => array(
        'upload_type'  => 'image',
        'button_title' => __('上传','CS_TEXTDOMAIN'),
        'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
        'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
      ), 
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('苹果移动设备添加到主屏幕图标','CS_TEXTDOMAIN').'</span>',    
    ),
    
    array(
      'id'      => 'custom_logoStyle',
      'type'    => 'radio',
      'title'   => __('网站标志','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '1' => __('显示LOGO','CS_TEXTDOMAIN'),
        '2' => __('显示网站标题','CS_TEXTDOMAIN'),
        '3' => __('显示字体图标','CS_TEXTDOMAIN'),
      ),
      'default' => '1',
    ),      

    array(
      'id'         => 'custom_logo',
      'type'       => 'upload',
      'title'      => __('网站LOGO','CS_TEXTDOMAIN'),
      'dependency' => array( 'custom_logoStyle_1', '==', 'true' ),
      'default'    => get_template_directory_uri()."/static/front/images/logo.png",
      'settings' => array(
        'upload_type'  => 'image',
        'button_title' => __('上传','CS_TEXTDOMAIN'),
        'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
        'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
      ),        
    ),
    
    // array(
    //   'id'         => 'enable_logoTextAnimate',
    //   'type'       => 'switcher',
    //   'title'      => __('网站标题动画','CS_TEXTDOMAIN'),
    //   'dependency' => array( 'custom_logoStyle_2', '==', 'true' ),
    //   'default'    => false,
    // ),      

    array(
      'id'           => 'custom_logoIcon',
      'type'         => 'icon',
      'title'        => __('字体图标','CS_TEXTDOMAIN'),
      'button_title' => __('添加图标','CS_TEXTDOMAIN'),
      'dependency'   => array( 'custom_logoStyle_3', '==', 'true' ),
      'attributes'   => array(
        'button_title' => __('添加图标','CS_TEXTDOMAIN'),
      )
    ),

    array(
      'id'         => 'enable_logo_animate',
      'type'       => 'switcher',
      'title'      => __('扫光动画','CS_TEXTDOMAIN'),
      'default'    => false,
    ),
  
    array(
      'type'    => 'subheading',
      'content' => __('常规设置','CS_TEXTDOMAIN'),
    ), 
        
    array(
      'id'      => 'enable_tags_postNum',
      'type'    => 'switcher',
      'title'   => __('标签tag显示包含文章数量','CS_TEXTDOMAIN'),
      'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('在标签后显示当前标签下的文章数','CS_TEXTDOMAIN').'</span>',
      'default' => true,
    ),

    array(
      'id'      => 'date-format',
      'type'    => 'radio',
      'title'   => __('时间显示格式','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '0' => __('默认格式','CS_TEXTDOMAIN'),
        '1' => __('“多久前”格式','CS_TEXTDOMAIN'),
      ),
      'default' => '0',
    ),

    array(
      'id'      => 'secure-iframe',
      'type'    => 'radio',
      'title'   => __('其他网站通过iframe框架引用本站','CS_TEXTDOMAIN'),
      'help'    => __('防止站点被其他站点通过iframe框架恶意引用','CS_TEXTDOMAIN'),
      'class'   => 'horizontal',
      'options' => array(
        '1' => __('禁止所有网站引用本站','CS_TEXTDOMAIN'),
        '2' => __('仅同源网站可引用本站','CS_TEXTDOMAIN'),
        '3' => __('仅指定网站可引用本站','CS_TEXTDOMAIN'),
      ),
      'default'  => '1',
    ),

    array(
      'id'         => 'iframe-except-domain',
      'type'       => 'textarea',
      'title'      => __('以下网站除外','CS_TEXTDOMAIN'),
      'desc'       => __('每行一个网站，回车换行','CS_TEXTDOMAIN'),
      'dependency' => array( 'secure-iframe_3', '==', true ),
    ), 

    array(
      'id'       => 'disable-context-menu',
      'type'     => 'switcher',
      'title'    => __('禁用鼠标右键','CS_TEXTDOMAIN'),
      'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('禁用鼠标右键访客将无法复制网站内容','CS_TEXTDOMAIN').'</span>',
      'default'  => false,
      'settings' => array(
        'on_text'  => __('是','CS_TEXTDOMAIN'),
        'off_text' => __('否','CS_TEXTDOMAIN'),
      ),
    ),

    array(
      'id'       => 'email-address-encode',
      'type'     => 'switcher',
      'title'    => __('转义文章和评论中的邮箱地址','CS_TEXTDOMAIN'),
      'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('有效屏蔽邮箱地址采集器以防被恶意采集','CS_TEXTDOMAIN').'</span>',
      'default'  => true,
      'settings' => array(
        'on_text'  => __('是','CS_TEXTDOMAIN'),
        'off_text' => __('否','CS_TEXTDOMAIN'),
      ),
    ),

  ), // end: fields
);