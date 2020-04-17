<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 系统入口               
// ------------------------------
$options[]   = array(
    'name'   => 'system-entrance_section',
    'title'  => __('系统入口','CS_TEXTDOMAIN'),
    'icon'   => 'fa fa-toggle-on',
    'fields' => array(

        array(
            'id'      => 'remove-screen-options-tab',
            'type'    => 'switcher',
            'title'   => __('移除后台“显示选项”','CS_TEXTDOMAIN'),
            'desc'    => __('移除右上角“显示选项”（对管理员无效）','CS_TEXTDOMAIN'),
            'default' => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'remove-help-tab',
            'type'    => 'switcher',
            'title'   => __('移除后台“帮助”','CS_TEXTDOMAIN'),
            'desc'    => __('右上角“帮助”','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'hide-dashboard-menu',
            'type'    => 'switcher',
            'title'   => __('移除“仪表盘”菜单','CS_TEXTDOMAIN'),
            'desc'    => __('只有特定权限的用户可以访问，其他用户访问自动跳转','CS_TEXTDOMAIN'),
            'default' => false,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ), 

        array(
            'id'      => 'disable-file-editor',
            'type'    => 'switcher',
            'title'   => __('禁止编辑主题和插件','CS_TEXTDOMAIN'),
            'desc'    => __('对网站管理员群组用户无效','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'disable-theme-customizer',
            'type'    => 'switcher',
            'title'   => __('禁用主题定制器','CS_TEXTDOMAIN'),
            'desc'    => __('对网站管理员群组用户无效','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

        array(
            'id'      => 'remove-theme-menu',
            'type'    => 'switcher',
            'title'   => __('移除“外观->主题”菜单','CS_TEXTDOMAIN'),
            'desc'    => __('对网站管理员群组用户无效','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),       

        array(
            'id'      => 'remove-plugin-action-links',
            'type'    => 'switcher',
            'title'   => __('移除插件列表的“编辑”和“删除”链接','CS_TEXTDOMAIN'),
            'default' => true,
            'settings' => array(
                'on_text'  => __('是','CS_TEXTDOMAIN'),
                'off_text' => __('否','CS_TEXTDOMAIN'),
            ),
        ),

    ), // end: fields

);