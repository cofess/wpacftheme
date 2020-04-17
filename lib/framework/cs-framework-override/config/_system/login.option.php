<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// Login section               
// ------------------------------
$options[]   = array(
  'name'     => 'system-login_section',
  'title'    => __('后台登录','CS_TEXTDOMAIN'),
  'icon'     => 'fa fa-lock',
  'fields'   => array(

        array(
            'type'    => 'subheading',
            'content' => __('基本设置','CS_TEXTDOMAIN'),
        ),

        array(
            'id'       => 'login-with-username-or-email',
            'type'     => 'switcher',
            'title'    => __('后台支持用户名或邮箱登录','CS_TEXTDOMAIN'),
            'default'  => true,
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('允许使用用户名或邮箱登录，提高用户体验','CS_TEXTDOMAIN').'</span>',
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'type'    => 'subheading',
            'content' => __('自定义登录页面','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'login-page-template',
            'type'    => 'radio',
            'title'   => __('登录页面样式','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '0'    => __('默认样式','CS_TEXTDOMAIN'),
                '1'    => __('自定义样式1：左右布局','CS_TEXTDOMAIN'),
                '2'    => __('自定义样式2：上下布局','CS_TEXTDOMAIN'), 
                '3'    => __('自定义样式2：毛玻璃效果','CS_TEXTDOMAIN'), 
            ),
            'default'=> '1',
        ),

        array(
            'id'         => 'login-background-image',
            'type'       => 'upload',
            'title'      => __('登录页面背景图','CS_TEXTDOMAIN'),
            'default'    => WP_THEME_CONFIG_STATIC_URI . "/images/parallax1.jpg",
            'dependency' => array( 'login-page-template_0', '==', 'false' ),
            'settings'   => array(
                'upload_type'  => 'image',
                'button_title' => __('上传','CS_TEXTDOMAIN'),
                'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
                'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
            ), 
        ),

        array(
            'id'      => 'login-background-color',
            'type'    => 'color_picker',
            'title'   => __('登录页面背景色','CS_TEXTDOMAIN'),
            'rgba'    => false,
            'default' => '#f1f1f1',
            'dependency'   => array( 'login-page-template_0', '==', 'false' ),
        ),

        array(
            'id'      => 'login-logo',
            'type'    => 'radio',
            'title'   => __('登录页面的LOGO','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '0' => __('默认','CS_TEXTDOMAIN'),
                '1' => __('自定义','CS_TEXTDOMAIN'),
                '2' => __('隐藏','CS_TEXTDOMAIN'),
            ),
            'default'=> '2',
        ),

        array(
            'id'         => 'login-logo-image',
            'type'       => 'upload',
            'title'      => __('自定义LOGO','CS_TEXTDOMAIN'),
            'default'    => WP_THEME_CONFIG_STATIC_URI . "/images/login-logo.png",
            'dependency' => array( 'login-logo_1', '==', 'true' ),
            'settings'   => array(
                'upload_type'  => 'image',
                'button_title' => __('上传','CS_TEXTDOMAIN'),
                'frame_title'  => __('选择图像','CS_TEXTDOMAIN'),
                'insert_title' => __('使用图像','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'         => 'login-logo-link-url',
            'type'       => 'text',
            'title'      => __('自定义LOGO链接','CS_TEXTDOMAIN'),
            'default'    => get_bloginfo('url'),
            'attributes' => array( 
                'type' => 'url'
            )
        ),

        array(
            'id'      => 'login-logo-title',
            'type'    => 'radio',
            'title'   => __('登录页面LOGO标题（title）','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                '0'    => __('默认','CS_TEXTDOMAIN'),
                '1'    => __('自定义','CS_TEXTDOMAIN'),
            ),
            'default'=> '0',
        ),

        array(
            'id'     => 'login-logo-title-text',
            'type'   => 'text',
            'title'  => __('自定义LOGO标题','CS_TEXTDOMAIN'),
            'default'=> get_bloginfo('name'),
            'after'  => ' <span class="cs-text-warning">( '.__('鼠标经过LOGO时显示的文字信息','CS_TEXTDOMAIN').' )</span>',
            'dependency'   => array( 'login-logo-title_1', '==', 'true' ),
        ),

        array(
            'type'    => 'subheading',
            'content' => __('额外信息','CS_TEXTDOMAIN'),
        ),

        array(
            'id'     => 'login-form-info',
            'type'   => 'wysiwyg',
            'before' => '<h4>'.__('自定义登录框内容','CS_TEXTDOMAIN').'</h4>',
            'after'  => '<span class="cs-text-muted">'.__('说明：在登录框内添加额外的信息，显示在登录表单内','CS_TEXTDOMAIN').'</span>',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),

        array(
            'id'     => 'login-footer-text',
            'type'   => 'wysiwyg',
            'before' => '<h4>'.__('自定义页脚内容','CS_TEXTDOMAIN').'</h4>',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),

  )
); 