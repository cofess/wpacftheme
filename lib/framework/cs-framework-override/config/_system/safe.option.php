<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 安全设置        
// ------------------------------
$options[]   = array(
    'name'   => 'system-safe_section',
    'title'  => __('安全设置','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-shield',
    'fields' => array(

        array(
            'id'      => 'strict-user-register',
            'type'    => 'switcher',
            'title'   => __('严格用户注册验证','CS_TEXTDOMAIN'),
            'default' => true,
            'help'    => __('昵称和显示名称都是唯一的，并且用户名中不允许出现非法关键词（非法关键词是在 设置 & 讨论 中 评论审核 和 评论黑名单 中定义的关键词）。','CS_TEXTDOMAIN'),
        ),

        array(
            'id'      => 'show-user-last-login-date',
            'type'    => 'switcher',
            'title'   => __('记录用户上次登录时间','CS_TEXTDOMAIN'),
            'default' => true,
            'help'    => __('开启后会在用户登录时记录时间，并在用户列表中显示（注：无法获取使用社交账号登录的时间）。','CS_TEXTDOMAIN'),
        ),

        array(
            'id'       => 'disable-use-admin-login',
            'type'     => 'switcher',
            'title'    => __('禁止使用"admin"用户名尝试登录','CS_TEXTDOMAIN'),
            'default'  => true,
            'help'     => __('有很多机器在扫描博客的“admin”用户的密码，直接把登陆界面屏蔽了，不让其扫描，提高网站的安全性。','CS_TEXTDOMAIN'),
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'       => 'only-administrator-access-admin',
            'type'     => 'switcher',
            'title'    => __('只允许超级管理员访问后台','CS_TEXTDOMAIN'),
            'default'  => false,
            'after'    => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('启用后超级管理员以外的用户无法访问后台','CS_TEXTDOMAIN').'</span>',
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'       => 'disable-login-error-message',
            'type'     => 'switcher',
            'title'    => __('隐藏后台登录错误的提示信息','CS_TEXTDOMAIN'),
            'default'  => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'       => 'disable-share-account',
            'type'     => 'switcher',
            'title'    => __('禁止用户共享账号','CS_TEXTDOMAIN'),
            'help'     => __('网站如果提供付费服务，可能需要禁止用户共享账号，也就是要禁止多个人同时登录一个账号。','CS_TEXTDOMAIN'),
            'default'  => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'login-encryption',
            'type'    => 'switcher',
            'title'   => __('加密后台登录地址','CS_TEXTDOMAIN'),
            'default' => false,
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('修改后台登录地址，提高安全性','CS_TEXTDOMAIN').'</span>',
        ),

        array(
            'id'         => 'login-redirect-url',
            'type'       => 'text',
            'title'      => __('验证失败，重定向到','CS_TEXTDOMAIN'),
            'default'    => site_url(),
            'after'      => ' <span class="cs-text-muted">'.__('默认返回网站首页','CS_TEXTDOMAIN').'</span>',
            'dependency' => array( 'login-encryption', '==', 'true' ),
            'attributes' => array(
                'type'        => 'url',
                'placeholder' => 'http://',
                'style'       => 'margin-right: 5px;'
            )
        ),

        array(
            'id'         => 'login-private-Key',
            'type'       => 'text',
            'title'      => __('验证密钥','CS_TEXTDOMAIN'),
            'after'      => ' <span class="cs-text-muted">'.__('您当前的登录地址为：','CS_TEXTDOMAIN').''.$current_login_url.'</span>',
            'dependency' => array( 'login-encryption', '==', 'true' ),
            'attributes' => array(
                'placeholder' => __('输入密钥','CS_TEXTDOMAIN'),
            )
        ),
      
    )
);