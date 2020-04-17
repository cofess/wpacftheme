<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 邮件设置               
// ------------------------------
$options[]   = array(
    'name'     => 'system-smtp_section',
    'title'    => __('邮件设置','CS_TEXTDOMAIN'),
    'icon'     => 'fa fa-envelope',
    'fields'   => array(

        array(
            'type'    => 'subheading',
            'content' => __('基本设置','CS_TEXTDOMAIN'),
        ),
    
        array(
            'id'       => 'mail-smtp',
            'type'     => 'switcher',
            'title'    => __('启用SMTP发送邮件','CS_TEXTDOMAIN'),
            'default'  => false,
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('如果安装其他SMTP插件，请关闭','CS_TEXTDOMAIN').'</span>',
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),
  
        array(
            'id'      => 'smtp-host',
            'type'    => 'text',
            'title'   => __('SMTP服务器','CS_TEXTDOMAIN'),
            'default' => 'mail.example.com',
            'attributes'    => array(
                'placeholder' => __('SMTP服务器器地址','CS_TEXTDOMAIN'),
            ),
        ),
    
        array(
            'id'         => 'smtp-port',
            'type'       => 'text',
            'title'      => __('SMTP端口','CS_TEXTDOMAIN'),
            'default'    => '25',
            'attributes' => array(
                'style' => 'width: 50px;margin-right: 5px;'
            ),
        ),
  
        array(
            'id'      => 'smtp-secure',
            'type'    => 'radio',
            'title'   => __('SMTP加密方式','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                'none'=> __('无','CS_TEXTDOMAIN'),
                'ssl' => __('SSL','CS_TEXTDOMAIN'),
                'tls' => __('TLS','CS_TEXTDOMAIN'),
            ),
            'default' => 'ssl',
        ),
    
        array(
            'id'      => 'smtp-auth',
            'type'    => 'radio',
            'title'   => __('SMTP身份验证','CS_TEXTDOMAIN'),
            'class'   => 'horizontal',
            'options' => array(
                'no'   => 'No',
                'yes'   => 'Yes',
            ),
            'default' => 'yes',
            'help'   => __('启用SMTP身份验证则以下的账户、密码字段必填','CS_TEXTDOMAIN'),
        ),      
    
        array(
            'id'         => 'smtp-auth-email',
            'type'       => 'text',
            'title'      => __('账户（电子邮件地址）','CS_TEXTDOMAIN'),
            'dependency' => array( 'smtp-auth_yes', '==', 'true' ),
            'attributes' => array( 
                'autocomplete' => "off",
                'type' => 'email'
            )
        ),
  
        array(
            'id'         => 'smtp-auth-pass',
            'type'       => 'text',
            'title'      => __('密码','CS_TEXTDOMAIN'),
            'dependency' => array( 'smtp-auth_yes', '==', 'true' ),
            'attributes' => array(
                'autocomplete' => "off", 
                'type' => 'password'
            )
        ),
    
        array(
            'type'    => 'subheading',
            'content' => __('默认发件人','CS_TEXTDOMAIN'),
        ),
    
        array(
            'id'      => 'smtp-from-name',
            'type'    => 'text',
            'title'   => __('发件人昵称','CS_TEXTDOMAIN'),
        ),
    
        array(
            'id'         => 'smtp-from-email',
            'type'       => 'text',
            'title'      => __('发件人邮箱','CS_TEXTDOMAIN'),
            'after'      => ' <span class="cs-text-muted">'.__('主要用于用户回复您时的邮件接收邮箱','CS_TEXTDOMAIN').'</span>',
            'attributes' => array( 
                'type' => 'email'
            )
        ),
  
    )
);