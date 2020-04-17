<?php 

if ( ! defined( 'ABSPATH' ) ) { die; }

// ------------------------------
// 网站维护                      
// ------------------------------
$options[]   = array(
    'name'     => 'system-maintenance_section',
    'title'    => __('维护模式','CS_TEXTDOMAIN'),
    'icon'     => 'fa fa-bug',
    'fields'   => array(
  
        array(
            'type'    => 'subheading',
            'content' => __('基本设置','CS_TEXTDOMAIN'),
        ),
    
        array(
            'id'    => 'maintenance-mode',
            'type'  => 'switcher',
            'title' => __('网站维护','CS_TEXTDOMAIN'),
            'after' => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('启用网站维护模式后，网站无法正常访问','CS_TEXTDOMAIN').'</span>',
        ),
  
        array(
            'id'      => 'enable-maintenance-notice',
            'type'    => 'switcher',
            'title'   => __('维护通知','CS_TEXTDOMAIN'),
            'after'   => '<span class="cs-text-muted" style="margin-left:5px;line-height:26px">'.__('启用后，将在后台提示您网站正处于维护模式','CS_TEXTDOMAIN').'</span>',
            'default' => true,
        ),
    
        // array(
        //     'id'      => 'maintenance-503',
        //     'type'    => 'switcher',
        //     'title'   => __('503 HTTP状态码','CS_TEXTDOMAIN'),
        //     'default' => true,
        //     'label'   => __('503是一种HTTP状态码,表示由于临时的服务器维护或者过载，服务器当前无法处理请求','CS_TEXTDOMAIN'),
        // ),
  
        array(
            'id'       => 'maintenance-page-title',
            'type'     => 'text',
            'title'    => __('维护页面标题','CS_TEXTDOMAIN'),
            'after'    => ' <small class="cs-text-warning">'.__('( * 必填 )','CS_TEXTDOMAIN').'</small>',
            'default'  => __('网站维护中','CS_TEXTDOMAIN'),
            'attributes'    => array(
                'placeholder' => __('例如：网站维护中','CS_TEXTDOMAIN'),
            )
        ),
    
        array(
            'id'       => 'maintenance-subject',
            'type'     => 'text',
            'title'    => __('维护主题','CS_TEXTDOMAIN'),
            'after'    => ' <small class="cs-text-warning">'.__('( * 必填 )','CS_TEXTDOMAIN').'</small>',
            'default'  => __('网站例行维护','CS_TEXTDOMAIN'),
            'attributes'    => array(
                'placeholder' => __('例如：网站例行维护','CS_TEXTDOMAIN'),
            )
        ),
    
        array(
            'id'         => 'maintenance-complete-date',
            'type'       => 'text',
            'title'      => __('维护完成时间','CS_TEXTDOMAIN'),
            'after'      => ' <span class="cs-text-muted">'.__('例如：2015/01/01，时间格式：年/月/日','CS_TEXTDOMAIN').'</span>',
            'attributes' => array(
                'style' => 'width: 100px;margin-right: 5px;',
            ),
            //'validate' => 'required',
        ),
  
        array(
            'id'      => 'enable-maintenance-autoend',
            'type'    => 'switcher',
            'title'   => __('到达指定的维护完成时间自动结束维护模式','CS_TEXTDOMAIN'),
            'default' => true,
        ),
    
        array(
            'id'       => 'maintenance-content',
            'type'     => 'wysiwyg',
            'title'    => __('维护内容','CS_TEXTDOMAIN'),
            'info'     => '<p class="cs-text-muted">'.__('例如：网站临时维护中，请稍后访问，程序员正在疯狂加班！','CS_TEXTDOMAIN').'</p>',
            'default'  => __('网站临时维护中，请稍后访问，程序员正在疯狂加班！','CS_TEXTDOMAIN'),
            'settings' => array(
                'textarea_rows' => 3,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),
  
        array(
            'id'       => 'maintenance-footer',
            'type'     => 'wysiwyg',
            'title'    => __('页脚内容','CS_TEXTDOMAIN'),
            // 'info'     => '<p class="cs-text-muted">'.__('例如：网站版权信息！','CS_TEXTDOMAIN').'</p>',
            //'default'  => 'Copyright ©&nbsp;'.date('Y').'&nbsp;'.get_bloginfo('name'). __('版权所有','CS_TEXTDOMAIN'),
            'settings' => array(
                'textarea_rows' => 3,
                'tinymce'       => false,
                'media_buttons' => false,
            )
        ),
    
        array(
            'id'    => 'maintenance-ip-whitelist',
            'type'  => 'textarea',
            'title' => __('IP白名单','CS_TEXTDOMAIN'),
            'after' => '<span class="cs-text-warning">'.__('一个IP地址一行，仅IP地址包含在IP白名单中的设备可访问网站','CS_TEXTDOMAIN').'</span>',
        ),
    
        array(
            'id'      => 'enable-maintenance-social',
            'type'    => 'switcher',
            'title'   => __('显示社交链接','CS_TEXTDOMAIN'),
            'default' => false,
        ),
  
        array(
            'type'    => 'subheading',
            'content' => __('外观设置','CS_TEXTDOMAIN'),
        ),
  
        array(
            'id'      => 'maintenance-background-color',
            'type'    => 'color_picker',
            'title'   => __('页面整体背景色（body）','CS_TEXTDOMAIN'),
            'default' => '#f1f1f1',
            'rgba'    => false,
        ),
  
        array(
            'id'    => 'maintenance-background',
            'type'  => 'background',
            'title' => __('页面背景图片','CS_TEXTDOMAIN'),
            'desc'  => __('设置维护页面背景','CS_TEXTDOMAIN'),
            'default'      => array(
                'image'      => get_template_directory_uri()."/lib/images/bg/parallax4.jpg",
                'repeat'     => 'no-repeat',
                'position'   => 'center center',
                'attachment' => 'fixed',
                'color'      => '#f1f1f1',
            ),
        ),
    
        array(
            'id'      => 'maintenance-subject-color',
            'type'    => 'color_picker',
            'title'   => __('维护主题文字颜色','CS_TEXTDOMAIN'),
            'default' => '#ea5504',
            //'rgba'    => false,
        ),
  
        array(
            'id'      => 'maintenance-content-color',
            'type'    => 'color_picker',
            'title'   => __('维护内容文字颜色','CS_TEXTDOMAIN'),
            //'default' => '#333333',
            //'rgba'    => false,
        ),
  
        array(
            'id'      => 'maintenance-footer-color',
            'type'    => 'color_picker',
            'title'   => __('页脚内容文字颜色','CS_TEXTDOMAIN'),
            //'default' => '#666666',
            //'rgba'    => false,
        ),
  
        array(
            'id'      => 'maintenance-date-color',
            'type'    => 'color_picker',
            'title'   => __('维护完成时间文字颜色','CS_TEXTDOMAIN'),
            'default' => '#ea5504',
            //'rgba'    => false,
        ),
    
        array(
            'id'    => 'maintenance-custom-style',
            'type'  => 'textarea',
            'title' => __('自定义CSS样式','CS_TEXTDOMAIN'),
            'after' => '<span class="cs-text-warning">'.__('无需使用&lt;style&gt;标签','CS_TEXTDOMAIN').'</span>',
        ),
  
    )
  );